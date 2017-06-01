<?php
/*
Plugin Name: Table Maker
Plugin URI: https://wordpress.org/plugins/table-maker/
Description: Create tables with just a few clicks.
Version: 1.6
Author: Wpsoul
Author URI: https://wpsoul.com
License: GPL2
Text Domain: wpsm-tableplugin
Domain Path: /languages/
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'inc/class-wpsm-table-maker.php';

function wpsm_run_table_maker() {
	$plugin_instance = new WPSM_Table_Maker('1.6');
	register_activation_hook( __FILE__, array($plugin_instance, 'initialize') );
	register_uninstall_hook( __FILE__, array('WPSM_Table_Maker', 'rollback') );
}

wpsm_run_table_maker();

function wpsm_get_table($id)
{
	$db = WPSM_DB_Table::get_instance();
	$table = $db->get($id);
	return $table['tvalues'];
}

function wpsm_load_plugin_textdomain() {
	load_plugin_textdomain( 'wpsm-tableplugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'wpsm_load_plugin_textdomain' );

?>