<?php
/*
Plugin Name: Nictitate Toolkit
Plugin URI: http://kopatheme.com
Description: A specific plugin use in Nictitate Theme to help you register post types and shortcodes.
Version: 1.0.4
Author: kopatheme
Author URI: http://kopatheme.com
License: GPLv3

Nictitate Toolkit plugin, Copyright 2015 Kopatheme.com
Nictitate Toolkit is distributed under the terms of the GNU GPL
*/

add_action('plugins_loaded', 'nictitate_toolkit_init');
add_action('after_setup_theme', 'nictitate_toolkit_after_setup_theme');

function nictitate_toolkit_after_setup_theme() {
	if (!class_exists('Kopa_Framework'))
		return;

  	#ACTION HOOK
  	if (!is_admin()) {
  		add_action('wp_enqueue_scripts', 'nictitate_toolkit_front_enqueue_scripts');
  	} else {
  		add_action('admin_enqueue_scripts', 'nictitate_toolkit_admin_enqueue_scripts', 15);
  	}


	#REGISTER POST TYPES
	require plugin_dir_path( __FILE__ ) . 'posttype/service/service.php';
	require plugin_dir_path( __FILE__ ) . 'posttype/service/options_service.php';

	require plugin_dir_path( __FILE__ ) . 'posttype/portfolio/portfolio.php';
	require plugin_dir_path( __FILE__ ) . 'posttype/portfolio/options_portfolio.php';

	require plugin_dir_path( __FILE__ ) . 'posttype/client/client.php';
	require plugin_dir_path( __FILE__ ) . 'posttype/client/options_client.php';

	require plugin_dir_path( __FILE__ ) . 'posttype/testimonial/testimonial.php';
	require plugin_dir_path( __FILE__ ) . 'posttype/testimonial/options_testimonial.php';

	require plugin_dir_path( __FILE__ ) . 'posttype/staff/staff.php';
	require plugin_dir_path( __FILE__ ) . 'posttype/staff/options_staff.php';

	require plugin_dir_path( __FILE__ ) . 'posttype/post/options_post.php';

	#REGISTER SHORTCODES
	require plugin_dir_path( __FILE__ ) . 'shortcodes.php';

	require plugin_dir_path( __FILE__ ) . 'ajax.php';

	#REGISTER SHORTCODES
	require plugin_dir_path( __FILE__ ) . 'util.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_categories.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_about.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_contact_form.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_sequence_slider.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_portfolios.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_services_intro.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_tagline.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_testimonials.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_skill.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_posts_list.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_flickr.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_subscribe.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_socials.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_posts_carousel.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_staffs.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_services_tabs.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_services.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_clients.php';
	require plugin_dir_path( __FILE__ ) . 'widgets/widget_text.php';
}

function nictitate_toolkit_front_enqueue_scripts(){
	wp_enqueue_script('jflickrfeed', plugins_url("js/widget/jflickrfeed.js", __FILE__), array('jquery'), NULL, TRUE);
}

function nictitate_toolkit_admin_enqueue_scripts(){
	global $pagenow;
	if(in_array( $pagenow, array('post.php', 'post-new.php', 'widgets.php'))){
		wp_enqueue_style('nictitate_toolkit_widget_admin', plugins_url("css/widget.css", __FILE__), NULL, NULL);
    wp_enqueue_script('nictitate_toolkit_widget_admin', plugins_url("js/widget/widget.js", __FILE__), array('jquery'), NULL, TRUE);
	}
}

/*
 * Plugin domain
 */
function nictitate_toolkit_init() {
    load_plugin_textdomain( 'nictitate-toolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
