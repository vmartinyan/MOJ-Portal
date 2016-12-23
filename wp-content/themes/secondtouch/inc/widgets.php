<?php

function crum_widgets_init() {
    
  // Register Sidebars

    register_sidebar(array(
        'name' => __('Left Sidebar', 'crum'),
        'id' => 'sidebar-left',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Right Sidebar', 'crum'),
        'id' => 'sidebar-right',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => __('Footer column 1', 'crum'),
        'id' => 'sidebar-footer-col1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer column 2', 'crum'),
        'id' => 'sidebar-footer-col2',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer column 3', 'crum'),
        'id' => 'sidebar-footer-col3',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

	if ( class_exists('woocommerce') ) {
		register_sidebar(
			array(
				'name'          => __( 'Sidebar for shop', 'crum' ),
				'id'            => 'shop-sidebar',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	$sidebars = get_option('Maestro_hhp-optionssidebars');
    
    if( is_array( $sidebars ) )
        foreach( $sidebars as $name => $position )
            register_sidebar(array(
                'name' => __( $name , 'crum'),
                'id' =>str_replace(' ', '-', strtolower($name)),
                'before_widget' => '<section id="%1$s" class="widget %2$s widget_%2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));

}
/*
 * Include widgets
 */

require( get_template_directory() . '/inc/widgets/widget-menu.php' );

require( get_template_directory() . '/inc/widgets/widget-tweets.php' );
require( get_template_directory() . '/inc/widgets/widget-tabs.php' );
require( get_template_directory() . '/inc/widgets/widget-tags.php' );

require( get_template_directory() . '/inc/widgets/widget-gallery.php' );
require( get_template_directory() . '/inc/widgets/widget-instagram.php' );

require( get_template_directory() . '/inc/widgets/widget-category-news.php' );
require( get_template_directory() . '/inc/widgets/widget_categories.php' );
require( get_template_directory() . '/inc/widgets/widget-facebook.php' );
require( get_template_directory() . '/inc/widgets/widget-video.php' );
require( get_template_directory() . '/inc/widgets/widget-audio.php' );
require( get_template_directory() . '/inc/widgets/widget-flickr.php' );
require( get_template_directory() . '/inc/widgets/widget-vcard.php' );
require( get_template_directory() . '/inc/widgets/widget-styled-list.php' );
require( get_template_directory() . '/inc/widgets/widget-count.php' );
require( get_template_directory() . '/inc/widgets/widget-recent.php' );



/*
 * Register widgets
 */

register_widget( 'crum_latest_tweets' );
register_widget( 'crum_gallery_widget' );
register_widget( 'crum_video_widget' );
register_widget( 'crum_widgets_audio' );
register_widget( 'crum_widget_flickr' );
register_widget( 'roots_vcard_widget' );
register_widget( 'crum_recent_posts' );
register_widget( 'crum_tags_widget' );


add_action('widgets_init', 'crum_widgets_init');


function unregister_default_wp_widgets() {

    unregister_widget('WP_Nav_Menu_Widget');

}

add_action('widgets_init', 'unregister_default_wp_widgets', 1);


/*
 * Custom sidebar function including
 */

function add_user_sidebar( $id, $meta ){
    $sidebar = get_post_meta($id, $meta, $single = true);
    if ( ( $sidebar ) &&  function_exists('dynamic_sidebar') )
        return  dynamic_sidebar( $sidebar );
}