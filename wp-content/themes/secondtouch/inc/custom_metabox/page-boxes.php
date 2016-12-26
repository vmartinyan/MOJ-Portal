<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'crum_page_custom_';

    $meta_boxes[] = array(
        'id'         => 'blog_params',
        'title'      => __('Select Blog parameters','crum'),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_on' => array( 'key' => 'page-template', 'value' => array( 'posts-sidebar-sel.php','tmp-posts-masonry-4.php' ) ),
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Select blog page layout',
                'desc' => 'You can select layout for current blog page',
                'id'   => 'blog_layout_select',
                'type' => 'radio_inline',
                'options' => array(
                    array( 'name' => 'Default', 'value' => '', ),
                    array( 'name' => 'No sidebars', 'value' => '1col-fixed', ),
                    array( 'name' => 'Sidebar on left', 'value' => '2c-l-fixed', ),
                    array( 'name' => 'Sidebar on right', 'value' => '2c-r-fixed', ),
                    array( 'name' => '2 left sidebars', 'value' => '3c-l-fixed', ),
                    array( 'name' => '2 right sidebars', 'value' => '3c-r-fixed', ),
                    array( 'name' => 'Sidebar on either side', 'value' => '3c-fixed', ),
                ),
            ),
            array(
                'name' => 'Display posts of certain category?',
                'desc' => 'Check, if you want to display posts from a certain category',
                'id'   => 'blog_sort_category',
                'type' => 'checkbox'
            ),
            array(
                'name' => 'Blog Category',
                'desc'	=> 'Select blog category',
                'id'	=> 'blog_category',
                'taxonomy' => 'category',
                'type' => 'taxonomy_multicheck',
            ),
            array (
                'name' => 'Number of posts ot display',
                'desc'	=> '',
                'id'	=> 'blog_number_to_display',
                'type'	=> 'text'
            ),
        ),
    );

    $meta_boxes[] = array(
        'id'         => 'masonry_blog_params',
        'title'      => __('Select Blog parameters','crum'),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_on' => array( 'key' => 'page-template', 'value' => array( 'tmp-posts-masonry-3.php', 'tmp-posts-masonry-2-side.php', 'tmp-posts-masonry-2.php', 'tmp-posts-left-img.php', 'tmp-posts-right-img.php' ) ),
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Display posts of certain category?',
                'desc' => 'Check, if you want to display posts from a certain category',
                'id'   => 'blog_sort_category',
                'type' => 'checkbox'
            ),
            array(
                'name' => 'Blog Category',
                'desc'	=> 'Select blog category',
                'id'	=> 'blog_category',
                'taxonomy' => 'category',
                'type' => 'taxonomy_multicheck',
            ),
            array (
                'name' => 'Number of posts ot display',
                'desc'	=> '',
                'id'	=> 'blog_number_to_display',
                'type'	=> 'text'
            ),
        ),
    );

	$meta_boxes[] = array(
		'id'         => 'page_bg_metabox',
		'title'      => __('Boxed Page background options','crum'),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
	            'name' => __('Background color', 'crum'),
	            'desc' => __('Color of body of page (page will be set to boxed)', 'crum'),
	            'id'   => $prefix . 'bg_color',
	            'type' => 'colorpicker',
				'std'  => '#ffffff'
	        ),
            array(
                'name' => __('Fixed backrgound','crum'),
                'desc' => __('Check if you want to bg will be fixed on page scroll','crum'),
                'id'   => $prefix . 'bg_fixed',
                'type' => 'checkbox',
            ),
			array(
				'name' => __('Background image','crum'),
				'desc' => __('Upload an image or enter an URL.','crum'),
				'id'   => $prefix . 'bg_image',
				'type' => 'file',
			),
            array(
                'name'    => __('Background image repeat','crum'),
                'desc'    => '',
                'id'      => $prefix . 'bg_repeat',
                'type'    => 'select',
                'options' => array(
                    array( 'name' => 'All', 'value' => 'repeat', ),
                    array( 'name' => 'Horizontally', 'value' => 'repeat-x', ),
                    array( 'name' => 'Vertically', 'value' => 'repeat-y', ),
                    array( 'name' => 'No-Repeat', 'value' => 'no-repeat', ),
                ),
            ),
		),
	);

	$meta_boxes[] = array(
		'id'         => 'page_layout',
		'title'      => __('Page layouts','crum'),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_on' => array( 'key' => 'page-template', 'value' => array( 'default' ) ),
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Select page layout', 'crum' ),
				'desc'    => esc_html__( 'You can select layout for current page', 'crum' ),
				'id'      => 'page_layout_select',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Default', 'value' => '', ),
					array( 'name' => 'No sidebars', 'value' => '1col-fixed', ),
					array( 'name' => 'Sidebar on left', 'value' => '2c-l-fixed', ),
					array( 'name' => 'Sidebar on right', 'value' => '2c-r-fixed', ),
					array( 'name' => '2 left sidebars', 'value' => '3c-l-fixed', ),
					array( 'name' => '2 right sidebars', 'value' => '3c-r-fixed', ),
					array( 'name' => 'Sidebar on either side', 'value' => '3c-fixed', ),
				),
			),
			array(
				'id'       => 'meta_full_width_layout_width',
				'type'     => 'text',
				'name'    => __( 'Layout width', 'crum' ),
				'desc'     => __( 'You can set custom width of layout. Leave empty for default width.', 'crum' ),
				'validate' => 'numeric',
				'default'  => ''
			),

			array(
				'id'      => 'meta_width_units',
				'name'   => __( 'Width units', 'crum' ),
				'type'    => 'select',
				'options' => array(
					esc_html__( 'Default', 'crum' ) => 'default',
					'px'                            => 'px',
					'percent'                       => '%'
				),
				'default' => 'default',
			),
		),
	);

    $meta_boxes[] = array(
        'id'         => 'top_text_fields',
        'title'      => __('Block before content','crum'),
        'pages'      => array( 'page', ), // Post type

        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' =>  __('Full-width shortcode','crum'),
				'desc' => __('Block that displayed before content and sidebars','crum'),
				'id' =>   '_top_page_text',
				'type'	=> 'text',

            ),
        ),
    );

    $meta_boxes[] = array(
        'id'         => 'cont_text_fields',
        'title'      => __('Additional Text fields','crum'),
        'pages'      => array( 'page', ), // Post type
        'show_on'    => array('key' => 'page-template', 'value' => 'page-contacts.php' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
            'name' => __('Text block','crum'),
            'id' =>   '_contacts_page_text',
            'type' => 'wysiwyg',
            'options' => array(
                'wpautop' => false, // use wpautop?
                'media_buttons' => false, // show insert/upload button(s)
                'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
                'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                ),
                'std' => ''
            ),
            array(
                'name' => __('QR Code address','crum'),
                'id' =>   '_contacts_page_qr',
                'type' => 'text',
            ),
	        array(
		        'name' => __('Custom Form Shortcode', 'crum'),
		        'id' =>   '_contacts_page_custom_shortcode',
		        'type' => 'text',
		        'std' => '',
	        ),
        ),
    );

	$meta_boxes[] = array(
		'id'         => 'socicon_vkl',
		'title'      => __('Social icons','crum'),
		'pages'      => array( 'page', ), // Post type

		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' =>  __('Show social icons ?','crum'),
				'desc' => __('Yes or No','crum'),
				'id' =>   '_top_page_text',
				'type'	=> 'radio',
				'options' => array(
					'Yes' => 'Yes',
					'No'  => 'No',
				)

			),
		),
	);

	$meta_boxes[] = array(
		'id'         => 'captcha_contact_page',
		'title'      => __('Contact form','crum'),
		'pages'      => array( 'page', ), // Post type

		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' =>  __('Show captcha in contact form?','crum'),
				'desc' => __('Yes or No','crum'),
				'id' =>   '_captcha_contact_form',
				'type'	=> 'radio',
				'options' => array(
					'Yes' => 'Yes',
					'No'  => 'No',
				)
			),
		),
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}
