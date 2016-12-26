<?php
/**
 *
 * @package   Crumina installer
 * @author    Crumina <info@crumina.net>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2015 Crumina Team
 *
 * @wordpress-plugin
 * Plugin Name: Crumina installer plugin
 * Plugin URI:  http://crumina.net
 * Description: Install demo data just in one click
 * Version:     1.0
 * Author:      Crumina
 * Author URI:  http://crumina.net
 * Text Domain: crum
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

define('EASY_F_PLUGIN_PATH',plugin_dir_path(__FILE__));

// Don't duplicate me!
if ( !class_exists( 'Radium_Theme_Demo_Data_Importer' ) ) {

	require_once( dirname( __FILE__ ) . '/importer/radium-importer.php' ); //load admin theme data importer

	class Radium_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

		/**
		 * Set framewok
		 *
		 * options that can be used are 'default', 'radium' or 'optiontree'
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'radium';

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name       = 'my_theme_options_name'; //set theme options name here (key used to save theme options). Optiontree option name will be set automatically

		/**
		 * Set name of the theme options file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_options_file_name = 'theme_options.txt';

		/**
		 * Set name of the widgets json file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widgets_file_name       = 'widgets.json';

		/**
		 * Set name of the content file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $content_demo_file_name  = 'content.xml';

		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			$this->demo_files_path = dirname(__FILE__) . '/demo-files/'; //can

			self::$instance = $this;
			parent::__construct();

		}

		/**
		 * Add menus - the menus listed here largely depend on the ones registered in the theme
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus(){

			// Menus to Import and assign - you can remove or add as many as you want
			$main_menu   = get_term_by('name', 'Primary Navigation', 'nav_menu');
			$footer_menu = get_term_by('name', 'Footer menu', 'nav_menu');

			set_theme_mod( 'nav_menu_locations', array(
					'primary_navigation' => $main_menu->term_id,
					'footer_menu' => $footer_menu->term_id,
				)
			);

			$this->flag_as_imported['menus'] = true;

		}

		public function set_demo_homepage() {

			$page = get_page_by_title( '!Corporate Layout' );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}

		}

		public function crum_say_hello() {

			wp_delete_post( 1, true );
			wp_delete_post( 2, true );

		}

		public function set_demo_sliders(){

			global $wpdb;
			$wpdb->insert(
				'wp_crum_page_slider',
				array(
					'id' => '22',
					'data'=>'{"template":"1b-4s","sort":"name","sort_order":"desc","posts":"3","portfolios":"1","pages":"1","cache":"10","enable":{"title":"on","icon":"on","category":"on","description":"on","link":"on"},"words_limit":"30","link_type":"on_title","auto_mode":"","post_select":["health","experience","travels","wishes","air","photo","pictures"],"category_background_color":"","slide_hover_color":"","odd_slide_hover_color":"","opacity":"75"}',
					'name' =>'second-layout'
				)
			);

			$wpdb->update(
				'wp_options',
				array(
					'option_value'=> 'a:2:{s:6:"footer";a:8:{s:9:"item_size";s:0:"";s:14:"dropdown_style";s:7:"classic";i:4551;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:0:"";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:0:"";s:4:"icon";s:0:"";}i:4553;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:0:"";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:0:"";s:4:"icon";s:0:"";}i:4555;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:0:"";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:0:"";s:4:"icon";s:0:"";}i:4552;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:0:"";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:0:"";s:4:"icon";s:0:"";}i:4554;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:0:"";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:0:"";s:4:"icon";s:0:"";}i:4556;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:0:"";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:0:"";s:4:"icon";s:0:"";}}s:18:"primary-navigation";a:7:{s:9:"item_size";s:0:"";s:14:"dropdown_style";s:7:"classic";i:4525;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:7:"#c2d1d9";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:65:"http://crumina.net/second/wp-content/uploads/2013/09/homepage.jpg";s:4:"icon";s:11:"linecon-key";}i:4541;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:7:"#56bbdd";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:62:"http://crumina.net/second/wp-content/uploads/2013/09/blogg.jpg";s:4:"icon";s:12:"moon-pencil2";}i:4542;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:7:"#c2d1d9";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:63:"http://crumina.net/second/wp-content/uploads/2013/09/workss.jpg";s:4:"icon";s:0:"";}i:4550;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:7:"#53badd";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:61:"http://crumina.net/second/wp-content/uploads/2013/09/feat.jpg";s:4:"icon";s:0:"";}i:4545;a:5:{s:10:"font_color";s:0:"";s:8:"bg_color";s:7:"#ff6d6d";s:16:"bg_color_inherit";s:14:"do_not_inherit";s:8:"bg_image";s:0:"";s:4:"icon";s:16:"linecon-location";}}}',
				),
				array(
					'option_name'=>'crumina_menu_data',
				)
			);

			include EASY_F_PLUGIN_PATH.'importer/class.ls.importutil.php';

			$import = new LS_ImportUtil(EASY_F_PLUGIN_PATH."demo-files/layerslider/LayerSlider_Export_2014-07-23_at_12.45.58.zip");
		}

	}

	global $installer;

	$installer = new Radium_Theme_Demo_Data_Importer;

	function crum_deactivate_installer() {

		$active_plugins = get_option( 'active_plugins' );
		if ( is_array( $active_plugins ) && in_array( 'wordpress-importer/wordpress-importer.php', $active_plugins ) ) {

			$importer_key = array_search( 'wordpress-importer/wordpress-importer.php', $active_plugins );

			unset( $active_plugins[ $importer_key ] );

			update_option( 'active_plugins', $active_plugins );
		}

	}

	add_action('wp_ajax_crum_deactivate_installer','crum_deactivate_installer');

	function crum_dataImport(){

		global $installer;

		$installer->set_demo_data(EASY_F_PLUGIN_PATH . "demo-files/".$_POST['xml'] );

	}

	add_action('wp_ajax_crum_dataImport', 'crum_dataImport');

	function crum_otherImport(){

		global $installer;

		$installer->set_demo_menus();
		$installer->set_demo_homepage();
		$installer->crum_say_hello();
		$installer->set_demo_sliders();
		
		$install_parent = new Radium_Theme_Importer;
		$widgets_file = EASY_F_PLUGIN_PATH . "/demo-files/widgets.wie";
		delete_option('sidebars_widgets');
		$install_parent->process_widget_import_file($widgets_file);

	}
	add_action('wp_ajax_crum_otherImport', 'crum_otherImport');

}
