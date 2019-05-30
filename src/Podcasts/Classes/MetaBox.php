<?php

namespace Podcasts\Classes;


use Podcasts\Utils\Assets;

class MetaBox
{
    use Assets;

    public static $fieldPrefix = 'podcats';
    public static $field = '_podcats_meta';
    private $typesPosts;
    private $typePost;
    private $default = [];

    public function __construct()
    {
        $this->default = [
            'audio' => false,
            'description' => false,
            'extra' => false,
            'explicit' => 'no',
            'block' =>'no',
        ];

        $this->typePost = TypePosts::$type;
        $this->typesPosts = [TypePosts::$type];
        add_action('admin_init', [$this, 'addFields']);
        add_action('save_post', [$this, 'save'], 0);
        add_action('current_screen', [$this, 'scripts']);
    }

    public function scripts()
    {
        $screen = get_current_screen();
        if ('post' == $screen->base && $this->typePost == $screen->post_type) {
            $this->addJs('uploader', 'admin');
        }
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
            'Audio Blogs',
            'Business' => [
                'Careers',
                'Finance',
                'Investing',
                'Management',
                'Marketing',
            ],
            'Comedy',
            'Education' => [
                'K-12',
                'Higher Education'
            ],
            'Food',
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
            'Music',
            'News',
            'Politics',
            'Public Radio',
            'Religion & Spirituality' => [
                'Buddhism',
                'Christianity',
                'Islam',
                'Judaism',
                'New Age',
                'Philosophy',
                'Spirituality',
            ],
            'Science',
            'Sports',
            'Talk Radio',
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
            'Travel'
        ];
    }

    /**
     * Добавляем метабокс
     */
    public function addFields()
    {
        add_meta_box(
            'podcats_metabox',
            __('Дополнительные поля', 'Podcasts'),
            [$this, 'markup'],
            $this->typesPosts,
            'normal',
            'high'
        );
    }


    public function markup($post)
    {
        ?>
        <p>
            <label>
                audio:
                <br>
                <input type="text" name="<?php echo self::$fieldPrefix; ?>[audio]"
                       value="<?php echo $this->getData($post->ID, 'audio'); ?>"
                />
            </label>
        </p>

        <p>
            <label>
                keywords:
                <br>
                <textarea type="text" maxlength="255" name="<?php echo self::$fieldPrefix; ?>[keywords]"><?php echo $this->getData($post->ID, 'keywords'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                description:
                <br>
                <textarea type="text" name="<?php echo self::$fieldPrefix; ?>[description]"><?php echo $this->getData($post->ID, 'description'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                extra<br>
                <textarea type="text" name="<?php echo self::$fieldPrefix; ?>[extra]"><?php echo $this->getData($post->ID, 'extra'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                subtitle<br>
                <textarea type="text" name="<?php echo self::$fieldPrefix; ?>[subtitle]"><?php echo $this->getData($post->ID, 'subtitle'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                summary<br>
                <textarea type="summary" maxlength="4000" name="<?php echo self::$fieldPrefix; ?>[summary]"><?php echo $this->getData($post->ID, 'summary'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                copyright<br>
                <input type="text" name="<?php echo self::$fieldPrefix; ?>[copyright]" value="<?php echo $this->getData($post->ID, 'copyright'); ?>"/>
            </label>
        </p>

        <p>
            <label>
                link<br>
<!--                https://creativecommons.org/licenses/by/4.0/-->
                <input type="link" name="<?php echo self::$fieldPrefix; ?>[link]" value="<?php echo $this->getData($post->ID, 'link'); ?>"/>
            </label>
        </p>

        <p>
            <label>
                author<br>
                <input type="email" name="<?php echo self::$fieldPrefix; ?>[author]" value="<?php echo $this->getData($post->ID, 'author'); ?>"/>
            </label>
        </p>

        <p>
            <label>
                explicit: <br>
                <select name="<?php echo self::$fieldPrefix; ?>[explicit]">
                    <?php $value = $this->getData($post->ID, 'explicit', 'explicit'); ?>
                    <option value="1" <?php selected($value, 'yes') ?> ><?php _e('Да', 'Podcasts'); ?></option>
                    <option value="2" <?php selected($value, 'no') ?> ><?php _e('Нет', 'Podcasts'); ?></option>
                </select>
            </label>
        </p>

        <p>
            <label>
                block: <br>
                <select name="<?php echo self::$fieldPrefix; ?>[block]">
                    <?php $value = $this->getData($post->ID, 'block', 'block'); ?>
                    <option value="1" <?php selected($value, 'yes') ?> ><?php _e('Да', 'Podcasts'); ?></option>
                    <option value="2" <?php selected($value, 'no') ?> ><?php _e('Нет', 'Podcasts'); ?></option>
                </select>
            </label>
        </p>

        <input type="hidden" name="<?php echo self::$fieldPrefix; ?>_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>"/>
        <?php
    }

    /**
     * Получение данных по умолчанию и данных метаполей
     *
     * @param $id - id поста
     * @param $key - индекс опцции
     * @param bool|string - false или строка/ключ мета поля
     * @return mixed
     */
    private function getData($id, $key, $name = false)
    {
        if (!empty($name)) {
            $metaKey = $name;
        } else {
            $metaKey = self::$field;
        }

        $meta = get_post_meta($id, $metaKey, true);

        $meta = wp_parse_args($meta, $this->default);

        return (isset($meta[$key]) ? $meta[$key] : false);
    }

    /**
     * Сохранение метаполей
     *
     * @param $id
     * @return bool
     */
    public function save($id)
    {

        if (empty($_POST[self::$fieldPrefix])) {
            return false;
        }

        if (!wp_verify_nonce($_POST[self::$fieldPrefix . '_fields_nonce'], __FILE__)) {
            return false;
        }

        if (wp_is_post_autosave($id) || wp_is_post_revision($id)) {
            return false;
        }

        $data = array_map('sanitize_text_field', $_POST[self::$fieldPrefix]);

        $data = wp_parse_args($data, $this->default);

        update_post_meta($id, self::$field, $data);

        return $id;
    }
}
