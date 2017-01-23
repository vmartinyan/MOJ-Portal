<?php
/*
Plugin Name: Metro Visual Builder
Plugin URI: http://www.crumina.net/
Description: Content builder with drag and drop function
Version: 1.9.6
Author: Crumina
Author URI: http://www.crumina.net/
*/

define( 'MVB_PATH', plugin_dir_path(__FILE__) );
define( 'MVB_URL', plugins_url().'/metro-visual-builder' );

/* the path to the custom modules */
define( 'MVB_C_PATH', get_stylesheet_directory().'/factory/mvb-custom' );
define( 'MVB_C_URL', get_stylesheet_directory_uri().'/factory/mvb-custom' );

define( 'LD', 'mvb' );

load_plugin_textdomain( 'mvb', false, dirname( plugin_basename( __FILE__ ) ).'/languages/' );

if( is_admin() )
{
    register_activation_hook(__FILE__, 'mvb_plugin_activate');
}//endif;

function mvb_plugin_activate() {
        add_option('mvb_do_activation_redirect', true);
    }

include 'app/dispatcher.php';