<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sidebar_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sidebar_metaboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'crum_sidebars_';

	if (class_exists('SMK_Sidebar_Generator')){

		if ( function_exists('smk_get_all_sidebars') ) {
			$the_sidebars = smk_get_all_sidebars();

		$meta_boxes[] = array(
			'id'         => 'sidebar_select_metabox',
			'title'      => __('Select custom sidebar','crum'),
			'pages'      => array( 'page','post'), // Post type
			'context'    => 'side',
			'priority'   => 'default',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => 'Left Sidebar',
					'desc' => '',
					'id'   => $prefix . 'sidebar_1',
					'type' => 'select',
					'options' => $the_sidebars,
					'std'  => 'sidebar-left'
				),
				array(
					'name' => 'Right Sidebar',
					'desc' => '',
					'id'   => $prefix . 'sidebar_2',
					'type' => 'select',
					'options' => $the_sidebars,
					'std'  => 'sidebar-right'
				),
			),
		);
		}else{
			$the_sidebars[] = '';

			$meta_boxes[] = array(
				'id'         => 'sidebar_select_metabox',
				'title'      => __('Select custom sidebar','crum'),
				'pages'      => array( 'page','post'), // Post type
				'context'    => 'side',
				'priority'   => 'default',
				'show_names' => true, // Show field names on the left
				'fields'     => array(
					array(
						'name' => 'Please install SMK Sidebar Generator form Apperance -> Install plugins',
						'desc' => '',
						'id'   => $prefix . 'sidebar_1',
						'type' => 'select',
						'options' => $the_sidebars,

					),
				),
			);
		}
	}else{
		//__('Please install SMK Sidebar Generator plugin in Apperance -> Install plugins','crum');
		$the_sidebars[] = '';

		$meta_boxes[] = array(
			'id'         => 'sidebar_select_metabox',
			'title'      => __('Select custom sidebar','crum'),
			'pages'      => array( 'page','post'), // Post type
			'context'    => 'side',
			'priority'   => 'default',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name' => 'Please install SMK Sidebar Generator form Apperance -> Install plugins',
					'desc' => '',
					'id'   => $prefix . 'sidebar_1',
					'type' => 'select',
					'options' => $the_sidebars,

				),
			),
		);
	}







    // Add other metaboxes as needed

    return $meta_boxes;
}