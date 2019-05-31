<?php

namespace Podcasts\Feed;


use Podcasts\Classes\TemplateHelper;
use Podcasts\Classes\TypePosts;
use Podcasts\Data\Extract;

class Feed
{
    private $version;
    private $plugin_path;
    public static $slug = 'podcast';
    private $instance;

    function __construct($instance)
    {
        $this->instance = $instance;
        $this->plugin_path = $instance->path;
        $this->version = $instance->version;

        register_activation_hook($instance->file, [$this, 'activate']);
        register_deactivation_hook($instance->file, [$this, 'deactivate']);

        add_action("template_redirect", [$this, "templateFile"]);
        add_action('init', [$this, 'addFeed']);
//        add_action('init', function (){
//            $class = new TemplateHelper($this->instance);
//
//            $extract = new Extract();
//            $atts = [];
//
//            $atts['extract'] = $extract;
//            $atts['posts'] = $extract->preparePost(get_posts([
//                'post_type' => TypePosts::$type
//            ]));
//            d($atts);
//
//        });
    }

    public function addFeed()
    {
        add_feed(self::$slug, [$this, 'markup']);
    }

    public function templateFile()
    {
        global $wp_query;
        if (strpos($wp_query->query_vars['feed'], self::$slug) !== false) {
            $wp_query->is_404 = false;
            $wp_query->have_posts = true;
            $wp_query->is_archive = true;
        }
    }

    public function template($name)
    {
        $class = new TemplateHelper($this->instance);

        $extract = new Extract();
        $atts = [];

        $atts['extract'] = $extract;
        $atts['posts'] = $extract->preparePost(get_posts([
            'post_type' => TypePosts::$type
        ]));

        return $class->getTemplatePart($name, $atts);
    }

    public function markup()
    {
        header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
        status_header(200);

        echo $this->template('feed');

        exit;
    }

    public static function activate()
    {
        add_feed(self::$slug, '__return_empty_string');
        flush_rewrite_rules();
    }

}
