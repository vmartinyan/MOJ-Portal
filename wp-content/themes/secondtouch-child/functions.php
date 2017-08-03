<?php
/**
 * Child theme functions
 */
 
 /**
 * Proper way to enqueue scripts and styles
 */
function crum_child_css() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'crum_child_css', 99 );

/*function click2call(){
    wp_c2c();
}
add_shortcode( 'click2call', 'click2call' );
*/
function wptricks24_recaptcha_scripts() {
        wp_deregister_script( 'google-recaptcha' );
 
        $url = 'https://www.google.com/recaptcha/api.js';
        $url = add_query_arg( array(
            'onload' => 'recaptchaCallback',
            'render' => 'explicit',
            'hl' => qtranxf_getLanguage()), $url );
 
        wp_register_script( 'google-recaptcha', $url, array(), '2.0', true );
    }
 
    add_action( 'wpcf7_enqueue_scripts', 'wptricks24_recaptcha_scripts', 11 );
