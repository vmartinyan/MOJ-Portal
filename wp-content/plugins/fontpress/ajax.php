<?php

////////////////////////////////////////////////
////// ADD BASIC RULE BLOCK ////////////////////
////////////////////////////////////////////////

function fp_add_rule_php() {
	require_once(FP_DIR.'/functions.php');
	echo fp_rule_row_form('basic_row');
	die();	
}
add_action('wp_ajax_fp_add_rule', 'fp_add_rule_php');



////////////////////////////////////////////////
////// GET FONT TYPE SELECT ////////////////////
////////////////////////////////////////////////

function fp_get_font_type_php() {
	require_once(FP_DIR.'/functions.php');
	$font_type = trim(addslashes($_POST['font_type']));
	
	echo '<select name="font_name[]">'.
		fp_get_enabled_fonts($font_type).
		'</select>';
	die();	
}
add_action('wp_ajax_fp_get_font_type', 'fp_get_font_type_php');



////////////////////////////////////////////////
////// GET FONT TYPE SELECT  FOR TINYMCE ///////
////////////////////////////////////////////////

function fp_get_font_type_tinymce_php() {
	require_once(FP_DIR.'/functions.php');
	$font_type = trim(addslashes($_POST['font_type']));
	
	echo '<select id="fp-font-name" name="fp-font-name" style="width: 204px;">'.
		fp_get_enabled_fonts($font_type).
		'</select>';
	die();	
}
add_action('wp_ajax_fp_get_font_type_tinymce', 'fp_get_font_type_tinymce_php');



////////////////////////////////////////////////
////// GET FONT SIZE TYPE SELECT ///////////////
////////////////////////////////////////////////

function fp_get_font_size_type_php() {
	require_once(FP_DIR.'/functions.php');
	echo fp_get_fontsize_types('html');
	die();	
}
add_action('wp_ajax_fp_get_font_size_type', 'fp_get_font_size_type_php');



////////////////////////////////////////////////
////// REMOVE WEB FONT /////////////////////////
////////////////////////////////////////////////

function fp_delete_webfont_php() {
	require_once(FP_DIR.'/functions.php');

	$font_id = trim(addslashes($_POST['font_id'])); 
	$webfont_array = get_option('fp_webfonts');
	
	foreach($webfont_array as $wf_name => $wf_url) {
		$wf_name_id = fp_stringToUrl($wf_name);
		
		if($wf_name_id == $font_id) {
			$to_remove = $wf_name;
			$success = true;
			unset($webfont_array[$wf_name]);
			break;	
		}
	}
	
	if(isset($success)) {
		fp_remove_enabled($to_remove, 'fp_webfonts_enabled');
		update_option('fp_webfonts', $webfont_array);
		
		echo 'success';
	}
	else {echo 'error';}
	die();	
}
add_action('wp_ajax_fp_delete_webfont', 'fp_delete_webfont_php');



////////////////////////////////////////////////
////// REMOVE CUFON ////////////////////////////
////////////////////////////////////////////////

function fp_delete_cufon_php() {
	require_once(FP_DIR.'/functions.php');
	
	$font_id = trim(addslashes($_POST['font_id'])); 
	$cufon_list = fp_cufon_list();
	
	foreach($cufon_list as $c_name=>$c_path) {
		$c_name_id = fp_stringToUrl($c_name);
		
		if($c_name_id == $font_id && file_exists(FP_DIR.'/cufon/'.$c_path)) {
			$to_remove = $c_name;
			$success = true;
			unlink(FP_DIR.'/cufon/'.$c_path);
			break;	
		}
	}
	
	if(isset($success)) {
		fp_remove_enabled($to_remove, 'fp_cufon_enabled');
		echo 'success';
	}
	else {echo 'error';}
	die();	
}
add_action('wp_ajax_fp_delete_cufon', 'fp_delete_cufon_php');



////////////////////////////////////////////////
////// REMOVE FONTFACE /////////////////////////
////////////////////////////////////////////////

function fp_delete_fontface_php() {
	require_once(FP_DIR.'/functions.php');
	
	$font_id = addslashes($_POST['font_id']); 
	$font_list = fp_font_list();
	
	foreach($font_list as $f_name=>$f_path) {
		$f_name_id = fp_stringToUrl($f_name);
		
		if($f_name_id == $font_id && file_exists(FP_DIR.'/fonts/'.$f_path)) {
			$to_remove = $f_name;
			$success = true;
			fp_remove_folder(FP_DIR.'/fonts/'.$f_path);
			break;	
		}
	}
	
	if(isset($success)) {
		fp_remove_enabled($to_remove, 'fp_font_enabled');
		echo 'success';
	}
	else {echo 'error';}
	die();	
}
add_action('wp_ajax_fp_delete_fontface', 'fp_delete_fontface_php');



////////////////////////////////////////////////
////// REMOVE TYPEKIT //////////////////////////
////////////////////////////////////////////////

function fp_delete_typekit_php() {
	require_once(FP_DIR.'/functions.php');
	
	$kit_id = $_POST['kit_id']; 
	$kits_list = (array)unserialize(get_option('fp_adobe_typekits', ''));
	
	if(isset($kits_list[$kit_id])) {
		unset($kits_list[$kit_id]);
		update_option('fp_adobe_typekits', serialize($kits_list));	
	}
	
	die('success');	
}
add_action('wp_ajax_fp_delete_typekit', 'fp_delete_typekit_php');



////////////////////////////////////////////////
////// RE-SYNC TYPEKIT /////////////////////////
////////////////////////////////////////////////

function fp_sync_typekit() {
	require_once(FP_DIR.'/functions.php');
	
	$kit_id = $_POST['kit_id']; 
	$kits_list = (array)unserialize(get_option('fp_adobe_typekits', ''));
	
	if(isset($kits_list[$kit_id])) {
		$data = fp_get_kit_data($kit_id); // contained fonts data array 
		
		if(!$data) {_e('cURL call failed', 'fp_ml'); die();}
		elseif($data == 'not found') {_e('This kit ID does not exist', 'fp_ml'); die();}
	
		$kits_list[$kit_id] = $data;
		update_option('fp_adobe_typekits', serialize($kits_list));	
	}
	
	die('success');	
}
add_action('wp_ajax_fp_sync_typekit', 'fp_sync_typekit');
