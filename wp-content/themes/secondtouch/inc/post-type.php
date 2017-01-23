<?php




/*
 * Portfolio taxonomy
 */
function my_custom_post_product() {
	$labels = array(
		'name'               => __( 'Portfolios' , 'crum' ),
		'singular_name'      => __( 'Portfolio' , 'crum' ),
		'add_new'            => __( 'Add New' , 'crum' ),
		'add_new_item'       => __( 'Add New Portfolio item' , 'crum' ),
		'edit_item'          => __( 'Edit Portfolio item' , 'crum' ),
		'new_item'           => __( 'New Portfolio item' , 'crum' ),
		'all_items'          => __( 'All Portfolio items' , 'crum' ),
		'view_item'          => __( 'View Portfolio item' , 'crum' ),
		'search_items'       => __( 'Search Portfolios item' , 'crum' ),
		'not_found'          => __( 'No products found' , 'crum' ),
		'not_found_in_trash' => __( 'No products found in the Trash' , 'crum' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Portfolios'
	);


	$options = get_option('second-touch');


	if (isset($options['custom_portfolio-slug']) && $options['custom_portfolio-slug']){
		$slug = $options['custom_portfolio-slug'];
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our products and product specific data',
			'public'        => true,
			'supports'      => array( 'title', 'editor', 'author', 'thumbnail', 'tags', 'sticky' ),
			'has_archive'   => true,
			'menu_icon' => 'dashicons-format-gallery', /* the icon for the custom post type menu */
			'taxonomies'    => array('post_tag'),
			'rewrite' => array(
				'slug' => $slug,
			),
		);
	} else {
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our products and product specific data',
			'public'        => true,
			'supports'      => array( 'title', 'editor','excerpt', 'author', 'thumbnail', 'tags', 'sticky' ),
			'has_archive'   => true,
			'menu_icon' => 'dashicons-format-gallery', /* the icon for the custom post type menu */
			'taxonomies'    => array('post_tag'),
		);
	}

	register_post_type( 'my-product', $args );
}
add_action( 'init', 'my_custom_post_product' );

function my_updated_messages( $messages ) {
	global $post, $post_ID;

	$options = get_option('second-touch');


	if (isset($options['custom_portfolio-slug']) && $options['custom_portfolio-slug']){
		$slug = $options['custom_portfolio-slug'];
	} else {
		$slug = 'my-product';
	}

	$messages[$slug] = array(
		0 => '',
		1 => sprintf( __('Portfolio updated. <a href="%s">View product</a>', 'crum'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', 'crum'),
		3 => __('Custom field deleted.', 'crum'),
		4 => __('Portfolio updated.', 'crum'),
		5 => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s', 'crum'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Portfolio published. <a href="%s">View product</a>', 'crum'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Portfolio saved.', 'crum'),
		8 => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview product</a>', 'crum'), esc_url( add_query_arg( 'preview', 'true',esc_url( get_permalink($post_ID)) ) ) ),
		9 => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>', 'crum'), date_i18n( __( 'M j, Y @ G:i', 'crum' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview product</a>', 'crum'), esc_url( add_query_arg( 'preview', 'true', esc_url(get_permalink($post_ID)) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );

function my_taxonomies_product() {

	$options = get_option('second-touch');

	$labels = array(
		'name'              => __( 'Portfolio Categories', 'crum' ),
		'singular_name'     => __( 'Portfolio Category', 'crum' ),
		'search_items'      => __( 'Search Portfolio Categories', 'crum' ),
		'all_items'         => __( 'All Portfolio Categories', 'crum' ),
		'parent_item'       => __( 'Parent Portfolio Category', 'crum' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'crum' ),
		'edit_item'         => __( 'Edit Portfolio Category', 'crum' ),
		'update_item'       => __( 'Update Portfolio Category', 'crum' ),
		'add_new_item'      => __( 'Add New Portfolio Category', 'crum' ),
		'new_item_name'     => __( 'New Portfolio Category', 'crum' ),
		'menu_name'         => __( 'Portfolio Categories', 'crum' ),
	);

	if (isset($options['custom_portfolio-slug']) && $options['custom_portfolio-slug']){
		$slug = $options['custom_portfolio-slug'];
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'rewrite' => array(
				'slug' => $slug . '_category',
			),

		);
	} else {
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
	}



	register_taxonomy( 'my-product_category', 'my-product', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );



function crumina_time_line() {
	$labels = array(
		'name' => __('Time Line', 'crum'),
		'singular_name' => __('Time Line', 'crum'),
		'add_new_item' => __('Add New Time Line Item', 'crum'),
		'edit_item' => __('Edit Time Line Item', 'crum'),
		'search_items' => __('Search Time Line Items', 'crum'),
		'not_found' => __('Sorry: Time Line Item Not Found', 'crum'),
		'not_found_in_trash' => __('Sorry: Time Line Item Not Found In Trash', 'crum'),

	);
	$args = array(
		'labels'        => $labels,
		'rewrite' => false,
		'public' => true,
		'hierarchical' => 'false',
		'capability_type' => 'page',
		'supports' => array('title', 'editor', 'page-attributes'),
		'menu_icon' => 'dashicons-chart-line', /* the icon for the custom post type menu */
		'has_archive'   => false
	);
	register_post_type( 'timeline', $args );

}
add_action( 'init', 'crumina_time_line' );

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
	if(is_tag() && !empty( $query->query_vars['tag'] ) ) {
		$post_type = get_query_var('post_type');
		if($post_type)
			$post_type = $post_type;
		else
			$post_type = array('post','my-product','nav_menu_item');
		$query->set('post_type',$post_type);
		return $query;
	}
}