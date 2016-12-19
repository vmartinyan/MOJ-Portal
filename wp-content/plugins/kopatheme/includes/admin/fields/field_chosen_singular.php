<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}


function kopa_form_field_chosen_singular( $wrap_start, $wrap_end, $field, $value ) {

	$post_type        = isset( $field['post_type'] ) && !empty( $field['post_type'] ) ? esc_html( $field['post_type'] ) : 'post';
	$is_multiple      = isset( $field['data']['is_multiple'] ) ? $field['data']['is_multiple'] : false;
	$field['options'] = $is_multiple ? array() : array( '' => '' ); 

	$records = new WP_Query( array(
			'post_type'           => $post_type,
			'posts_per_page'      => -1,
			'ignore_sticky_posts' => true
		)
	);

	while ( $records->have_posts() ) {
		$records->the_post();
		$field['options'][get_the_ID()] = get_the_title();
	}

	wp_reset_postdata();
	
	$field['type'] = 'chosen';

	return kopa_form_field_chosen( $wrap_start, $wrap_end, $field, $value );

}

add_filter( 'kopa_sanitize_option_chosen_singular', 'kopa_sanitize_option_chosen_sanitize', 10, 2 );		