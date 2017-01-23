<?php
/**
 *
 * @package   Menu_Cusomizer
 * @author    Liondekam <info@crumina.net>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 *
 * @wordpress-plugin
 * Plugin Name: Crumina Menu Customizer
 * Plugin URI:  http://crumina.net
 * Description: Customization of wordpress menu items
 * Version:     1.5.9
 * Author:      Liondekam
 * Author URI:  http://crumina.net
 * Text Domain: crum
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-metro-walker.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class-menu-customizer.php' );



register_activation_hook( __FILE__, array( 'Menu_Cusomizer', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Menu_Cusomizer', 'deactivate' ) );


Menu_Cusomizer::get_instance();