<?php
// implement tinymce button

add_action( 'admin_init', 'fp_action_admin_init');
function fp_action_admin_init() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	if ( get_user_option('rich_editing') == 'true') {
		add_filter( 'mce_external_plugins', 'fp_filter_mce_plugin');
		add_filter( 'mce_buttons_2', 'fp_filter_mce_button');
	}
}

function fp_filter_mce_button( $buttons ) {
	array_push( $buttons, '|', 'fp_btn' );
	return $buttons;
}

function fp_filter_mce_plugin( $plugins ) {
	if( (float)substr(get_bloginfo('version'), 0, 3) < 3.9) {
		$plugins['FontPress'] = FP_URL . '/js/tinymce_btn_old_wp.js';
	} else {
		$plugins['FontPress'] = FP_URL . '/js/tinymce_btn.js';
	}
	
	return $plugins;
}


// enqueue the colorpicker
function fp_shortcode_scripts() {
	if(strpos($_SERVER['REQUEST_URI'], 'post.php') || strpos($_SERVER['REQUEST_URI'], 'post-new.php')) :
	?>
    	<script src="<?php echo FP_URL; ?>/js/colpick/js/colpick.min.js" type="text/javascript"></script>
    <?php
	endif;
	return true;
}
add_action('admin_footer', 'fp_shortcode_scripts');
