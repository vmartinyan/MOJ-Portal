<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'crum_headers_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */


function crum_headers_metaboxes( array $meta_boxes) {

     $slug = 'my-product';


	// Start with an underscore to hide fields from custom fields list
	$prefix = 'crum_headers_';

	$meta_boxes[] = array(
		'id'         => 'header_img_metabox',
		'title'      => __('Page header background','crum'),
		'pages'      => array( 'page',$slug ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Hide stunning header','crum'),
				'desc'	=> '',
				'id'	=> 'crum_headers_hide',
				'type'	=> 'checkbox'
			),
			array(
	            'name' => 'Background image',
	            'desc' => __('Select image pattern for header background','crum'),
	            'id'   => $prefix . 'bg_img',
                'type' => 'file',
                'save_id' => false, // save ID using true
				'std'  => ''
	        ),
            array(
                'name' => 'Background color',
                'desc' => __('Select color for header background','crum'),
                'id'   => $prefix . 'bg_color',
                'type' => 'colorpicker',
                'save_id' => false, // save ID using true
                'std'  => ''
            ),
            array(
                'name' => __('Page subtitle','crum'),
                'desc'	=> '',
                'id'	=> $prefix . 'subtitle',
                'type'	=> 'text'
            ),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}
