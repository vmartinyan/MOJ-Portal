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


