<?php

namespace Podcasts\Classes;


class MetaBox
{
    public static $fieldPrefix = 'podcats';
    public static $field = '_podcats_meta';

    private $typesPosts;

    public function __construct()
    {
        $this->typesPosts = [TypePosts::$type];
        add_action('admin_init', [$this, 'addFields']);
        add_action('save_post', [$this, 'save'], 0);
    }


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
                       value="<?php echo get_post_meta($post->ID, 'audio', 1); ?>"
                />
            </label>
        </p>

        <p>
            <label>
                description:
                <br>
                <textarea type="text" name="<?php echo self::$fieldPrefix; ?>[description]" style="width:100%;height:50px;"><?php echo get_post_meta($post->ID, 'description', 1); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                extra<br>
                <textarea type="text" name="<?php echo self::$fieldPrefix; ?>[extra]" style="width:100%;height:50px;"><?php echo get_post_meta($post->ID, 'extra', 1); ?></textarea>
            </label>
        </p>

        <p>
            <label>
                explicit: <br>
                <select name="<?php echo self::$fieldPrefix; ?>[explicit]">
                    <?php $value = get_post_meta($post->ID, 'explicit', 1); ?>
                    <option value="1" <?php selected($value, 'yes') ?> ><?php _e('Да', 'Podcasts'); ?></option>
                    <option value="2" <?php selected($value, 'no') ?> ><?php _e('Нет', 'Podcasts'); ?></option>
                </select>
            </label>
        </p>

        <input type="hidden" name="<?php echo self::$fieldPrefix; ?>_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>"/>
        <?php
    }


    public function save($post_id)
    {
        if (empty($_POST[self::$fieldPrefix])) {
            return false;
        }

        if (!wp_verify_nonce($_POST[self::$fieldPrefix . '_fields_nonce'], __FILE__)) {
            return false;
        }

        if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
            return false;
        }

        $_POST[self::$fieldPrefix] = array_map('sanitize_text_field', $_POST[self::$fieldPrefix]);
        foreach ($_POST[self::$fieldPrefix] as $key => $value) {
            if (empty($value)) {
                delete_post_meta($post_id, $key);
                continue;
            }

            update_post_meta($post_id, $key, $value);
        }

        return $post_id;
    }
}
