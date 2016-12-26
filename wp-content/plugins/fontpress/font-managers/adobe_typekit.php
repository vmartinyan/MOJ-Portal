<?php 
include_once(FP_DIR.'/functions.php');
$kits_list = unserialize(get_option('fp_adobe_typekits', 'a:0:{}'));
$enabled_kits = get_option('fp'.FP_BID.'_ad_typekits_enabled', array());
?>

<div class="wrap fp_form lcwp_form">  
	<div class="icon32" id="pageicon-fontface"><br></div>
    <?php echo '<h2 class="fp_page_title">' . __( 'Manage Adobe Typekits', 'fp_ml') . "</h2>"; ?>  
	
    <?php
	// check if server supports cURL
	if(!function_exists('curl_version')) {
		echo '<div class="error" style="margin-top: 45px;"><p>'. __('Impossible to use Adobe Typekits - server does not support cURL', 'fp_ml') . '</p><p></p></div>';
		exit();			
	}
	?>


    <?php
	include_once(FP_DIR . '/classes/simple_form_validator.php');
	
	// add 
	if(isset($_POST['fp_add_typekit'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		$validator = new simple_fv;
		$indexes[] = array('index'=>'fp_typekit_id', 'label'=>__('Typekit ID', 'fp_ml' ), 'required'=>true, 'max_len'=>10);

		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		
		foreach($fdata as $key=>$val) {
			if(!is_array($val)) {
				$fdata[$key] = stripslashes($val);	
			}
		}
		
		if($fdata['fp_typekit_id']) {
			// get data
			$data = fp_get_kit_data($fdata['fp_typekit_id']); // contained fonts data array 

			if(!$data) {$validator->custom_error['cURL'] = __('cURL call failed', 'fp_ml');}
			elseif($data == 'not found') {$validator->custom_error['Not found'] = __('This kit ID does not exist', 'fp_ml');}
			
			// check for duplicates
			if(is_array($kits_list) && isset($kits_list[ $fdata['fp_typekit_id'] ])) {
				$validator->custom_error['Kit'] = __('This kit has been already added to list', 'fp_ml');		
			}
		}
		$error = $validator->getErrors();
		
		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			
			// add and save
			if(!is_array($kits_list)) {$kits_list = array();}
			$kits_list[ $fdata['fp_typekit_id'] ] = $data;
			update_option('fp_adobe_typekits', serialize($kits_list));
			
			echo '<div class="updated"><p><strong>'. __('Typekit added', 'fp_ml') .'</strong></p></div>';
		}
	}
	
	
	// save enabled
	if(isset($_POST['fp_save_active_kits'])) { 
		$validator = new simple_fv;
		$indexes[] = array('index'=>'fp_kits_enabled', 'label'=>'Enabled Kits');

		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		
		foreach($fdata as $key=>$val) {
			if(!is_array($val)) {
				$fdata[$key] = stripslashes($val);	
			}
		}
		$error = $validator->getErrors();
		
		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			
			// add and save
			$enabled_kits = (!is_array($fdata['fp_kits_enabled'])) ? array() : $fdata['fp_kits_enabled'];
			update_option('fp'.FP_BID.'_ad_typekits_enabled', $enabled_kits);
			
			fp_create_frontend_files(); // update dynamic files 
			
			echo '<div class="updated"><p><strong>'. __('Typekits saved', 'fp_ml') .'</strong></p></div>';
		}
	}
	?>

    <br/>
    
    <div class="lcwp_opt_block">
      <form name="lcwp_admin" method="post" class="form-wrap lcwp_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
      <table class="widefat lcwp_opt_table" cellspacing="0" cellpadding="5">
      	<thead>
          <tr>
            <th scope="row"><?php _e('Add Typekit', 'fp_ml' ) ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          	<td> 	
              <label><?php _e('Typekit ID', 'fp_ml') ?></label>
              <input type="text" name="fp_typekit_id" size="20" maxlength="10" autocomplete="off" value="<?php if(isset($error) && $error) {echo $fdata['fp_typekit_id'];} ?>" />
              <span>(Create a <a href="https://typekit.com/fonts" target="_blank">Typekit</a>)</span>
            </td>
          </tr>      
        </tbody>
      </table>
      
      <p class="submit">  
      <input type="submit" name="fp_add_typekit" value="<?php _e('Add Typekit', 'fp_ml' ) ?>" class="button-primary" />  
      </p>  
      <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcweb') ?>" /> 
      </form>
    </div>
    
    
    <div class="lcwp_opt_block">
      <form name="lcwp_admin" method="post" class="form-wrap lcwp_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
	<?php foreach($kits_list as $kit_id => $data) :  ?>
		<table class="widefat lcwp_opt_table fp_font_list_table" cellspacing="0" cellpadding="5">
          <thead>
          	<tr>
            	<th colspan="2" class="fp_typekit_th">
                	Kit ID: <em><?php echo $kit_id ?></em>
                    
                    <span class="fp_typekit_del fp_del_rule" rel="<?php echo $kit_id ?>" title="<?php _e('delete kit', 'fp_ml') ?>"></span>
                    <span class="fp_typekit_sync" rel="<?php echo $kit_id ?>" title="<?php _e('sync again', 'fp_ml') ?>"></span>
                    
                    <div class="fp_typekit_enable_wrap"> 
                    	<?php $tk_sel = (in_array($kit_id, $enabled_kits)) ? 'checked="checked"' : ''; ?>
                    	Enabled? &nbsp; <input type="checkbox" name="fp_kits_enabled[]" value="<?php echo $kit_id ?>" <?php echo $tk_sel; ?> autocomplete="off" />
                    </div>
                </th>
            </tr>
          </thead>
          <tbody>
          	<?php foreach($data as $slug => $font) : ?>
			<tr>
            	<td style="padding-left: 15px;"><?php echo $font['name'] ?></td>
                <td><span style="font-family: <?php echo str_replace('"', "'", $font['css']); ?>" class="fp_font_preview">Preview <strong>Preview</strong> <em>Preview</em> <strong><em>Preview</em></strong></span></td>
            </tr>
			<?php endforeach; ?>
          </tbody>
        </table>
	
	<?php endforeach; ?>
      
      <?php if(count($kits_list) > 0) : ?>
        <p class="submit">  
        <input type="submit" name="fp_save_active_kits" value="<?php _e('Update') ?>" class="button-primary" />  
        </p>  
      <?php endif; ?>  
      
      </form>
    </div>
