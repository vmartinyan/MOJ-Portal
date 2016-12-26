<?php 
include_once(FP_DIR.'/functions.php');

// web fonts
$webfonts_list = get_option('fp_webfonts');
if(!$webfonts_list) {$webfonts_list = array();}
?>

<div class="wrap fp_form lcwp_form">  
	<div class="icon32" id="pageicon-fontface"><br></div>
    <?php echo '<h2 class="fp_page_title">' . __( 'Manage Web Fonts', 'fp_ml') . "</h2>"; ?>  

    <?php
	include_once(FP_DIR . '/classes/simple_form_validator.php');
	
	// add 
	if(isset($_POST['fp_add_webfont'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		$validator = new simple_fv;
		$indexes[] = array('index'=>'webfont_name', 'label'=>__( 'Web Font Name', 'fp_ml' ), 'required'=>true);
		$indexes[] = array('index'=>'webfont_url', 'label'=>__( 'Web Font URL', 'fp_ml' ), 'required'=>true, 'type'=>'url');

		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		
		foreach($fdata as $key=>$val) {
			if(!is_array($val)) {
				$fdata[$key] = stripslashes($val);	
			}
		}
		
		// check for duplicates
		if(count($webfonts_list) > 0 && isset($webfonts_list[$fdata['webfont_name']])) {
			$validator->custom_error['Web Font'] = __('There is already a web font with the same name', 'fp_ml');		
		}
		
		$error = $validator->getErrors();
		
		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			// add to array
			if(count($webfonts_list) == 0) {$webfonts_list = array($fdata['webfont_name'] => $fdata['webfont_url']);}
			else {$webfonts_list[$fdata['webfont_name']] = $fdata['webfont_url'];}
			ksort($webfonts_list);
			
			if(!get_option('fp_webfonts')) { add_option( 'fp_webfonts', '255', '', 'yes' ); }
			update_option('fp_webfonts', $webfonts_list);
		}
		
		// fix for webfonts enabled
		$fdata['fp_webfonts_enabled'] = get_option('fp'.FP_BID.'_webfonts_enabled'); 
	}
	
	// ENABLE WEB FONTS DATA
	elseif(isset($_POST['fp_save_webfonts'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		$validator = new simple_fv;
		$indexes[] = array('index'=>'fp_webfonts_enabled', 'label'=>__( 'Web Fonts Enabled', 'fp_ml' ));

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

			// web fonts enabled
			if(!$fdata['fp_webfonts_enabled']) {delete_option('fp'.FP_BID.'_webfonts_enabled');}
			else {
				if(!get_option('fp'.FP_BID.'_webfonts_enabled')) { add_option( 'fp'.FP_BID.'_webfonts_enabled', '255', '', 'yes' ); }
				update_option('fp'.FP_BID.'_webfonts_enabled', $fdata['fp_webfonts_enabled']);
			}
			
			if(!get_option('fp_inline_code') && !fp_create_frontend_files()) {
			  echo '<div class="error"><p>'.__('An error occurred saving. Check your server permissions and retry to save the fonts', 'fp_ml').'</p></div>';
			}
			else {echo '<div class="updated"><p><strong>'. __('Web Fonts Updated', 'fp_ml') .'</strong></p></div>';}
		}
	}
	
	else {  
		$fdata['fp_webfonts_enabled'] = get_option('fp'.FP_BID.'_webfonts_enabled'); 
	}  
	?>
    
    <?php
	foreach($webfonts_list as $wf_name => $wf_url) {
		$wf_name_id = fp_stringToUrl($wf_name);

		if(strpos($wf_url, '/css?') === false) {
			wp_enqueue_script('fp-'.$wf_name_id, $wf_url);
		} else {
			wp_enqueue_style('fp-'.$wf_name_id, $wf_url);	
		}
	}
	?>
    
	<style type="text/css">
    <?php
    foreach($webfonts_list as $wf_name => $wf_url) {
        $wf_name_id = fp_stringToUrl($wf_name);
        echo '#preview_'.$wf_name_id.' {font-family: '.$wf_name.';}';
    }
    ?>
    </style>   
    
    <br/>
    
    <div class="lcwp_opt_block">
      <form name="lcwp_admin" method="post" class="form-wrap lcwp_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
      <table class="widefat lcwp_opt_table" cellspacing="0" cellpadding="5">
      	<thead>
          <tr>
            <th scope="row">Add Web Font</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          	<td> 	
              <label><?php _e('Font Name', 'fp_ml') ?></label>
              <input type="text" name="webfont_name" value="" size="30" style="margin-right: 20px;" />
              <span>(Get a <a href="http://www.google.com/webfonts#ChoosePlace:select" target="_blank">Google</a> or <a href="http://html.adobe.com/edge/webfonts/" target="_blank">Adobe</a> web font)</span>
            </td>
          </tr> 
          <tr>
          	<td> 	
              <label><?php _e('Font URL', 'fp_ml') ?></label>
              <input type="text" name="webfont_url" value="" size="80" />
            </td>
          </tr>      
        </tbody>
      </table>
      
      <p class="submit">  
      <input type="submit" name="fp_add_webfont" value="<?php _e('Add Web Font', 'fp_ml' ) ?>" class="button-primary" />  
      </p>  
      <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcweb') ?>" /> 
      </form>
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
          foreach($webfonts_list as $wf_name=>$wf_path) : 
		  	$wf_name_id = fp_stringToUrl($wf_name);
			
			if(is_array($fdata['fp_webfonts_enabled']) && in_array($wf_name, $fdata['fp_webfonts_enabled'])) {
				$cf_sel = 'checked="checked"';	
			}
			else {$cf_sel = '';}
		  ?>
          
            <tr>
              <td>
                <label id="fn_<?php echo $wf_name_id; ?>"><?php echo ucwords($wf_name); ?></label>
                <input type="checkbox" name="fp_webfonts_enabled[]" value="<?php echo $wf_name; ?>" <?php echo $cf_sel; ?> />
                <span id="preview_<?php echo $wf_name_id; ?>" class="fp_font_preview">Preview <strong>Preview</strong> <em>Preview</em> <strong><em>Preview</em></strong></span>
              </td>
              <td class="fp_del_font fp_del_webfont" id="del_<?php echo $wf_name_id; ?>">
              	<span title="delete font"></span>
              </td>
            </tr>    
               
          <?php endforeach; ?>
        </tbody>
      </table>

      <p class="submit">  
      <input type="submit" name="fp_save_webfonts" value="<?php _e('Update') ?>" class="button-primary" />  
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
	jQuery('.fp_del_webfont').click(function() {
		var font_id = jQuery(this).attr('id').substr(4);
		var font_name = jQuery('#fn_' + font_id).html();
		
		if(confirm('<?php _e('Delete permanently the font', 'fp_ml') ?> ' + font_name +'?')) {
			var data = {
				action: 'fp_delete_webfont',
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



