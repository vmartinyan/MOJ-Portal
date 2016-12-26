<?php 

// get all the cufons from a folder
function fp_cufon_list() {
	$fonts = array();
	$cufon_list = scandir(FP_DIR."/cufon");
	
	foreach($cufon_list as $font_file){
		if($font_file != '.' && $font_file != '..') {
			$file_content = file_get_contents(FP_DIR."/cufon/".$font_file);
			if(preg_match('/font-family":"(.*?)"/i',$file_content,$match)){
				$fonts[$match[1]] = basename($font_file);
			}
		}
	}
	return $fonts;
}


// get all the cufons from a folder
function fp_font_list() {
	$fonts = array();
	$font_list = scandir(FP_DIR."/fonts");
	
	foreach($font_list as $folder_name) {
		if($folder_name != '.' && $folder_name != '..') {
			$font_name = fp_urlToName($folder_name); // add the dot to mak it works
			$fonts[$font_name] = $folder_name;
		}
	}
	return $fonts;
}


// get the name of a font from a package
function fp_get_zip_fontname($folder) {
	$font_name = false;
	
	$file_list = scandir($folder.'/fonts'); // use fonts subfolder as per http://everythingfonts.com/font-face - Jan 2015	
	foreach($file_list as $file) {
		$ext = strtolower(fp_stringToExt($file));
		if($ext == '.ttf' || $ext == '.otf') {
			require_once(FP_DIR.'/classes/ttf_info.php');
			$fontinfo = getFontInfo($folder.'/fonts/'.$file);
			$font_name = fp_stringToUrl($fontinfo[4]);
			
			break;
		}
	}
	return $font_name;
}


// create definitive fontface font folder
// copy the font files from temp to new folder 
// delete the temp folder
function fp_copy_zip_fontfiles($tmp_folder, $new_folder) {
	// create
	mkdir($new_folder);	
	if(!file_exists($tmp_folder) || !file_exists($new_folder)) {return false;}
	
	// copy
	$file_list = scandir($tmp_folder.'/fonts'); // use fonts subfolder as per http://everythingfonts.com/font-face - Jan 2015	
	foreach($file_list as $file) {
		$ext = strtolower(fp_stringToExt($file));
		if($ext == '.ttf' || $ext == '.otf' || $ext == '.woff' || $ext == '.eot' || $ext == '.svg') {
			if(!copy($tmp_folder.'/fonts/'.$file, $new_folder.'/'.$file)) {return false; break;}
		}	
	}
	
	// delete
	fp_remove_folder($tmp_folder);
	
	return true;
}
	

// get file extension from a filename
function fp_stringToExt($string) {
	$pos = strrpos($string, '.');
	$ext = strtolower(substr($string,$pos));
	return $ext;	
}


// get filename without extension
function fp_stringToFilename($string, $raw_name = false) {
	$pos = strrpos($string, '.');
	$name = substr($string,0 ,$pos);
	if(!$raw_name) {$name = ucwords(str_replace('_', ' ', $name));}
	return $name;	
}


// string to url format
function fp_stringToUrl($string){
	$trans = array("à" => "a", "è" => "e", "é" => "e", "ò" => "o", "ì" => "i", "ù" => "u");
	$string = trim(strtr($string, $trans));
	$string = preg_replace('/[^a-zA-Z0-9-.]/', '_', $string);
	$string = preg_replace('/-+/', "_", $string);
	$string = str_replace(array('.', '#'), '_', $string);
	
	while( substr($string, 0, 1) == '_') {
		$string = substr($string, 1);	
	}
	
	return $string;
}


// normalize a url string
function fp_urlToName($string) {
	$string = ucwords(str_replace('_', ' ', $string));
	return $string;	
}


// remove a folder and its contents
function fp_remove_folder($path) {
	if($objs = @glob($path."/*")){
		foreach($objs as $obj) {
			@is_dir($obj)? fp_remove_folder($obj) : @unlink($obj);
		}
	 }
	@rmdir($path);
	return true;
}


