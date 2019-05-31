<?php

namespace Podcasts\Classes;


class Options
{

    public static $slug = 'podcasts-option';
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
        add_action('admin_menu', [$this, 'subPage']);
    }

    // TODO see https://github.com/petrozavodsky/Tstore/blob/master/src/Tstore/Shop/PageOptions.php
    public function subPage()
    {
        add_submenu_page(
            "edit.php?post_type=" . self::$slug,
            'Podcasts settings',
            'Podcasts options',
            'edit_others_posts',
            self::$slug,
            [$this, 'PageContent']
        );
    }

    public function PageContent(){
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

    //explicit
    //subtitle
    //summary
    //author
    //owner - email - name
    //image - 170x170 / 300x300 jpg png
    //block -optional
    //copyright
    // link - website link

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
