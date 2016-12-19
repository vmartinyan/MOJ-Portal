<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

function kopa_form_field_quote( $wrap_start, $wrap_end, $field, $value ) {

		ob_start();	  

		$author  = isset( $value['author'] ) ? $value['author'] : '';
		$content = isset( $value['content'] ) ? $value['content'] : '';
    ?>

    <div class="kopa-ui-quote">				     
		<div class="kopa-row">
			<div class="kopa-col-xs-2"><?php esc_html_e( 'Author', 'kopa-toolkit' ); ?></div>
        	<div class="kopa-col-xs-10">
        		<input class="medium-text" type="text" name="<?php echo esc_attr( $field['id'] ); ?>[author]" value="<?php echo esc_attr( $author ); ?>">
        	</div>
        </div>				        
        <div class="kopa-row">
			<div class="kopa-col-xs-2"><?php esc_html_e( 'Content', 'kopa-toolkit' ); ?></div>
        	<div class="kopa-col-xs-10">
        		<textarea class="large-text" name="<?php echo esc_attr( $field['id'] ); ?>[content]"><?php echo wp_kses_post( $content );  ?></textarea>
        	</div>
      	</div>
    </div>

  	<?php       
    $html = ob_get_clean();

    return $wrap_start . $html . $wrap_end;	
}

add_filter( 'kopa_sanitize_option_quote', 'kopa_form_field_quote_sanitize', 10, 2 );	

function kopa_form_field_quote_sanitize( $quote, $field ) {		
	$quote            = wp_parse_args( $quote, array( 'author' => '', 'content' => '' ) );
	$quote['author']  = esc_html( $quote['author'] );
	$quote['content'] = esc_html( $quote['content'] );
	
	return $quote;
}
