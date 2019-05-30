<?php
/*
Plugin Name: Podcasts plugin
Author: Elleremo
Text Domain: Podcasts
Domain Path: /languages
Requires PHP: 7.0
Version: 1.0.0
License: GPLv3
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once(plugin_dir_path(__FILE__) . "includes/Autoloader.php");

if (file_exists(plugin_dir_path(__FILE__) . "vendor/autoload.php")) {
    require_once(plugin_dir_path(__FILE__) . "vendor/autoload.php");
}

use Podcasts\Autoloader;

new Autoloader(__FILE__, 'Podcasts');

use Podcasts\Base\Wrap;
use Podcasts\Classes\MetaBox;
use Podcasts\Classes\TypePosts;
use Podcasts\Feed\Feed;

class Podcasts extends Wrap
{
    public $version = '1.0.0';

    public function __construct()
    {
        new TypePosts();
        new MetaBox();
        new Feed($this);
    }

    /**
     * On activate plugin
     */
    public function activate()
    {
        Feed::activate();
        flush_rewrite_rules();
    }

    /**
     * On deactivate plugin
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}

register_activation_hook(__FILE__, ['Podcasts', 'activate']);
register_deactivation_hook(__FILE__, ['Podcasts', 'deactivate']);

function Podcasts__init()
{
    new Podcasts();
}

add_action('plugins_loaded', 'Podcasts__init', 21);
