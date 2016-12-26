<?php
////////// SHORCODES

// [fontpress] 
function fp_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' 		=> 'css_font',
		'name' 		=> '',
		'size' 		=> '',
		'lh' 		=> '',
		'color'		=> '',
		'shadow'	=> ''
	), $atts ) );

	
	if(trim($name) != '' || $type == 'inherited') {
		require_once('functions.php');
		
		$code = '<font ';
		
		// font name
		if($type == 'css_font') {$code .= 'class="fp_sc_div" style="font-family: \''.$name.'\' !important;';}
		elseif($type == 'inherited') {$code .= 'class="fp_sc_div" style="';}
		else {
			if($type == 'cufon') {$prefix = 'cf';}
			elseif($type == 'webfonts') {$prefix = 'wf';}
			elseif($type == 'ad_typekit') {$prefix = 'at';}
			else {$prefix = 'ff';} // fontface
			
			$code .= 'class="fp_sc_div fp_'.$prefix.'_'.fp_stringToUrl($name).'" style="';
		}
		
		// size
		if(trim($size) != '') {$code .= ' font-size: '.$size.' !important;';}
		
		// line height
		if(trim($lh) != '') {$code .= ' line-height: '.$lh.' !important;';}
		
		// color
		if(trim($color) != '') {$code .= ' color: '.$color.' !important;';}
		
		//shadow
		if(trim($shadow) != '') {
			$sh_data = explode('_', $shadow);
			$code .= ' text-shadow: '.$sh_data[0].'px '.$sh_data[1].'px '.$sh_data[2].'px '.$sh_data[3].' !important;';
		}
		
		$final = $code . '">' . do_shortcode($content) . '</font>';
		return $final;
	}
}
add_shortcode('fontpress', 'fp_shortcode');


?>