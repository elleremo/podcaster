<?php

namespace Podcasts\Feed;


use Podcasts\Classes\TemplateHelper;

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

        return $class->getTemplatePart($name);
    }

    public function markup()
    {
        header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
        status_header(200);

        echo $this->template('feed');

        exit;
    }

    public function activate()
    {
        flush_rewrite_rules();
    }

    public function deactivate()
    {
        flush_rewrite_rules();
    }
}
