<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://viserlab.com
 * @since             1.0.0
 * @package           Viserlab
 *
 * @wordpress-plugin
 * Plugin Name:       Viserlab
 * Plugin URI:        https://viserlab.com/products/wordpress
 * Description:       Starter plugin pack for viserlab
 * Version:           1.0
 * Author:            Viserlab
 * Author URI:        https://viserlab.com
 * Text Domain:       viserlab
 * Domain Path:       /languages
 */

use Viserlab\Hook\Hook;
use Viserlab\Includes\Activator;

require_once __DIR__.'/vendor/autoload.php';
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define('VISERLAB_PLUGIN_VERSION', viser_system_details()['version']);
define('VISERLAB_PLUGIN_NAME', viser_system_details()['real_name']);
define('VISERLAB_ROOT', plugin_dir_path(__FILE__));

include_once(ABSPATH . 'wp-includes/pluggable.php');


$activator = new Activator();
register_activation_hook( __FILE__, [$activator, 'activate']);
register_deactivation_hook( __FILE__, [$activator, 'deactivate']);


$system = viser_system_instance();
$system->bootMiddleware();
$system->handleRequestThroughRouter();

$hook = new Hook;
$hook->init();