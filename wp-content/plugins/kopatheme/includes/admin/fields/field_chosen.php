<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

function kopa_form_field_chosen( $wrap_start, $wrap_end, $field, $value ) {

	ob_start();

	$options     = isset( $field['options'] ) && !empty( $field['options'] ) ? $field['options'] : array();
	$placeholder = isset( $field['data']['placeholder'] ) ? $field['data']['placeholder'] : esc_html__( 'Select an option', 'kopatheme' );
	$is_multiple = isset( $field['data']['is_multiple'] ) ? $field['data']['is_multiple'] : false;
	$width       = isset( $field['data']['width'] ) && !empty( $field['data']['width'] ) ? esc_html( $field['data']['width'] ) : '50%';
	
	$multiple    = $is_multiple ? 'multiple' : '';
	$name        = $is_multiple ? $field['id'].'[]' : $field['id'];
	?>  
  <div class="kopa-ui-chosen">
  	<select id="<?php echo esc_attr( $field['id'] ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php echo esc_attr( $multiple ); ?> data-placeholder="<?php echo esC_attr( $placeholder ); ?>" data-width="<?php echo esc_attr( $width ); ?>">
  		
  		<?php
			if( $is_multiple ){
				$value = is_array( $value ) ? $value : array();
			}else{
				$value = array( $value );
			}

			if( $options ):
  			foreach( $options as $opt_value => $opt_name ): 
	  			$selected = in_array( $opt_value, $value, false ) ? 'selected' : '';
	  			?>
	  			<option value="<?php echo esc_attr( $opt_value ); ?>" <?php echo esC_attr( $selected ); ?>><?php echo esc_attr( $opt_name ); ?></option>
	  			<?php 
	  		endforeach;
	  	endif;
  		?>

  	</select>
  </div>
  <?php

  $html = ob_get_clean();

  return $wrap_start . $html . $wrap_end;
}

add_filter( 'kopa_sanitize_option_chosen', 'kopa_sanitize_option_chosen_sanitize', 10, 2 );		

function kopa_sanitize_option_chosen_sanitize( $items, $field ) {
	
	if( isset( $field['data']['is_multiple'] ) ) {
		if( !$items || !is_array( $items ) ) {
			$items = array();
		}			
	}else{
		$items = esc_html( $items );
	}

	return $items;
}

