<?php require_once(FP_DIR.'/functions.php'); ?>

<div class="wrap fp_form">  
	<div class="icon32" id="pageicon-fontface"><br></div>
    <?php echo '<h2 class="fp_page_title">' . __( 'Elements Rules', 'fp_ml') . "</h2>"; ?>  

    <?php
	// SAVE RULES
	if(isset($_POST['fp_save_rules'])) { 
		if (!isset($_POST['lcwp_nonce']) || !wp_verify_nonce($_POST['lcwp_nonce'], 'lcweb')) {die('<p>Cheating?</p>');};
		
		// for no rules
		if(!isset($_POST['element'])) {
			$error = false;
			$fdata['fp_rules'] = false;
			
			// custom css
			$fdata['fp_custom_css'] = $_POST['fp_custom_css'];
		}
		
		// standard validation
		else {
			include(FP_DIR . '/classes/simple_form_validator.php');
		
			$validator = new simple_fv;
			$indexes[] = array('index'=>'element', 'label'=>__( 'Element', 'fp_ml' ), 'required'=>true);
			$indexes[] = array('index'=>'element_subj', 'label'=>__( 'Element Subject', 'fp_ml' ), 'required'=>true);
			$indexes[] = array('index'=>'font_type', 'label'=>__( 'Font Type', 'fp_ml' ), 'required'=>true);
			$indexes[] = array('index'=>'font_name', 'label'=>__( 'Font Name', 'fp_ml' ), 'required'=>true);
			$indexes[] = array('index'=>'font_size', 'label'=>__( 'Font Size', 'fp_ml' ), 'type'=>'float');
			$indexes[] = array('index'=>'font_size_type', 'label'=>__( 'Font Size Type', 'fp_ml' ), 'required'=>true);
			$indexes[] = array('index'=>'line_height', 'label'=>__( 'Line Height', 'fp_ml' ), 'type'=>'float');
			$indexes[] = array('index'=>'line_height_type', 'label'=>__( 'Line Height Type', 'fp_ml' ), 'required'=>true);
			$indexes[] = array('index'=>'text_color', 'label'=>__( 'Text Color', 'fp_ml' ));
			$indexes[] = array('index'=>'shadow_x', 'label'=>__( 'Shadow X', 'fp_ml' ));
			$indexes[] = array('index'=>'shadow_y', 'label'=>__( 'Shadow Y', 'fp_ml' ));
			$indexes[] = array('index'=>'shadow_r', 'label'=>__( 'Shadow Radius', 'fp_ml' ));
			$indexes[] = array('index'=>'shadow_color', 'label'=>__( 'Shadow Color', 'fp_ml' ));
			
			$indexes[] = array('index'=>'fp_custom_css', 'label'=>__( 'Custom CSS', 'fp_ml' ));
	
			$validator->formHandle($indexes);
			$error = $validator->getErrors();
			$fdata = $validator->form_val;
			
			// create rules array
			$fdata['fp_rules'] = array();
			$rules_num = count($fdata['element_subj']);
			for($a=0; $a < $rules_num; $a++) {
				$fdata['fp_rules'][$a]['element'] = $fdata['element'][$a];
				$fdata['fp_rules'][$a]['subj'] = $fdata['element_subj'][$a];
				$fdata['fp_rules'][$a]['font_type'] = $fdata['font_type'][$a];
				$fdata['fp_rules'][$a]['font_name'] = $fdata['font_name'][$a];
				$fdata['fp_rules'][$a]['font_size'] = $fdata['font_size'][$a];
				$fdata['fp_rules'][$a]['font_size_type'] = $fdata['font_size_type'][$a];
				$fdata['fp_rules'][$a]['line_height'] = $fdata['line_height'][$a];
				$fdata['fp_rules'][$a]['line_height_type'] = $fdata['line_height_type'][$a];
				$fdata['fp_rules'][$a]['text_color'] = $fdata['text_color'][$a];
				$fdata['fp_rules'][$a]['shadow_x'] = $fdata['shadow_x'][$a];
				$fdata['fp_rules'][$a]['shadow_y'] = $fdata['shadow_y'][$a];
				$fdata['fp_rules'][$a]['shadow_r'] = $fdata['shadow_r'][$a];
				$fdata['fp_rules'][$a]['shadow_color'] = $fdata['shadow_color'][$a];
			}
		}
			
		if($error) {echo '<div class="error"><p>'.$error.'</p></div>';}
		else {
			// rules
			if(!get_option('fp'.FP_BID.'_rules')) { add_option( 'fp'.FP_BID.'_rules', '255' , '', 'yes' );}
			update_option('fp'.FP_BID.'_rules', $fdata['fp_rules']);
			
			// save custom css
			if(!get_option('fp'.FP_BID.'_custom_css')) { add_option( 'fp'.FP_BID.'_custom_css', '255' , '', 'yes' );}
			update_option('fp'.FP_BID.'_custom_css', stripslashes($fdata['fp'.FP_BID.'_custom_css']));
			
			// create frontend css
			if(!get_option('fp_inline_code') && !fp_create_frontend_files()) {
			  echo '<div class="error"><p>'.__('An error occurred. Check your server permissions and retry to save the rules', 'fp_ml').'</p></div>';
			}
			else {echo '<div class="updated"><p><strong>'. __('Rules saved.' ) .'</strong></p></div>';}
		}
	}

	else { 
		$fdata['fp_rules'] = get_option('fp'.FP_BID.'_rules');
		$fdata['fp_custom_css'] = get_option('fp'.FP_BID.'_custom_css'); 
	}  
	?>

    <br/>
    <div class="lcwp_opt_block">
      <input type="button" name="add_rule" value="<?php _e('Add New Rule', 'fp_ml' ) ?>" id="add_rule" class="button-secondary" style="margin-bottom: 15px;" />  <span style="padding-left: 15px;" id="add_rule_load"></span>

      <form name="lcwp_admin" method="post" class="form-wrap lcwp_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">      
      <table id="rules_table" class="widefat lcwp_opt_table" cellspacing="0" cellpadding="5">
      	<thead>
          <tr>
          	<th scope="row" style="width: 15px;"></th>
            <th scope="row" style="width: 15px;"></th>
            <th scope="row">Element</th>
            <th scope="row">Element subject</th>
            <th scope="row" style="width: 137px;">Font Type</th>
            <th scope="row">Font Name</th>
            <th scope="row" style="width: 90px;">Font Size</th>
            <th scope="row" style="width: 90px;">Line Height</th>
            <th scope="row" style="width: 105px;">Color</th>
            <th scope="row" style="width: 135px;">Text Shadow</th>
          </tr>
        </thead>
        <tbody>
        	<?php echo fp_rule_row_form($fdata['fp_rules']); ?>
        </tbody>
      </table>
		  
      <h3>Custom CSS</h3>
      <table class="widefat lcwp_table">
        <tr>
          <td class="lcwp_field_td">
              <textarea name="fp_custom_css" style="width: 100%" rows="5"><?php echo stripslashes($fdata['fp_custom_css']); ?></textarea>
          </td>
        </tr>
      </table>
          
          
      <p class="submit">  
      <input type="submit" name="fp_save_rules" value="<?php _e('Save Rules and CSS', 'fp_ml' ) ?>" class="button-primary" />  
      </p>  
      
      <input type="hidden" name="lcwp_nonce" value="<?php echo wp_create_nonce('lcweb') ?>" /> 
      </form>
    </div>