// remove enabled font during deletion
function fp_remove_enabled($to_remove, $opt_name) {
	$array = get_option($opt_name);
	if(!$array) {return false;}
	
	$new_array = $array;
	foreach($array as $key => $data) {
		if($to_remove == $key) {
			unset($new_array[$key]);
			break;	
		}	
	}
	
	if(count($new_array) > 0) {update_option($opt_name, $new_array);}
	else {delete_option($opt_name);}
	
	return true;
}


// convert HEX to RGB
function fp_hex2rgb($hex) {
   	// if is RGB - return it
   	$pattern = '/^#[a-f0-9]{6}$/i';
	if(empty($hex) || !preg_match($pattern, $hex)) {return $hex;}
  
	$hex = str_replace("#", "", $hex);
   	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
  
	return 'rgb('. implode(",", $rgb) .')'; // returns the rgb values separated by commas
}


// convert RGB to HEX
function fp_rgb2hex($rgb) {
   	// if is hex - return it
   	$pattern = '/^#[a-f0-9]{6}$/i';
	if(empty($rgb) || preg_match($pattern, $rgb)) {return $rgb;}

  	$rgb = explode(',', str_replace(array('rgb(', ')'), '', $rgb));
  	
	$hex = "#";
	$hex .= str_pad(dechex( trim($rgb[0]) ), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex( trim($rgb[1]) ), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex( trim($rgb[2]) ), 2, "0", STR_PAD_LEFT);

	return $hex; 
}


// get adobe typekit data through cURL
function fp_get_kit_data($kit_id) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, 'https://typekit.com/api/v1/json/kits/'.$kit_id.'/published');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	
	$response = curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if(($code != 200 && $code != 404) || !$response) {
		return false;		
	} 
	elseif($code == 404) {
		return 'not found';		
	} 
	else {
		// check proper format
		$response = json_decode($response, true); 
		if(!is_array($response) || !isset($response['kit'])) {return false;}
		
		$fonts = $response['kit']['families'];
		$data = array();
		
		foreach($fonts as $font) {
			$data[ $font['slug'] ] = array('name' => $font['name'], 'css' => $font['css_stack']);
		}
		return $data;
	}	
}


////////////////////////////////////////////////////////////

// create the options for enabled fonts select
// @param $type -> cufon, webfonts, fontface
function fp_get_enabled_fonts($type, $selected = false) {
	$opts = '';
	
	if($type == 'cufon') {
		$cufon_list = get_option('fp'.FP_BID.'_cufon_enabled');
		
		if($cufon_list) {
			foreach($cufon_list as $cufon) {
				($selected == $cufon) ? $sel = 'selected="selected"' : $sel = '';
				$opts .= '<option value="'.$cufon.'" '.$sel.'>'.$cufon.'</cufon>';	
			}
		}
	}
	
	if($type == 'webfonts') {
		$webfont_list = get_option('fp'.FP_BID.'_webfonts_enabled');
		if($webfont_list) {
			foreach($webfont_list as $webfont) {
				($selected == $webfont) ? $sel = 'selected="selected"' : $sel = '';
				$opts .= '<option value="'.$webfont.'" '.$sel.'>'.$webfont.'</cufon>';	
			}
		}
	}
	
	if($type == 'fontface') {
		$font_list = get_option('fp'.FP_BID.'_font_enabled');
		if($font_list) {
			foreach($font_list as $font) {
				($selected == $font) ? $sel = 'selected="selected"' : $sel = '';
				$opts .= '<option value="'.$font.'" '.$sel.'>'.fp_urlToName($font).'</cufon>';	
			}
		}
	}
	
	if($type == 'ad_typekit') {
		$kits_list = (array)unserialize(get_option('fp_adobe_typekits', ''));
		$enabled_kits = get_option('fp'.FP_BID.'_ad_typekits_enabled', array());
		
		if($kits_list) {
			foreach($kits_list as $id => $data) {
				if(!in_array($id, $enabled_kits)) {continue;}
				
				foreach($data as $slug => $subdata) {
					($selected == $slug) ? $sel = 'selected="selected"' : $sel = '';
					$opts .= '<option value="'.$slug.'" '.$sel.'>'.$subdata['name'].'</cufon>';
				}
			}
		}
	}
	
	return $opts;	
}


