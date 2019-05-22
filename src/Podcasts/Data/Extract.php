<?php


namespace Podcasts\Data;


use Podcasts\Classes\File;
use Podcasts\Classes\MetaBox;

class Extract
{
    private $filed;

    public function __construct()
    {
        $this->filed = MetaBox::$field;
    }

    /**
     * Получение метаданных
     * @param $id
     * @return mixed
     */
    public function getData($id)
    {
        if (is_array($id)) {
            $id = $id['ID'];
        } elseif (is_object($id)) {
            $id = $id->ID;
        }

        $meta = get_post_meta($id, $this->filed, true);

        $default = MetaBox::getDefaultFields();

        $meta = wp_parse_args($meta, $default);

        foreach ($meta as $key => $value) {

            if (in_array($key, ['audio'])) {
                $meta[$key] = (int)$value;
            } else {
                $meta[$key] = $value;
            }
        }

        return $meta;
    }

    public function prepareMeta($data)
    {
        $file = new File($data['audio']);

        $data['audio_meta']['fileSize'] = $file->getSize();
        $data['audio_meta']['type'] = $file->getMimeType();
        $data['audio_meta']['url'] = $file->getFileUrl();
        $data['audio_meta']['duration'] = $file->getDuration();

        return $data;
    }

    public function preparePost($posts)
    {
        return array_map(
            function ($post) {
                $out = [];

                $out['ID'] = $post->ID;
                $out['guid'] = $this->getGuid($post);
                $out['post_date'] = $post->post_date_gmt;
                $out['post_title'] = $post->post_title;
                $out['raw_meta'] = $this->getData($post);
                $out['thumbnail'] = get_the_post_thumbnail_url($post, 'large');
                $out['meta'] = $this->prepareMeta($this->getData($post));

                return $out;
            },
            $posts
        );
    }


    /**
     * Get post guid
     * @param int $post
     * @return mixed|void
     */
    private function getGuid($post = 0)
    {
        $post = get_post($post);

        $guid = isset($post->guid) ? get_the_guid($post) : '';
        $id = isset($post->ID) ? $post->ID : 0;

        return apply_filters('the_guid', $guid, $id);
    }
}
