<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_menu_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 *
 * @return array
 */
function cmb_menu_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'crum_';

	$theme_menus = get_terms( array( 'taxonomy' => 'nav_menu' ) );

	$menus = array( 'default' => esc_html__( 'Default', 'crum' ) );

	if ( ! empty( $theme_menus ) && is_array( $theme_menus ) && ! is_wp_error( $theme_menus ) ) {

		foreach ( $theme_menus as $single_menu ) {
			$menus[ $single_menu->term_id ] = $single_menu->name;
		}

	}

	$meta_boxes[] = array(
		'id'         => 'custom_page_menu',
		'title'      => __( 'Select custom menu for page', 'crum' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'desc'    => '',
				'id'      => $prefix . 'custom_menu',
				'type'    => 'select',
				'options' => $menus,

			),
		),
	);

	$meta_boxes[] = array(
		'id'         => 'custom_sticky_menu',
		'title'      => __('Enable or disable sticky menu', 'crum'),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'desc'    => '',
				'id'      => $prefix . 'sticky_menu',
				'type'    => 'select',
				'default' => 'default',
				'options' => array(
					'default' => esc_html__('Default','crum'),
					'yes' => esc_html__('Disable','crum'),
					'no' => esc_html__('Enable','crum')
				),
			),
		),
	);

	return $meta_boxes;
}