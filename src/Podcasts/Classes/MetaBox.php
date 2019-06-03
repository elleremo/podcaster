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
        $this->default = $this->getDefaultFields();

        $this->typePost = TypePosts::$type;
        $this->typesPosts = [TypePosts::$type];
        add_action('admin_init', [$this, 'addFields']);
        add_action('save_post', [$this, 'save'], 0);
        add_action('current_screen', [$this, 'scripts']);
    }

    public static function getDefaultFields()
    {
        return [
            'audio' => false,
            'description' => false,
            'extra' => false,
            'explicit' => 'no',
            'block' => 'no',
        ];
    }

    public function scripts()
    {
        $screen = get_current_screen();
        if ('post' == $screen->base && $this->typePost == $screen->post_type) {
            $handle = $this->addJs('uploader', 'admin');

            add_action('admin_enqueue_scripts', function () use ($handle) {

                wp_localize_script(
                    $handle
                    , 'PodcastsUploaderLocalize',
                    [
                        'title' => __('Select audio file', 'Podcasts'),
                        'button' => __('Select', 'Podcasts')
                    ]
                );

            });

        }
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
                extra:<br>
                <textarea type="text" name="<?php echo self::$fieldPrefix; ?>[extra]"><?php echo $this->getData($post->ID, 'extra'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                subtitle:<br>
                <textarea type="text" name="<?php echo self::$fieldPrefix; ?>[subtitle]"><?php echo $this->getData($post->ID, 'subtitle'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                summary:<br>
                <textarea type="summary" maxlength="4000" name="<?php echo self::$fieldPrefix; ?>[summary]"><?php echo $this->getData($post->ID, 'summary'); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                author: <br>
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
                    <option value="yes" <?php selected($value, 'yes') ?> ><?php _e('Да', 'Podcasts'); ?></option>
                    <option value="no" <?php selected($value, 'no') ?> ><?php _e('Нет', 'Podcasts'); ?></option>
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

        array_map('trim', $data);

        update_post_meta($id, self::$field, $data);

        return $id;
    }
}
