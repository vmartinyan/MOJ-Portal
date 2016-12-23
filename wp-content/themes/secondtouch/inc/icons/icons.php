<?php

/*
*	---------------------------------------------------------------------
*	Compatibility mode
*	Set to TRUE to enable compatibility mode - [v_icon]
*	---------------------------------------------------------------------
*/

define( 'VI_SAFE_MODE', apply_filters( 'vi_safe_mode', false ) );


/* Setup perfix */
function crum_i_compatibility_mode() {
	$prefix = ( VI_SAFE_MODE == true ) ? 'v_' : '';

	return $prefix;
}


/*
*	---------------------------------------------------------------------
*	Setup plugin
*	---------------------------------------------------------------------
*/

function crum_i_plugin_init() {


	wp_register_style( 'mnky-icon-generator', get_template_directory_uri() . '/inc/icons/css/generator.css', false, '', 'all' );
	wp_register_script( 'mnky-icon-generator', get_template_directory_uri() . '/inc/icons/js/generator.js', array( 'jquery' ), '', false );

	if ( is_admin() ) {

		wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_style( 'mnky-icon-generator' );


		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'mnky-icon-generator' );

	}
}

add_action( 'init', 'crum_i_plugin_init' );


/*
*	---------------------------------------------------------------------
*	Plugin URL
*	---------------------------------------------------------------------
*/

function crum_i_plugin_url() {
	return locate_template( '/inc/icons/icons.php' );
}

/*
*	---------------------------------------------------------------------
*	Icon generator box
*	---------------------------------------------------------------------
*/

function crum_i_generator() {

	?>
	<div id="mnky-generator-overlay" class="mnky-overlay-bg" style="display:none"></div>
	<div id="mnky-generator-wrap" style="display:none">
		<div id="mnky-generator">
			<a href="#" id="mnky-generator-close"><span class="mnky-close-icon"></span></a>

			<div id="mnky-generator-shell">

				<table border="0">
					<tr>
						<td class="generator-title">
							<span>Icon pack:</span>
						</td>
						<td>
							<select name="icon-pack" id="mnky-generator-select-pack">

								<?php

								$uploaded_fonts = get_option( 'secondtouch_fonts' );
								if ( is_array( $uploaded_fonts ) ) {
									foreach ( $uploaded_fonts as $uploaded_font => $info ) {
										echo '<option value=".' . $uploaded_font . '-icon-list">' . $uploaded_font . '</option>';

									}
								}
								?>
							</select>
						</td>
					</tr>
				</table>

				<div class="mnky-generator-icon-select">


					<?php //$uploaded_fonts = get_option('moon_fonts');
					if ( is_array( $uploaded_fonts ) ) {

						$i = 0;

						foreach ( $uploaded_fonts as $font => $info ) {
							$icon_set = array();
							$icons    = array();
							if ( $i == 0 ) {
								$active = 'current-menu-show';
							} else {
								$active = '';
							}
							$upload_dir = wp_upload_dir();
							$path       = trailingslashit( $upload_dir['basedir'] );
							$file       = $path . $info['include'] . '/' . $info['config'];
							include( $file );
							if ( ! empty( $icons ) ) {
								$icon_set = array_merge( $icon_set, $icons );
							}
							if ( ! empty( $icon_set ) ) {
								echo '<ul class="' . $font . '-icon-list ' . $active . '">';
								foreach ( $icon_set as $icons ) {
									foreach ( $icons as $icon ) {
										echo '<li><input name="name" type="radio" value="' . $font . '-' . $icon['class'] . '" id="' . $font . '-' . $icon['class'] . '"><label for="' . $font . '-' . $icon['class'] . '"><i class="icon ' . $font . '-' . $icon['class'] . '"></i></label></li>';
									}
								}
								echo '</ul>';
							}
							$i ++;
						}
					}
					?>
				</div>

				<input name="mnky-generator-insert" type="submit" class="button button-primary button-large"
				       id="mnky-generator-insert" value="Insert Icon">
			</div>
		</div>
	</div>

	<?php
}

add_action( 'admin_footer', 'crum_i_generator' );
