<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

function kopa_form_field_repeater_link( $wrap_start, $wrap_end, $field, $value ) {

	ob_start();

	$field_id   = $field['id'];
	$field_id   = str_replace( '[', '-', $field_id );
	$field_id   = str_replace( ']', '', $field_id );
	
	$field_name = $field['id'];


	$ui_classes = array( 'kopa-ui-repeater-links' );

	if( isset( $field['size'] ) && in_array( $field['size'], array( 'xs', 'sm', 'md', 'lg' ) ) ) {
		$ui_classes[] = 'kopa-size--' . $field['size'];
	}else{
		$ui_classes[] = 'kopa-size--lg';
	}		
  ?>  

  <div class="<?php echo esc_attr( implode( ' ', $ui_classes ) ); ?>" data-id="#kopa-template-<?php echo esc_attr( $field_id ); ?>">
		
		<div class="kopa-ui-repeater-container">
			<?php 			
			if( $value && is_array( $value ) ) {
				for( $i=0; $i<count( $value ); $i++ ) {						
					kopa_form_field_repeater_link_get_single($value[$i], $i, $field_name );
				}
			}
			?>				
		</div>

		<p class="kopa-repeater-toolbar">
			<input type="button" class="button button-secondary kopa-repeater-add" value="<?php esc_attr_e( 'Add new link', 'kopatheme' ); ?>"/>
		</p>

  </div>

	<script type="text/template" id="kopa-template-<?php echo esc_attr( $field_id ); ?>">
		<?php kopa_form_field_repeater_link_get_single( array('title'=>esc_html__( 'Untitle', 'kopatheme' ) ), '{?}', $field_name ); ?>
	</script>

  <?php    
  $html = ob_get_clean();

  return $wrap_start . $html . $wrap_end;
}

add_filter( 'kopa_sanitize_option_repeater_link', 'kopa_form_field_repeater_link_sanitize', 10, 2 );	

function kopa_form_field_repeater_link_sanitize( $items, $field ) {

	if( $items && is_array( $items ) ) {
		
		$new_items = array();
		
		foreach( $items as $item ) {

			$item = wp_parse_args( $item, kopa_form_field_repeater_link_get_defaults() );
			extract( $item );

			$new_items[] = array(
				'title'  => $title ? wp_kses_post( $title ) : esc_html__( 'Untitle', 'kopatheme' ),
				'url'    => esc_url( $url ),
				'rel'    => esc_html( $rel ),
				'target' => esc_html( $target ),
				'icon'   => esc_html( $icon )
			);
		}

		if( count( $new_items ) ){
			$items = $new_items;
		}
	}else{
		$items = array();
	}
				
	return $items;
}

function kopa_form_field_repeater_link_get_single( $value, $i, $id ) {
	$defaults = kopa_form_field_repeater_link_get_defaults();
	$value    = wp_parse_args( $value, $defaults );
	extract( $value );
	?>
	
	<div class="kopa-repeater-group">

		<label>
			<span><?php echo esc_attr( strip_tags( $title ) ); ?></span>
			<i class="kopa-repeater-edit dashicons dashicons-edit"></i>
			<i class="kopa-repeater-delete dashicons dashicons-trash"></i>
		</label>

		<div class="kopa-repeater-item-content">

				<div class="kopa-repeater-item-block">
						<span><?php esc_html_e( 'Title', 'kopatheme' ); ?></span>
						<input class="kopa-repeater-input-title" type="text" value="<?php echo esc_attr( $title ); ?>" name="<?php echo esc_attr( $id );?>[<?php echo esc_attr( $i ); ?>][title]">						
				</div>

				<div class="kopa-repeater-item-block">
						<span><?php esc_html_e( 'URL', 'kopatheme' ); ?></span>
						<input class="kopa-repeater-input-url" type="text" value="<?php echo esc_attr( $url ); ?>" name="<?php echo esc_attr( $id );?>[<?php echo esc_attr( $i ); ?>][url]">
				</div>

				<div class="kopa-repeater-item-block">
						<span><?php esc_html_e( 'Rel', 'kopatheme' ); ?><a class="dashicons dashicons-editor-help" target="_blank" href="//www.w3schools.com/tags/att_a_rel.asp"></a></span>
						<input class="kopa-repeater-input-rel" type="text" value="<?php echo esc_attr( $rel ); ?>" name="<?php echo esc_attr( $id );?>[<?php echo esc_attr( $i ); ?>][rel]">										
				</div>

				<div class="kopa-repeater-item-block">
						<span><?php esc_html_e( 'Target', 'kopatheme' ); ?><a class="dashicons dashicons-editor-help" target="_blank" href="//www.w3schools.com/tags/att_a_target.asp"></a></span>
						<input class="kopa-repeater-input-target" type="text" value="<?php echo esc_attr( $target ); ?>" name="<?php echo esc_attr( $id );?>[<?php echo esc_attr( $i ); ?>][target]">													
				</div>

				<div class="kopa-repeater-item-block">
					<span><?php esc_html_e( 'Icon', 'kopatheme' ); ?></span>														
					<?php
					$args = array(
						'type'  => 'icon_picker',								
						'id'    =>  '',
						'title' => '',
						'name'  => sprintf( "%s[%s][icon]", $id, $i ),								
						'size'  => 'lg'
					);					
					echo kopa_form_field_icon_picker( '', '', $args, $icon );							
					?>						
				</div>
													
		</div>

	</div>			
	
	<?php
}

function kopa_form_field_repeater_link_get_defaults() {
	return array(
		'title'  => '',
		'url'    => '',				
		'rel'    => '',
		'target' => '',
		'icon'   => ''
	);
}
