<?php
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {
    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once locate_template('/inc/lib/metabox/init.php');
}
$options = get_option('second-touch');

require_once 'page-boxes.php';
require_once 'post-boxes.php';

if ($options['stan_header']){
    require_once 'headers-boxes.php';
}

require_once 'features-boxes.php';
require_once 'testimonial-boxes.php';
require_once 'portfolio-boxes.php';
require_once 'custom-sidebar.php';
require_once 'custom-menu.php';
