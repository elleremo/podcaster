<?php
/*
Plugin Name: Podcasts plugin
Author: Elleremo
Text Domain: Podcasts
Domain Path: /languages
Requires PHP: 7.0
Version: 1.0.1
License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( plugin_dir_path( __FILE__ )."includes/Autoloader.php" );

if(file_exists(plugin_dir_path(__FILE__)."vendor/autoload.php")) {
    require_once(plugin_dir_path(__FILE__) . "vendor/autoload.php");
}

use Podcasts\Autoloader;

new Autoloader( __FILE__, 'Podcasts' );

use Podcasts\Base\Wrap;

class Podcasts extends Wrap {
	public $version = '1.0.1';

	public function __construct() {

	}

}

function Podcasts__init() {
	new Podcasts();
}

add_action( 'plugins_loaded', 'Podcasts__init', 30 );
