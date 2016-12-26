<?php 
include_once(FP_DIR.'/functions.php');
$cufon_list = fp_cufon_list();
?>

<div class="wrap fp_form lcwp_form">  
	<div class="icon32" id="pageicon-fontface"><br></div>
    <?php    echo '<h2 class="fp_page_title">' . __( 'Manage Cufons', 'fp_ml') . "</h2>"; ?>  

    <?php
	include(FP_DIR . '/classes/simple_form_validator.php');
	
	// UPLOAD DATA
	if(isset($_POST['fp_ul_cufon'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		$validator = new simple_fv;
		$indexes[] = array('index'=>'ul_cufon', 'label'=>__( 'Cufon Upload', 'fp_ml' ), 'ul_required'=>true);

		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		
		if(fp_stringToExt(strtolower($_FILES["ul_cufon"]["name"])) == '.js') {
		
			foreach($fdata as $key=>$val) {
				if(!is_array($val)) {
					$fdata[$key] = stripslashes($val);
				}
			}
			
			$file_name = fp_stringToUrl($_FILES['ul_cufon']['name']);
			if(file_exists(FP_DIR.'/cufon/'.$file_name)) {
				$validator->custom_error['Cufon File'] = __('There is already a file with the same name', 'fp_ml');	
			}
		}
		else {$validator->custom_error['Cufon File'] = __('Please upload a valid Cufon file', 'fp_ml');}
		
		
		$error = $validator->getErrors();
		
		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			
			// upload
			if(!move_uploaded_file($_FILES['ul_cufon']["tmp_name"], FP_DIR.'/cufon/'.$file_name)) {
				echo '<div class="error"><p>Error during file upload</p></div>';	
			}
			else {
				echo '<div class="updated"><p><strong>'. __('Cufon Uploaded', 'fp_ml') .'</strong></p></div>';
			}
		}
		
		// fix for cufon list
		$fdata['fp_cufon_enabled'] = get_option('fp'.FP_BID.'_cufon_enabled'); 
		$cufon_list = fp_cufon_list();
	}
	
	// ENABLE CUFON DATA
	elseif(isset($_POST['fp_save_cufon'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		$validator = new simple_fv;
		$indexes[] = array('index'=>'fp_cufon_enabled', 'label'=>__( 'Cufon Enabled', 'fp_ml' ));

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

			// cufons enabled
			if(!$fdata['fp_cufon_enabled']) {delete_option('fp'.FP_BID.'_cufon_enabled');}
			else {
				if(!get_option('fp'.FP_BID.'_cufon_enabled')) { add_option( 'fp'.FP_BID.'_cufon_enabled', '255', '', 'yes' ); }
				update_option('fp'.FP_BID.'_cufon_enabled', $fdata['fp_cufon_enabled']);
			}
			
			if(!get_option('fp_inline_code') && !fp_create_frontend_files()) {
			  echo '<div class="error"><p>'.__('An error occurred saving. Check your server permissions and retry to save the fonts', 'fp_ml').'</p></div>';
			}
			else {echo '<div class="updated"><p><strong>'. __('Cufons Updated', 'fp_ml') .'</strong></p></div>';}
		}
	}
	
	else {  
		$fdata['fp_cufon_enabled'] = get_option('fp'.FP_BID.'_cufon_enabled'); 
	}  
	?>
    
    <br/>
    
    <div class="lcwp_opt_block">
      <table class="widefat lcwp_opt_table" cellspacing="0" cellpadding="5">
      	<thead>
          <tr>
            <th scope="row">Upload Cufon</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          	<td>
            <?php if(is_writable(FP_DIR.'/cufon')) : ?>
            	<form name="lcwp_admin" method="post" class="form-wrap lcwp_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">  
                	<label><?php _e('Upload the .js cufon file', 'fp_ml') ?></label>
                	<input type="file" name="ul_cufon" size="20"  />
                    
                    <input type="submit" name="fp_ul_cufon" value="<?php _e('Upload Cufon', 'fp_ml') ?>" class="button-primary" style="margin: 0 15px 0 10px;" />
                    
                    <span>(<a href="http://cufon.shoqolate.com/generate/" target="_blank">Create a cufon</a>)</span>
                    
                    <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcweb') ?>" /> 
                </form>
             <?php else : ?>
             	<div style="padding: 0 15px;">
             	<p><?php _e('To upload cufon files the', 'fp_ml') ?> "<em><?php echo FP_DIR.'/cufon' ?></em>" <?php _e('directory needs to be writtable. <br/>Please check your server permissions.', 'fp_ml') ?></p>
                <p><?php _e('Otherwise you can paste manually javascript files in that plugin folder.', 'fp_ml') ?></p>
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
          // get all cufons
          foreach($cufon_list as $c_name=>$c_path) : 
		  	$c_name_id = fp_stringToUrl($c_name);
			
			if(is_array($fdata['fp_cufon_enabled']) && in_array($c_name, $fdata['fp_cufon_enabled'])) {
				$cf_sel = 'checked="checked"';	
			}
			else {$cf_sel = '';}
		  ?>
          
            <tr>
              <td>
                <label id="fn_<?php echo $c_name_id; ?>"><?php echo ucwords($c_name); ?></label>
                <input type="checkbox" name="fp_cufon_enabled[]" value="<?php echo $c_name; ?>" <?php echo $cf_sel; ?> />
                <span id="preview_<?php echo $c_name_id; ?>" class="fp_font_preview">Preview <strong>Preview</strong> <em>Preview</em> <strong><em>Preview</em></strong></span>
              </td>
              <td class="fp_del_font fp_del_cufon" id="del_<?php echo $c_name_id; ?>">
              	<span title="delete font"></span>
              </td>
            </tr>    
               
          <?php endforeach; ?>
        </tbody>
      </table>

      <p class="submit">  
      <input type="submit" name="fp_save_cufon" value="<?php _e('Update') ?>" class="button-primary" />  
      </p>  
      <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcweb') ?>" /> 
      </form>
    </div>
</div>  


<?php
wp_enqueue_script( 'fp-cufon', FP_URL.'/js/cufon-yui.js' );
foreach($cufon_list as $c_name=>$c_path) {
	$c_name = fp_stringToUrl($c_name);
	wp_enqueue_script( 'fp-'.$c_name, FP_URL.'/cufon/'.$c_path);
}
?>

<?php // SCRIPTS ?>
<script src="<?php echo FP_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf8">
jQuery(document).ready(function($) {
	
	// delete
	jQuery('.fp_del_cufon').click(function() {
		var font_id = jQuery(this).attr('id').substr(4);
		var font_name = jQuery('#fn_' + font_id).html();
		
		if(confirm('<?php _e('Delete permanently the font', 'fp_ml') ?> ' + font_name +'?')) {
			var data = {
				action: 'fp_delete_cufon',
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
	
	
	// cufon previews
	<?php 
	foreach($cufon_list as $c_name=>$c_path) {
		$c_name_id = fp_stringToUrl($c_name);
		echo 'Cufon.replace("#preview_'.$c_name_id.'", {fontFamily : "'.$c_name.'"});'; 
	}
	?>
});
</script>