</div>  

<?php // SCRIPTS ?>
<script src="<?php echo FP_URL; ?>/js/colpick/js/colpick.min.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf8">
jQuery(document).ready(function($) {

	/*** add rule basic tr ***/
	jQuery('#add_rule').click(function() {
		var data = {action: 'fp_add_rule'};
		
		jQuery('#add_rule_load').html('<span class="lcwp_loading"></span>');
		
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#add_rule_load').empty();
			jQuery('#rules_table tbody').append(response);
			
			lcwp_colpick();
		});
	});
	
	
	/*** element type ***/
	jQuery('body').delegate('.choose_element', "change", function() {
		var sel_elem = jQuery(this).val();
		
		if(sel_elem != 'custom') {jQuery(this).parent().next().html('\
			<input type="hidden" name="element_subj[]" value="'+sel_elem+'" />\
			<span>'+sel_elem+'</span>');
		}
		else {jQuery(this).parent().next().html('<input type="text" name="element_subj[]" />');}	
	});
	
	
	/*** font type ***/
	jQuery('body').delegate('.choose_font_type', "change", function() {
		var sel_font = jQuery(this).val();
		trigger = jQuery(this);
		
		if(sel_font != 'css_font' && sel_font != 'inherited') {
			jQuery(this).parent().next().html('<span class="lcwp_loading"></span>');
			var data = {
				action: 'fp_get_font_type',
				font_type: sel_font
			};
		
			jQuery.post(ajaxurl, data, function(response) {
				trigger.parent().next().html(response);
			});
		}
		else if(sel_font == 'css_font') {
			jQuery(this).parent().next().html('<input type="text" name="font_name[]" />');	
		}
		else {jQuery(this).parent().next().html('<input type="hidden" name="font_name[]" value="inherited" />');}
	});
	
	
	/*** font size and line height ***/
	jQuery('body').delegate('.choose_element', "change", function() {
		var sel_elem = jQuery(this).val();
		trigger = jQuery(this);
		
		if(sel_elem != 'custom') {
			// fs
			jQuery(this).parent().siblings('.fp_size_choose').html('\
			<input type="hidden" name="font_size[]" value="" />\
			<input type="hidden" name="font_size_type[]" value="px" />');
			
			// lh
			jQuery(this).parent().siblings('.fp_line_height').html('\
			<input type="hidden" name="line_height[]" value="" />\
			<input type="hidden" name="line_height_type[]" value="px" />');
		}
		else {
			jQuery(this).parent().siblings('.fp_size_choose').html('<span class="lcwp_loading"></span>');
			jQuery(this).parent().siblings('.fp_line_height').html('<span class="lcwp_loading"></span>');
			
			var data = {action: 'fp_get_font_size_type'};
		
			jQuery.post(ajaxurl, data, function(response) {
				// fs
				trigger.parent().siblings('.fp_size_choose').html('\
				<input type="text" name="font_size[]" value="" />' + 
				'<select name="font_size_type[]">' + response + '</select>');
				
				// lh
				trigger.parent().siblings('.fp_line_height').html('\
				<input type="text" name="line_height[]" value="" />' + 
				'<select name="line_height_type[]">' + response + '</select>');
			});
		}	
	});
	
	
	/*** remove rule ***/
	jQuery('body').delegate('.fp_del_rule', "click", function() {
		if(confirm('<?php _e('Delete the rule', 'fp_ml') ?>?')) {
			jQuery(this).parent().parent().slideUp(function() {
				jQuery(this).remove();
			});	
		}
	});
	
	
	/*** sort rows ***/
	jQuery( "#rules_table tbody" ).sortable({ handle: '.fp_move_rule' });
	jQuery( "#rules_table tbody td .fp_move_rule" ).disableSelection();
	
	
	
	// colorpicker
	function lcwp_colpick() {
		jQuery('.lcwp_colpick input').each(function() {
          	var curr_col = jQuery(this).val().replace('#', '');
			jQuery(this).colpick({
				layout:'rgbhex',
				submit:0,
				color: curr_col,
				onChange:function(hsb,hex,rgb, el, fromSetColor) {
					if(!fromSetColor){ 
						jQuery(el).val('#' + hex);
						jQuery(el).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color','#'+hex);
					}
				}
			}).keyup(function(){
				jQuery(this).colpickSetColor(this.value);
				jQuery(this).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color', this.value);
			});  
        });
	}
	lcwp_colpick();
});
</script>

