<?php
/**
 *
 * @package   Crumina page slider
 * @author    Liondekam <liondekam@gmail.com>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2013 Crumina Team
 *
 * @wordpress-plugin
 * Plugin Name: Crumina page slider
 * Plugin URI:  http://crumina.net
 * Description: Slider of pages / posts
 * Version:     1.4.3
 * Author:      Liondekam
 * Author URI:  http://crumina.net
 * Text Domain: crumina-page-slider
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-crumina-page-slider.php' );

if (!function_exists('mr_image_resize') ) {
	require_once(plugin_dir_path( __FILE__ ) . 'inc/mr-image-resize.php' );
}

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.

// Activation hook for creating the initial DB table
register_activation_hook( __FILE__, array( 'Crum_Page_Slider', 'activate' ) );


Crum_Page_Slider::get_instance();