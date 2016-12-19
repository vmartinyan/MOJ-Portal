<?php
/**
 * Kopa Framework Layout Manager Settings
 *
 * @author 		Kopatheme
 * @category 	Admin
 * @package 	KopaFramework/Admin
 * @since       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Kopa_Settings_Layout_Manager' ) ) {

/**
 * Kopa_Admin_Settings_Layout_Manager
 */
class Kopa_Settings_Layout_Manager extends Kopa_Settings_Page {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->id    = 'layout-manager';
		$this->label = esc_html__( 'Layout Manager', 'kopatheme' );

		add_filter( 'kopa_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'kopa_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'kopa_sidebar_menu_settings_' . $this->id, array( $this, 'output_sidebar' ) );
		add_action( 'kopa_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'kopa_settings_reset_' . $this->id, array( $this, 'reset' ) );
	}

	/**
	 * Get settings array
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array settings arguments
	 */
	public function get_page_settings() {

		return apply_filters( 'kopa_layout_manager_settings', array(

			/**
			 * Just for import/export custom layout
			 * data of posts and taxonomies
			 * 
			 * @see class-kopa-admin-custom-layouts.php
			 * @see layouts/*.php
			 * 
			 * @since 1.0.0
			 */
			array(
				'id' => '_custom_layout_posts',
			),
			array(
				'id' => '_custom_layout_taxonomies',
			),
			
			// frontpage layout
			array(
				'title'   => esc_html__( 'Frontpage', 'kopatheme' ),
				'type' 	  => 'title',
				'id' 	  => 'frontpage-title',
			),

			'frontpage-layout' => array(
				'title'        => esc_html__( 'Frontpage', 'kopatheme' ),
				'type'         => 'layout_manager',
				'id'           => 'frontpage-layout',
				'positions'    => array(),
				'layouts'      => array(),
				'default'      => array(),
			), // end frontpage-layout

			// blog layout
			array(
				'title'   => esc_html__( 'Blog', 'kopatheme' ),
				'type' 	  => 'title',
				'id' 	  => 'blog-title',
			),

			'blog-layout' => array(
				'title'        => esc_html__( 'Blog', 'kopatheme' ),
				'type'         => 'layout_manager',
				'id'           => 'blog-layout',
				'positions'    => array(),
				'layouts'      => array(),
				'default'      => array(),
			), // end blog-layout

			// page layout
			array(
				'title'   => esc_html__( 'Page', 'kopatheme' ),
				'type' 	  => 'title',
				'id' 	  => 'page-title',
			),

			'page-layout' => array(
				'title'        => esc_html__( 'Page', 'kopatheme' ),
				'type'         => 'layout_manager',
				'id'           => 'page-layout',
				'positions'    => array(),
				'layouts'      => array(),
				'default'      => array(),
			), // end page-layout

			// post layout
			array(
				'title'   => esc_html__( 'Post', 'kopatheme' ),
				'type' 	  => 'title',
				'id' 	  => 'post-title',
			),

			'post-layout' => array(
				'title'        => esc_html__( 'Post', 'kopatheme' ),
				'type'         => 'layout_manager',
				'id'           => 'post-layout',
				'positions'    => array(),
				'layouts'      => array(),
				'default'      => array(),
			), // end post-layout

			// search layout
			array(
				'title'   => esc_html__( 'Search', 'kopatheme' ),
				'type' 	  => 'title',
				'id' 	  => 'search-title',
			),

			'search-layout' => array(
				'title'        => esc_html__( 'Search', 'kopatheme' ),
				'type'         => 'layout_manager',
				'id'           => 'search-layout',
				'positions'    => array(),
				'layouts'      => array(),
				'default'      => array(),
			), // end search-layout

			// error 404 layout
			array(
				'title'   => esc_html__( '404', 'kopatheme' ),
				'type' 	  => 'title',
				'id' 	  => 'error404-title',
			),

			'error404-layout' => array(
				'title'        => esc_html__( 'Error 404', 'kopatheme' ),
				'type'         => 'layout_manager',
				'id'           => 'error404-layout',
				'positions'    => array(),
				'layouts'      => array(),
				'default'      => array(),
			), // end error404-layout

		) ); // End general settings
	}

}

}

return new Kopa_Settings_Layout_Manager();