// elements array for main setting
function fp_get_elements($return = 'array', $selected = false) {
	$elements = array(
		'body' 				=> __('All page elements', 'fp_ml'),
		'h1,h2,h3,h4,h5,h6'	=> __('Headings', 'fp_ml'),
		'custom'			=> __('Custom Element', 'fp_ml')
	);
	
	if($return == 'html') {
		$html_el = '';
		foreach($elements as $key => $val) {
			($selected == $key) ? $sel = 'selected="selected"' : $sel = '';
			$html_el .= '<option value="'.$key.'" '.$sel.'>'.$val.'</option>'; 	
		}
		return $html_el;
	}
	else {return $elements;}	
}


// font types array for main setting
function fp_get_fontypes($return = 'array', $selected = false) {
	$elements = array(
		'cufon' 		=> 'Cufons',
		'webfonts'		=> 'Web Fonts',
		'fontface'		=> 'Font-Face Fonts',
		'ad_typekit' 	=> 'Adobe Typekit',
		'css_font' 		=> 'Standard CSS Font', 
		'inherited'		=> 'Inherited Font'
	);
	
	if($return == 'html') {
		$html_el = '';
		foreach($elements as $key => $val) {
			($selected == $key) ? $sel = 'selected="selected"' : $sel = '';
			$html_el .= '<option value="'.$key.'" '.$sel.'>'.$val.'</option>'; 	
		}
		return $html_el;
	}
	else {return $elements;}	
}


// font size types array for main setting
function fp_get_fontsize_types($return = 'array', $selected = false) {
	$elements = array(
		'px' 	=> 'px',
		'em'	=> 'em',
		'%'		=> '%',
		'pt'	=> 'pt'
	);
	
	if($return == 'html') {
		$html_el = '';
		foreach($elements as $key => $val) {
			($selected == $key) ? $sel = 'selected="selected"' : $sel = '';
			$html_el .= '<option value="'.$key.'" '.$sel.'>'.$val.'</option>'; 	
		}
		return $html_el;
	}
	else {return $elements;}	
}


