<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Image
 * 
 * @author vutuansw
 * 
 * @param string $wrap_start Start Container of the field
 * @param string $wrap_end End Container of the field
 * @param array $settings see Kopa_Admin_Settings::sanitize_option_arguments()
 * @param $value
 *
 * @since 1.1.9
 * @return string - html string.
 */
function kopa_form_field_image( $wrap_start, $wrap_end, $settings, $value ) {
	
	ob_start();

	echo $wrap_start;

	$thumbnail_id = absint( $value );
	$image_url    = '';
	$classes      = array();

	if ( $thumbnail_id ) {
		$image_url = wp_get_attachment_image_url( $thumbnail_id, 'full' );
		$classes[] = 'hasimage';
	}

	$size = isset( $settings[ 'size' ] ) ? $settings[ 'size' ] : 'full';
	if( !in_array( $size, array( 'thumb', 'full' ) ) ){
		$size = 'full';
	}

	$classes[] = "kopa-field-image-{$size}";
	?>

	<div class="kopa-field kopa-field-image <?php echo esc_attr( implode( ' ', $classes ) ); ?>">		
		<a href="#" class="item-add" title="<?php echo esc_html__( 'Select an image', 'kopatheme' ) ?>">
			<?php
			printf( '<div class="img" style="background-image:url(%s)"></div>', esc_url( $image_url ) );
			?>
		</a>
		<input id="<?php echo esc_attr( $settings['id'] ) ?>" name="<?php echo esc_attr( $settings['name'] ) ?>" type="hidden" value="<?php echo esc_attr( $thumbnail_id ) ?>"/>
		<button class="item-remove"></button>
	</div>

	<?php
	echo $wrap_end;

	return ob_get_clean();

}
