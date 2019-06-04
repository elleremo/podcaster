<?php

namespace Podcasts\Classes;


use Podcasts\Data\ExtractOptions;
use Podcasts\Utils\Assets;

class Options
{
    use Assets;

    public static $slug = 'podcasts-option';
    private $type;
    private $fieldsValues = [];

    public function __construct($type)
    {
        $this->type = $type;
        $options = new ExtractOptions(self::$slug);
        $this->fieldsValues = $options->getData();

        add_action('admin_menu', [$this, 'subPage']);
        add_action('current_screen', [$this, 'addJsCss']);
    }

    public function addJsCss()
    {

        $screen = get_current_screen();

        if ("podcast_page_podcasts-option" == $screen->base) {


            add_action('admin_enqueue_scripts', function () {
                wp_enqueue_media();
            }, 1);

            $handle = $this->addJs('Media', 'admin');
            add_action('admin_enqueue_scripts', function () use ($handle) {

                wp_localize_script(
                    $handle
                    , 'PodcastsImageUploaderLocalize',
                    [
                        'title' => __('Select image', 'Podcasts'),
                        'button' => __('Select', 'Podcasts')
                    ]
                );

            });

        }
    }

    //owner - email - name
    //image - 170x170 / 300x300 jpg png

    public function subPage()
    {
        add_submenu_page(
            "edit.php?post_type={$this->type}",
            'Podcasts settings',
            'Podcasts options',
            'edit_others_posts',
            self::$slug,
            [$this, 'PageContent']
        );

        $baseSection = $this->section('base', "Common settings", "<p> Settings </p>");

        $this->field(
            $baseSection,
            'title',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required'
                ]
            ]
        );

        $this->field(
            $baseSection,
            'link',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required',
                    'type' => 'url'
                ]
            ]
        );

        $this->field(
            $baseSection,
            'subtitle',
            [
                'tag' => 'textarea',
                'attrs' => [
                    'required' => 'required',
                    'rows' => 6,
                ]
            ]
        );

        $this->field(
            $baseSection,
            'summary',
            [
                'tag' => 'textarea',
                'attrs' => [
                    'required' => 'required',
                    'rows' => 6,
                ]
            ]
        );

        $this->field(
            $baseSection,
            'author',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required'
                ]
            ]
        );

        $this->field(
            $baseSection,
            'copyright',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required'
                ]
            ]
        );

        $this->field(
            $baseSection,
            'email',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required',
                    'type' => 'email',
                ]
            ]
        );

        $this->field(
            $baseSection,
            'explicit',
            [
                'tag' => 'select',
                'attrs' => [
                    'required' => 'required'
                ],
                'options' => [
                    'yes' => 'yes',
                    'no' => 'no',
                    'clean' => 'clean'
                ],
                'selected' => 'clean',
            ]
        );

        $this->field(
            $baseSection,
            'block',
            [
                'tag' => 'select',
                'attrs' => [
                    'required' => 'required'
                ],
                'options' => [
                    'yes' => 'yes',
                    'no' => 'no',
                ],
                'selected' => 'no',
            ]
        );

        $this->field(
            $baseSection,
            'image',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required',
                    'type' => 'number',
                ]
            ]
        );

        $ownerSection = $this->section('owner', "Common settings", "<p> Owner </p>");

        $this->field(
            $ownerSection,
            'owner_name',
            [
                'label' => __('Owner name','Podcasts'),
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required',
                    'type' => 'text',
                ]
            ]
        );

        $this->field(
            $ownerSection,
            'owner_email',
            [
                'label' => __('Owner email','Podcasts'),
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required',
                    'type' => 'email',
                ]
            ]
        );

        register_setting(self::$slug, self::$slug);
    }

    private function field($sectionPrefix, $name = '', $data = [])
    {
        $value = $this->fieldsValues;

        add_settings_field(
            self::$slug . "_{$name}_field",
            isset($data['label']) ? $data['label'] : $name,
            function () use ($value, $name, $data) {
                $data['value'] = (isset($value[$name]) ? $value[$name] : '');
                echo $this->fieldRender($name, $data);
            },
            self::$slug,
            self::$slug . "_{$sectionPrefix}_section"
        );
    }

    private function fieldRender($name, $data)
    {
        $default = [
            'tag' => 'input',
            'name' => $name,
            'attrs' => [],
            'value' => ''
        ];

        if ('select' == $data['tag']) {
            $default['options'] = [];
            $default['selected'] = '';
        }

        $data = wp_parse_args($data, $default);

        $commonNamePrefix = self::$slug;

        $class = ' regular-text ';

        if (isset($data['attrs']['class'])) {
            $class .= $data['attrs']['class'];
            unset($data['attrs']['class']);
        }

        $attributes = function () use ($data) {
            $out = '';
            if (empty($data['attrs'])) {
                return $out;
            }
            foreach ($data['attrs'] as $k => $v) {
                $out .= " {$k}='{$v}' ";
            }
            return $out;
        };

        $out = '';
        if ('input' == $data['tag']) {
            $out = "<input name='{$commonNamePrefix}[{$data['name']}]' value='{$data['value']}' class='{$class}' {$attributes()} >";
        } else if ('textarea' == $data['tag']) {
            $out = "<textarea name='{$commonNamePrefix}[{$data['name']}]' class='{$class}' {$attributes()} >{$data['value']}</textarea>";
        } else if ('select' == $data['tag']) {
            $out .= "<select name='{$commonNamePrefix}[{$data['name']}]' class='{$class}' {$attributes()} >";
            foreach ($data['options'] as $key => $value) {
                $out .= "<option value='{$key}' " . selected($data['selected'], $key, false) . " >{$value}</option>";
            }
            $out .= "</select>";
        }

        return $out;
    }

    private function section($prefix, $name = '', $html = '')
    {
        add_settings_section(
            self::$slug . "_{$prefix}_section",
            $name,
            function () use ($html) {
                echo $html;
            },
            self::$slug
        );

        return $prefix;
    }

    public function PageContent()
    {
        ?>
        <div class="wrap">
            <h2> <?php echo get_admin_page_title(); ?> </h2>
        </div>
        <form method="POST" action="options.php">
            <?php
            settings_fields(self::$slug);
            do_settings_sections(self::$slug);
            submit_button();
            ?>
        </form>
        <?php
    }

    public function categoriesSelectBox($name)
    {
        $categories = $this->categories();

        $html = '';
        $html .= "<select name='{$name}' multiple='multiple' required='required'>";

        $iterator = function ($array) {
            $html = '';

            foreach ($array as $key => $value) {
                $html .= "<option name='$value'>{$value}</option>";
            }
            return $html;
        };

        foreach ($categories as $key => $value) {
            if (is_string($value)) {
                $html .= "<option name='$value'>{$value}</option>";
            } else {
                $html .= "<optgroup label='{$key}'>";
                $html .= "<option name='$key'>{$key} (common)</option>";
                $html .= $iterator($value);
                $html .= "</optgroup>";
            }
        }
        $html .= "</select>";

        return $html;
    }

    /**
     * Возвращает категории подкастов
     *
     * @return array
     */
    public function categories()
    {
        return [
            'Arts & Entertainment' => [
                'Architecture',
                'Books',
                'Design',
                'Entertainment',
                'Games',
                'Performing Arts',
                'Photography',
                'Poetry',
                'Science Fiction',
            ],
            'Audio Blogs' => 'Audio Blogs',
            'Business' => [
                'Careers',
                'Finance',
                'Investing',
                'Management',
                'Marketing',
            ],
            'Comedy' => 'Comedy',
            'Education' => [
                'K-12',
                'Higher Education'
            ],
            'Food' => 'Food',
            'Health' => [
                'Diet & Nutrition',
                'Fitness',
                'Relationships',
                'Self-Help',
                'Sexuality',
            ],
            'International' => [
                'Australian',
                'Belgian',
                'Brazilian',
                'Canadian',
                'Chinese',
                'utch',
                'French',
                'German',
                'Hebrew',
                'Italian',
                'Japanese',
                'Norwegian',
                'Polish',
                'Portuguese',
                'Spanish',
                'Swedish',
            ],
            'Movies & Television',
            'Music' => 'Music',
            'News' => 'News',
            'Politics' => 'Politics',
            'Public Radio' => 'Public Radio',
            'Religion & Spirituality' => [
                'Buddhism',
                'Christianity',
                'Islam',
                'Judaism',
                'New Age',
                'Philosophy',
                'Spirituality',
            ],
            'Science' => 'Science',
            'Sports' => 'Sports',
            'Talk Radio' => 'Talk Radio',
            'Technology' => [
                'Computers',
                'Developers',
                'Gadgets',
                'Information Technology',
                'News',
                'Operating Systems',
                'Podcasting',
                'Smart Phones',
                'Text/Speech',
            ],
            'Travel' => 'Travel',
        ];
    }

}
