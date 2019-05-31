<?php

namespace Podcasts\Classes;


class Options
{

    public static $slug = 'podcasts-option';
    private $type;
    public static $optionCommonPrefix = 'podcasts-option';

    public function __construct($type)
    {
        $this->type = $type;
        add_action('admin_menu', [$this, 'subPage']);
    }

    //explicit
    //owner - email - name
    //image - 170x170 / 300x300 jpg png
    //block -optional

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

        $this->section('base', "Common settings", "<p> Settings </p>");

        $this->field(
            'base',
            'title',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required'
                ]
            ]
        );

        $this->field(
            'base',
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
            'base',
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
            'base',
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
            'base',
            'author',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required'
                ]
            ]
        );

        $this->field(
            'base',
            'copyright',
            [
                'tag' => 'input',
                'attrs' => [
                    'required' => 'required'
                ]
            ]
        );

        $this->field(
            'base',
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

        register_setting(self::$slug, self::$optionCommonPrefix);
    }

    private function field($sectionPrefix, $name = '', $data = '')
    {
        add_settings_field(
            self::$slug . "_{$name}_field",
            $name,
            function () use ($name, $data) {
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

        $commonNamePrefix = self::$optionCommonPrefix;

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
            $out .= "<section name='{$commonNamePrefix}[{$data['name']}]' class='{$class}' {$attributes()} >";
            foreach ($data['options'] as $key => $value) {
                d($key , $value);
                $out .= "<option value='{$key}' " . selected($data['selected'], $key, false) . " >{$value}</option>";
            }
            $out .= "</section>";
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
