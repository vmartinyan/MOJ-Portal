<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_post_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_post_metaboxes( array $meta_boxes ) {

	$meta_boxes[] = array(

		'id'         => 'post_video_custom_fields',
		'title'      => __('Post Video','crum'),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

            array(
                'name' => __('YouTube video ID','crum'),
                'desc'	=> '',
                'id'	=> 'post_youtube_video_url',
                'type'	=> 'text'
            ),
            array(
                'name' =>  __('Vimeo video ID','crum'),
                'desc'	=> '',
                'id'	=> 'post_vimeo_video_url',
                'type'	=> 'text'
            ),
            array(
                'name' =>  __('Self hosted video file in mp4 format','crum'),
                'desc'	=> '',
                'id'	=> 'post_self_hosted_mp4',
                'type'	=> 'file'
            ),
            array(
                'name' =>  __('Self hosted video file in webM format','crum'),
                'desc'	=> '',
                'id'	=> 'post_self_hosted_webm',
                'type'	=> 'file'
            ),
		),
	);
	$meta_boxes[] = array(
		'id'         => 'header_img_metabox',
		'title'      => __('Post stunning header options','crum'),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Page subtitle','crum'),
				'desc'	=> '',
				'id'	=> 'crum_headers_subtitle',
				'type'	=> 'text'
			),
			array(
				'name' => __('Hide stunning header','crum'),
				'desc'	=> '',
				'id'	=> 'crum_headers_hide',
				'type'	=> 'checkbox'
			),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}
