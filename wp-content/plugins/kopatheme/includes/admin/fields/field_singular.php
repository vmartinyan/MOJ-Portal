<?php

if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Page, Post or Custom post type dropdown
 * 
 * @param string $wrap_start Start Container of the field
 * @param string $wrap_end End Container of the field
 * @param array $settings see Kopa_Admin_Settings::sanitize_option_arguments()
 * @param $value
 *
 * @since 1.0.11
 * @return string - html string.
 */
function kopa_form_field_singular($wrap_start, $wrap_end, $settings, $value) {

    $post_type = !empty($settings['post_type']) ? $settings['post_type'] : 'page';

    $settings['options'] = array('' => esc_html__('-- Select --', 'kopatheme'));

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'ignore_sticky_posts' => true
    );


    $records = get_posts($args);
   
    foreach ($records as $post) {
        $settings['options'][$post->ID] = get_the_title($post);
    }
    
    if (isset($settings['multiple']) && $settings['multiple']) {
        $settings['data'] = array(
            'is_multiple' => 1
        );
    }
    
    return kopa_form_field_chosen($wrap_start, $wrap_end, $settings, $value);
}