// general rules - form creator per row
function fp_rule_row_form($data) {
	if(!$data) {return false;}
	
	// basic block
	elseif($data == 'basic_row') {
		$html = '
		<tr>
		  <td>
		  	<span class="fp_del_rule"></span>
		  </td>
		  <td>
			<span class="fp_move_rule"></span>
		  </td>
		  <td style="width: 200px;">
		  	<select name="element[]" class="choose_element">
			  '.fp_get_elements('html').'
			</select>
		  </td>
		  <td>
		  	<input type="hidden" name="element_subj[]" value="body" />
		  	<span>body</span>
		  </td>
		  <td>
		  	<select name="font_type[]" class="choose_font_type">
			  '.fp_get_fontypes('html').'
			</select>
		  </td>
		  <td>
		  	<select name="font_name[]">
				'.fp_get_enabled_fonts('cufon').'
			</select>
		  </td>
		  <td class="fp_size_choose">
		  	<input type="hidden" name="font_size[]" value="" />
			<input type="hidden" name="font_size_type[]" value="px" />
		  </td>
		  <td class="fp_line_height">
		  	<input type="hidden" name="line_height[]" value="" />
			<input type="hidden" name="line_height_type[]" value="px" />
		  </td>
		  <td>
			  <div class="lcwp_colpick">
					<span class="lcwp_colblock"></span>
					<input type="text" name="text_color[]" value="" />
			  </div>
		  </td>
		  <td class="fp_shadow">
			  <label title="X axis offset">X</label>
			  <input type="text" name="shadow_x[]" value="" />
			  
			  <label title="Y axis offset">Y</label>
			  <input type="text" name="shadow_y[]" value="" />
			  
			  <label title="shadow radius">R</label>
			  <input type="text" name="shadow_r[]" value="" /><br/>
			  
			  <div class="lcwp_colpick">
					<span class="lcwp_colblock"></span>
					<input type="text" name="shadow_color[]" value="" />
			  </div>
		  </td>
		</tr>	
		';
	}
	
	// recreation from WP option
	else {
		$html = '';
		
		foreach($data as $rules) {
			$html .= '
			<tr>
			  <td>
				<span class="fp_del_rule"></span>
			  </td>
			  <td>
				<span class="fp_move_rule"></span>
			  </td>
			  <td style="width: 200px;">
				<select name="element[]" class="choose_element">
				  '.fp_get_elements('html', $rules['element']).'
				</select>
			  </td>
			  <td>';
			  
			  // subject
			  if($rules['element'] != 'custom') {
				  $html .= '
				  	<input type="hidden" name="element_subj[]" value="'.$rules['element'].'" />
					<span>'.$rules['element'].'</span>';
			  }
			  else {$html .= '<input type="text" name="element_subj[]" value="'.$rules['subj'].'" />';}
			  
			  // font type
			  $html .= '
			  </td>
			  <td>
				<select name="font_type[]" class="choose_font_type">
				  '.fp_get_fontypes('html', $rules['font_type']).'
				</select>
			  </td>
			  <td>';
			  
			  // font name
			  if($rules['font_type'] != 'css_font' && $rules['font_type'] != 'inherited') {
				  $html .= '
				  <select name="font_name[]">'.
					fp_get_enabled_fonts($rules['font_type'], $rules['font_name']).
				  '</select>';
			  }
			  elseif($rules['font_type'] == 'css_font') {
				  $html .= '<input type="text" name="font_name[]" value="'.$rules['font_name'].'" />';
			  }
			  else {$html .= '<input type="hidden" name="font_name[]" value="inherited" />';}
			  
			  $html .= '
			  </td>
			  <td class="fp_size_choose">
			  ';
			  
			  // font size
			  if($rules['element'] == 'custom') {
				  $html .= '
				  <input type="text" name="font_size[]" value="'.$rules['font_size'].'" />
				  <select name="font_size_type[]">
					  '.fp_get_fontsize_types('html', $rules['font_size_type']).'
				  </select>';
			  }
			  else {
				  $html .= '
				  <input type="hidden" name="font_size[]" value="" />
				  <input type="hidden" name="font_size_type[]" value="px" />';
			  }
			  
			  $html .= '
			  </td>
			  <td class="fp_line_height">
			  ';
			  
			  // line height
			  if($rules['element'] == 'custom') {
				  $html .= '
				  <input type="text" name="line_height[]" value="'.$rules['line_height'].'" />
				  <select name="line_height_type[]">
					  '.fp_get_fontsize_types('html', $rules['line_height_type']).'
				  </select>';
			  }
			  else {
				  $html .= '
				  <input type="hidden" name="line_height[]" value="" />
				  <input type="hidden" name="line_height_type[]" value="px" />';
			  }
				
			  $html .= '
			  </td>
			  <td>
				  <div class="lcwp_colpick">
				  		<span class="lcwp_colblock" style="background-color: '.$rules['text_color'].';"></span>
				  		<input type="text" name="text_color[]" value="'.$rules['text_color'].'" />
				  </div>
			  </td>
			  <td class="fp_shadow">
				  <label title="X axis offset">X</label>
				  <input type="text" name="shadow_x[]" value="'.$rules['shadow_x'].'" />
				  
				  <label title="Y axis offset">Y</label>
				  <input type="text" name="shadow_y[]" value="'.$rules['shadow_y'].'" />
				  
				  <label title="shadow radius">R</label>
				  <input type="text" name="shadow_r[]" value="'.$rules['shadow_r'].'" /><br/>
				  
				  <div class="lcwp_colpick">
				  		<span class="lcwp_colblock" style="background-color: '.$rules['shadow_color'].';"></span>
				  		<input type="text" name="shadow_color[]" value="'.fp_rgb2hex($rules['shadow_color']).'" />
				  </div>
			  </td>
			  
			</tr>';	
		}
	}
	
	return $html;	
}


// enqueue enabled cufon for the frontend
function fp_enqueue_enabled_cufon() {
	$enabled_list = get_option('fp'.FP_BID.'_cufon_enabled');
	$cufon_list = fp_cufon_list();
	
	if($enabled_list) {
		wp_enqueue_script( 'fp-cufon', FP_URL.'/js/cufon-yui.js' );	
		
		foreach($enabled_list as $enabled) {
			$enabled_id = fp_stringToUrl($enabled);
			wp_enqueue_script('fp_cufon_'.$enabled_id, FP_URL . '/cufon/'.$cufon_list[$enabled]);	
		}
	}
	return true;
}


