<?php 
include_once(FP_DIR.'/functions.php');
$font_list = fp_font_list();
?>

<div class="wrap fp_form lcwp_form"> 
	<div class="icon32" id="pageicon-fontface"><br></div> 
    <?php    echo '<h2 class="fp_page_title">' . __( 'Manage Font-Face Fonts', 'fp_ml') . "</h2>"; ?>  

    <?php
	include(FP_DIR . '/classes/simple_form_validator.php');
	
	// UPLOAD DATA
	if(isset($_POST['fp_ul_font'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		$validator = new simple_fv;
		$indexes[] = array('index'=>'ul_font', 'label'=>__( 'Font Upload', 'fp_ml' ), 'ul_required'=>true);

		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		
		// zip package upload
		if(fp_stringToExt(strtolower($_FILES["ul_font"]["name"])) == '.zip') {
			$file_name = fp_stringToUrl($_FILES['ul_font']['name']);	
			if(trim($file_name == '')) {$validator->custom_error['Font File'] = __('Error during file upload', 'fp_ml');}
			
			else {
				$temp_folder = FP_DIR."/temp/".$file_name;
				mkdir($temp_folder);
				
				if(!file_exists($temp_folder)) {
					$validator->custom_error['Font File'] = __('Error during file upload', 'fp_ml');
					fp_remove_folder($temp_folder);
				}
				else {
					WP_Filesystem();
					unzip_file( $_FILES['ul_font']['tmp_name'], $temp_folder);
					$filename = fp_get_zip_fontname($temp_folder);
					
					if(trim($filename) == '') {
						$validator->custom_error['Font File'] = __('No font file found', 'fp_ml');
						fp_remove_folder($temp_folder);	
					}
					else {
						if(file_exists(FP_DIR.'/fonts/'.$filename)) {
							$validator->custom_error['Font File'] = __('There is already a font with the same name', 'fp_ml');
							fp_remove_folder($temp_folder);	
						}
						else {
							// create definitive folder and copy font files
							if(!fp_copy_zip_fontfiles($temp_folder, FP_DIR.'/fonts/'.$filename)) {
								$validator->custom_error['Font File'] = __('Error during file upload', 'fp_ml');
							}
						}
					}
				}
			}
		}
		else {$validator->custom_error['Font Package'] = __('Please upload a valid zip package', 'fp_ml');}
		
		$error = $validator->getErrors();
		
		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			echo '<div class="updated"><p><strong>'. __('Font Uploaded', 'fp_ml') .'</strong></p></div>';
		}
		
		// fix for font list
		$fdata['fp_font_enabled'] = get_option('fp'.FP_BID.'_font_enabled'); 
		$font_list = fp_font_list();
	}
	
	// ENABLE FONT DATA
	elseif(isset($_POST['fp_save_font'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		$validator = new simple_fv;
		$indexes[] = array('index'=>'fp_font_enabled', 'label'=>__( 'Font Enabled', 'fp_ml' ));

		$validator->formHandle($indexes);
		$error = $validator->getErrors();
		$fdata = $validator->form_val;

		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			foreach($fdata as $key=>$val) {
				if(is_array($val)) {
					$fdata[$key] = array();
					foreach($val as $arr_val) {$fdata[$key][] = stripslashes($arr_val);}
				}
			}

			// font enabled
			if(!$fdata['fp_font_enabled']) {delete_option('fp'.FP_BID.'_font_enabled');}
			else {
				if(!get_option('fp'.FP_BID.'_font_enabled')) { add_option( 'fp'.FP_BID.'_font_enabled', '255', '', 'yes' ); }
				update_option('fp'.FP_BID.'_font_enabled', $fdata['fp_font_enabled']);
			}
			
			if(!get_option('fp_inline_code') && !fp_create_frontend_files()) {
			  echo '<div class="error"><p>'.__('An error occurred saving. Check your server permissions and retry to save the fonts', 'fp_ml').'</p></div>';
			}
			else {echo '<div class="updated"><p><strong>'. __('Fonts Updated', 'fp_ml') .'</strong></p></div>';}
		}
	}
	
	else {  
		$fdata['fp_font_enabled'] = get_option('fp'.FP_BID.'_font_enabled'); 
	}  
	?>
    
    <style type="text/css">
    <?php
	// create css for previews
	foreach($font_list as $f_name=>$f_path) {
		
echo fp_fontface_css_creator($f_path). '

#preview_'.$f_path.' {	
	font-family: "'.$f_name.'";
}';
	}
	?>
	</style>
    
    <br/>
    
    <div class="lcwp_opt_block">
      <table class="widefat lcwp_opt_table" cellspacing="0" cellpadding="5">
      	<thead>
          <tr>
            <th scope="row">Upload Font</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          	<td>
            <?php if(is_writable(FP_DIR.'/temp')) : ?>
            	<form name="lcwp_admin" method="post" class="form-wrap lcwp_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">  
                	<label><?php _e('Upload the .zip font-face package', 'fp_ml') ?></label>
                	<input type="file" name="ul_font" size="20"  />
                    
                    <input type="submit" name="fp_ul_font" value="<?php _e('Upload Font', 'fp_ml') ?>" class="button-primary" style="margin: 0 15px 0 10px;" />
                    <span>(<a href="http://everythingfonts.com/font-face" target="_blank">Create a font-face package</a>)</span>
                    
                    <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcweb') ?>" /> 
                </form>
             <?php else : ?>
             	<div style="padding: 0 15px;">
                <p><?php _e('To upload @fontface packages the', 'fp_ml') ?> "<em><?php echo FP_DIR.'/temp' ?></em>" <?php _e('directory needs to be writtable. <br/>Please check your server permissions.', 'fp_ml') ?></p>
                <p><?php _e('Otherwise you can create manually a subfolder with the font name in that plugin folder and put withing the @fontface files.', 'fp_ml') ?></p>
                </div>
             <?php endif; ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    
    <div class="lcwp_opt_block">
      <form name="lcwp_admin" method="post" class="form-wrap lcwp_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">      
      <table class="widefat lcwp_opt_table fp_font_list_table" cellspacing="0" cellpadding="5">
      	<thead>
          <tr>
            <th scope="row" colspan="2">Choose which one to use</th>
          </tr>
        </thead>
        <tbody>
		  <?php
          // get all fonts
          foreach($font_list as $f_name=>$f_folder) : 
		  	$f_name_id = fp_stringToUrl($f_name);
			
			if(is_array($fdata['fp_font_enabled']) && in_array($f_folder, $fdata['fp_font_enabled'])) {
				$cf_sel = 'checked="checked"';	
			}
			else {$cf_sel = '';}
		  ?>
          
            <tr>
              <td>
                <label id="fn_<?php echo $f_folder; ?>"><?php echo ucwords($f_name); ?></label>
                <input type="checkbox" name="fp_font_enabled[]" value="<?php echo $f_folder; ?>" <?php echo $cf_sel; ?> />
                <span id="preview_<?php echo $f_folder; ?>" class="fp_font_preview">preview <strong>preview</strong> <em>preview</em> <strong><em>preview</em></strong></span>
              </td>
              <td class="fp_del_font fp_del_fontface" id="del_<?php echo $f_folder; ?>">
              	<span title="delete font"></span>
              </td>
            </tr>    
               
          <?php endforeach; ?>
        </tbody>
      </table>

      <p class="submit">  
      <input type="submit" name="fp_save_font" value="<?php _e('Update') ?>" class="button-primary" />  
      </p>  
      <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcweb') ?>" /> 
      </form>
    </div>
</div>  

<?php // SCRIPTS ?>
<script src="<?php echo FP_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf8">
jQuery(document).ready(function($) {
	
	// delete
	jQuery('.fp_del_fontface').click(function() {
		var font_id = jQuery(this).attr('id').substr(4);
		var font_name = jQuery('#fn_' + font_id).html();
		
		if(confirm('<?php _e('Delete permanently the font', 'fp_ml') ?> ' + font_name +'?')) {
			var data = {
				action: 'fp_delete_fontface',
				font_id: font_id
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				if( jQuery.trim(response) == 'success') {
					jQuery('#del_' + font_id).parent().slideUp(function() {
						jQuery(this).remove();
					});
				}
				else {
					console.log(response);
					alert('<?php _e('Error during font deletion'); ?>');
				}
			});	
		}
	});
	
	
	// lc switch
	jQuery(':checkbox').lc_switch('YES', 'NO');
});
</script>



