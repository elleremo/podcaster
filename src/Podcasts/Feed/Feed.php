<?php

namespace Podcasts\Feed;


class Feed
{
    private $version;
    private $plugin_path;
    public static $slug = 'podcast';

    function __construct($instance)
    {
        $this->plugin_path = $instance->path;
        $this->version = $instance->version;

        register_activation_hook($instance->file, [$this, 'activate']);
        register_deactivation_hook($instance->file, [$this, 'deactivate']);

        add_action("template_redirect", [$this, "template_rule"]);
        add_action('init', [$this, 'addFeed']);
    }

    public function addFeed()
    {
        add_feed(self::$slug, [$this, 'markup']);
    }

    function template_rule()
    {
        global $wp_query;
        if (strpos($wp_query->query_vars['feed'], self::$slug) !== false) {
            $wp_query->is_404 = false;
            $wp_query->have_posts = true;
            $wp_query->is_archive = true;
        }
    }

    function markup()
    {
        header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
        status_header(200);

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
