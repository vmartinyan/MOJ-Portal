<?php
/**
 * Register assets for frontend for reused purpose.
 *
 * @author 		Kopatheme
 * @category 	Class
 * @package 	KopaFramework/Classes
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Kopa_Frontend_Assets' ) ) {

	/**
	 * Kopa_Frontend_Assets Class
	 */
	class Kopa_Frontend_Assets {

		/**
		 * Hook in tabs.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
		}

		/**
		 * Register styles
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function register_styles() {
			wp_register_style( 'kopa_font_awesome', KF()->framework_url() . '/assets/css/font-awesome.css', array(), '4.6.3' );
			wp_register_style( 'font-awesome', KF()->framework_url() . '/assets/css/font-awesome.css', array(), '4.6.3' );
			wp_register_style( 'font-themify', KF()->framework_url() . '/assets/css/font-themify.css', array(), '1.0.0' );
		}


		/**
		 * Register scripts
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function register_scripts() {
		}

	}

}

return new Kopa_Frontend_Assets();