// enqueue enabled cufon for the frontend
function fp_enqueue_enabled_webfont() {
	$enabled_list = get_option('fp'.FP_BID.'_webfonts_enabled');
	$webfont_list = get_option('fp_webfonts');
	
	if($enabled_list) {
		foreach($enabled_list as $enabled) {
			$enabled_id = fp_stringToUrl($enabled);
			
			// remove the HTTP/HTTPS for SSL compatibility
			$fixed_enabled = str_replace(array('http:', 'https:', 'HTTP:', 'HTTPS:'), '', $webfont_list[$enabled]);
			
			// enqueue for fifferent types
			if(strpos($webfont_list[$enabled], '/css?') === false) {
				wp_enqueue_script('fp_EdgeFont_'.$enabled_id, $fixed_enabled);
			} else {
				wp_enqueue_style('fp_webfont_'.$enabled_id, $fixed_enabled);
			}
		}
	}
	return true;
}


// fontface CSS code creator
function fp_fontface_css_creator($folder_name) {
	$path = FP_DIR . '/fonts/'.$folder_name;
	$font_name = fp_urlToName($folder_name);
	
	// remove the HTTP/HTTPS for SSL compatibility
	$fixed_enabled = str_replace(array('http:', 'https:', 'HTTP:', 'HTTPS:'), '', FP_URL);
	$font_baseurl = $fixed_enabled . '/fonts/'.$folder_name.'/';
	
	// get files name
	$file_list = scandir($path);	
	$file_name = fp_stringToFilename($file_list[2], true);	

	$css = "
@font-face {
	font-family: '".$font_name."';
	src: url('".$font_baseurl.$file_name.".eot');
	src: url('".$font_baseurl.$file_name.".eot?#iefix') format('embedded-opentype'),
		 url('".$font_baseurl.$file_name.".woff') format('woff'),
		 url('".$font_baseurl.$file_name.".ttf') format('truetype'),
		 url('".$font_baseurl.$file_name.".svg#".$file_name."') format('svg');
}
	";
	return $css;
}


// enqueue enabled adobe typekit for the frontend
function fp_enqueue_enabled_typekit() {
	$kits_list = (array)unserialize(get_option('fp_adobe_typekits', ''));
	$enabled_kits = get_option('fp'.FP_BID.'_ad_typekits_enabled', array());
	
	if($enabled_kits && $kits_list) {
		foreach($kits_list as $id => $data) {
			if(!in_array($id, $enabled_kits)) {continue;}
			wp_enqueue_script('fp_typekit_'.$id, "//use.typekit.net/". $id .".js");
		}
	}

	return true;
}


// adobe typekit get CSS name from slug
function fp_typekit_css_name($font_slug) {
	$kits_list = (array)unserialize(get_option('fp_adobe_typekits', ''));

	if($kits_list) {
		foreach($kits_list as $id => $data) {
			foreach($data as $slug => $subdata) {
				if($font_slug == $slug) {
					return $subdata['css'];
					break;	
				}
			}
		}
	}
}


/////////////////////////////////////////////////////////////////

// create the frontend css and js
function fp_create_frontend_files() {
	// css
	ob_start();
	require_once(FP_DIR.'/frontend_css.php');
	$css = ob_get_clean();
	
	if(trim($css) != '') {
		if(!file_put_contents(FP_DIR.'/custom_files/frontend'.FP_BID.'.css', $css, LOCK_EX)) {$error = true;}
	} else {
		if(file_exists(FP_DIR.'/custom_files/frontend'.FP_BID.'.css'))	{ unlink(FP_DIR.'/custom_files/frontend'.FP_BID.'.css'); }
	}
	
	// js
	ob_start();
	require(FP_DIR.'/frontend_js.php');
	$js = ob_get_clean();
	
	if(trim($js) != '') {
		if(!file_put_contents(FP_DIR.'/custom_files/frontend'.FP_BID.'.js', $js, LOCK_EX)) {$error = true;}
	} else {
		if(file_exists(FP_DIR.'/custom_files/frontend'.FP_BID.'.js'))	{ unlink(FP_DIR.'/custom_files/frontend'.FP_BID.'.js'); }
	}
	
	if(isset($error)) {return false;}
	else {return true;}
}

?>