</div>  


<?php
$GLOBALS['fp_ad_typekits'] = $kits_list;

// enqueue scripts to preview fonts
function fp_ad_typekit_init() {
	$kits_list = $GLOBALS['fp_ad_typekits'];
	
	foreach($kits_list as $kit_id => $data) {
		echo '<script src="//use.typekit.net/'.$kit_id.'.js"></script>';
	}
	echo '<script>try{Typekit.load();}catch(e){}</script>';
}
add_action('admin_footer', 'fp_ad_typekit_init', 1);
?>


<?php // SCRIPTS ?>
<script src="<?php echo FP_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf8">
jQuery(document).ready(function($) {
	var fp_is_acting = false;
	
	// delete kit
	jQuery('body').delegate('.fp_typekit_del', 'click', function() {
		if(!fp_is_acting && confirm("<?php _e('Delete this Typekit?', 'fp_ml') ?>")) {
			fp_is_acting = true;
			
			var $wrap = jQuery(this).parents('table'); 
			var kit_id = jQuery(this).attr('rel');
			
			var data = {
				action: 'fp_delete_typekit',
				kit_id: kit_id
			};
			jQuery.post(ajaxurl, data, function(response) {
				if( jQuery.trim(response) == 'success') {
					$wrap.slideUp(function() {
						jQuery(this).remove();
					});
				}
				else {
					console.log(response);
					alert('<?php _e('Error during kit deletion', 'fp_ml'); ?>');
				}
				
				fp_is_acting = false;
			});	
		}
	});
	
	
	// re-sync kit
	jQuery('body').delegate('.fp_typekit_sync', 'click', function() {
		if(!fp_is_acting) {
			fp_is_acting = true; 
			var kit_id = jQuery(this).attr('rel');
			
			var data = {
				action: 'fp_sync_typekit',
				kit_id: kit_id
			};
			jQuery.post(ajaxurl, data, function(response) {
				if( jQuery.trim(response) == 'success') {
					window.location.replace( window.location.href );
				}
				else {
					console.log(response);
					alert('<?php _e('Error during kit sync', 'fp_ml'); ?>');
				}
				
				fp_is_acting = false;
			});	
		}
	});
	


	// lc switch
	jQuery(':checkbox').lc_switch('YES', 'NO');
});
</script>

