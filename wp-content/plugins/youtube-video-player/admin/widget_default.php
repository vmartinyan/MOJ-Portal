<?php
class youtube_embed_widget_default{
	private $menu_name;
	private $databese_names;
	public  $initial_values;
	
	/*############ Construct Function ##################*/
	
	function __construct($params){
		// Set YouTube Embed plugin url
		if(isset($params['plugin_url']))
			$this->plugin_url=$params['plugin_url'];
		else
			$this->plugin_url=trailingslashit(dirname(plugins_url('',__FILE__)));
		// Set plugin path
		if(isset($params['plugin_path']))
			$this->plugin_path=$params['plugin_path'];
		else
			$this->plugin_path=trailingslashit(dirname(plugin_dir_path('',__FILE__)));
		/*Ajax parameters list*/
		add_action( 'wp_ajax_youtube_embed_widget_save_in_db', array($this,'save_parametrs') );
	
	}
	/*############ Save parameters function ##################*/
	public function save_parametrs(){
		 $initial_values= array( 
			"youtube_embed_widget_width"  				=> "640",
			"youtube_embed_widget_height"  				=> "390",
			"youtube_embed_widget_autoplay"  			=> "0",
			"youtube_embed_widget_loop_video"  			=> "0",
			"youtube_embed_widget_enable_fullscreen"  	=> "1",
			"youtube_embed_widget_show_realted"  		=> "0",	
			"youtube_embed_widget_show_popup"  			=> "0",			
			"youtube_embed_widget_show_title"  			=> "1",
			"youtube_embed_widget_show_youtube_icon"  	=> "1",
			"youtube_embed_widget_show_annotations"  	=> "1",
			"youtube_embed_widget_show_progress_bar_color" => "red",
			"youtube_embed_widget_autohide_parameters"  	=> "1",
			"youtube_embed_widget_set_initial_volume" => "",
				"youtube_embed_widget_initial_volume" 		=> "100",
			"youtube_embed_widget_disable_keyboard"  	=>"0"
		);
	$kk=1;	
		if(isset($_POST['youtube_embed_widget_content_default_save_nonce']) && wp_verify_nonce( $_POST['youtube_embed_widget_content_default_save_nonce'],'youtube_embed_widget_content_default_save_nonce')){
			
			foreach($initial_values as $key => $value){
				if(isset($_POST[$key])){
					update_option($key,stripslashes($_POST[$key]));
				}
				else{
					$kk=0;
					printf('error saving %s <br>',$key);
				}
			}	
		}
		else{
			die('Authorization Problem ');
		}
		if($kk==0){
			exit;
		}
		die('sax_normala');
	}
	/*#################### YOUTUBE EMBED PLAYER CONTROLLERS ########################*/
	public function controller_page(){
		
			$this->display_table_list_answers();
	}

    /*############  Table list function ################*/	

	private function display_table_list_answers(){
		
        $initial_values= array( 
		"youtube_embed_widget_width"  				=> "640",
		"youtube_embed_widget_height"  				=> "385",
		"youtube_embed_widget_autoplay"  			=> "0",
		"youtube_embed_widget_loop_video"  			=> "0",
		"youtube_embed_widget_enable_fullscreen"  	=> "1",
		"youtube_embed_widget_show_realted"  		=> "1",	
		"youtube_embed_widget_show_popup"  			=> "0",			
		"youtube_embed_widget_show_title"  			=> "1",
		"youtube_embed_widget_show_youtube_icon"  	=> "1",
		"youtube_embed_widget_show_annotations"  	=> "1",
		"youtube_embed_widget_show_progress_bar_color" => "red",
		"youtube_embed_widget_autohide_parameters"  	=> "1",
		"youtube_embed_widget_set_initial_volume" => "",
			"youtube_embed_widget_initial_volume" 		=> "100",
		"youtube_embed_widget_disable_keyboard"  	=>"0"
		);
	foreach($initial_values as $key => $value){
		if(!(get_option($key,12365498798465132148947984651)==12365498798465132148947984651))
			$$key=get_option($key);
		else
			$$key=$value;
	}
	?>
		
        <style>
		.popup_settings{
			<?php echo $youtube_embed_widget_show_popup?'':'display:none;'; ?>
		}
        </style>
        <h2 style="width:640px">YouTube Embed widget default settings <a target="blank" href="<?php echo wpdevart_youtube_support_url; ?>" class="wp_support">Support</a></h2>	
        <div class="main_yutube_plus_params">	
        <table class="wp-list-table widefat fixed posts youtube_settings_table" style="width: 640px; min-width:320px !important;table-layout: fixed;">
            <thead>
                <tr>
                    <th colspan="2" width="50%">
                   		<span> YouTube Embed widget default settings </span>
                        <a href="http://wpdevart.com/wordpress-youtube-embed-plugin/" target="_blank" style="float:right; color: rgba(10, 154, 62, 1);; font-weight: bold; font-size: 18px; text-decoration: none;">Upgrade to Pro Version</a>
                    </th>                  
                             
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>     
                    	Width <span title="Set YouTube Player Width" class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" name="youtube_embed_widget_width" id="youtube_embed_widget_width" value="<?php echo $youtube_embed_widget_width; ?>"><span class="befor_input_small_desc">(px)</span>
                    </td>
                </tr> 
                <tr>
                     <td>     
                    	Height <span title="Set YouTube Player Height" class="desription_class">?</span>
                    </td>
                    <td>     
                    	<input type="text" name="youtube_embed_widget_height" id="youtube_embed_widget_height" value="<?php echo $youtube_embed_widget_height; ?>"><span class="befor_input_small_desc">(px)</span>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Autoplay <span title="Set this option if you want automatically start playing videos when users open the page that video replaced" class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_autoplay_radio"  <?php checked($youtube_embed_widget_autoplay,'1') ?> value="1">Yes</label>
                        <label><input type="radio" name="youtube_embed_widget_autoplay_radio" <?php checked($youtube_embed_widget_autoplay,'0') ?> value="0">No</label>
                        <input type="hidden" name="youtube_embed_widget_autoplay" id="youtube_embed_widget_autoplay" value="<?php echo $youtube_embed_widget_autoplay; ?>" >
                    </td>
                </tr> 
                <tr>
                     <td>     
                    	 YouTube Player Theme <span class="pro_subtitle_span">Pro feature!</span> <span title="Choose YouTube Player Theme" class="desription_class">?</span>                    
                    </td>
                    <td>     
                    	<select  onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">
                            <option  value="light">Light</option>
                            <option value="dark" selected="selected">Dark</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Loop video <span title="Set this option for repeating YouTube video" class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_loop_video_radio" <?php checked($youtube_embed_widget_loop_video,'1') ?> value="1">Yes</label>
                        <label><input type="radio" name="youtube_embed_widget_loop_video_radio" <?php checked($youtube_embed_widget_loop_video,'0') ?>  value="0">No</label>
                        <input type="hidden" name="youtube_embed_widget_loop_video" id="youtube_embed_widget_loop_video"  value="<?php echo $youtube_embed_widget_loop_video; ?>">
                    </td>
 				</tr> 
                <tr>
                    <td>     
                    	Show Fullscreen button <span title="Set this option if you want to display fullscreen button on YouTube video player" class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_enable_fullscreen_radio" <?php checked($youtube_embed_widget_enable_fullscreen,'1') ?> value="1">Show</label>
                        <label><input type="radio" name="youtube_embed_widget_enable_fullscreen_radio" <?php checked($youtube_embed_widget_enable_fullscreen,'0') ?> value="0">Hide</label>
                         <input type="hidden" name="youtube_embed_widget_enable_fullscreen" id="youtube_embed_widget_enable_fullscreen" value="<?php echo $youtube_embed_widget_enable_fullscreen; ?>">
                    </td>
 				</tr> 
                <tr>                     
                	<td>     
                    	Show related videos <span class="pro_subtitle_span">Pro feature!</span> <span title="Set this option if you want to show Related Videos after the Youtube video end." class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_widget_show_realted_radios" name="youtube_embed_show_popup_radio" checked="checked" value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Show</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_widget_show_realted_radios" name="youtube_embed_show_popup_radio"  value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Hide</label>
                         <input type="hidden" name="youtube_embed_widget_show_realted" id="youtube_embed_widget_show_realted" value="<?php echo $youtube_embed_widget_show_realted; ?>">
                    </td>
                    
                </tr>
                <tr>                     
                	<td>     
                    	Show video in popup <span class="pro_subtitle_span">Pro feature!</span> <span title="Set this option if you want to display YouTube videos in popup" class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_widget_show_in_popup_radios" name="youtube_embed_widget_show_popup_radio" <?php checked($youtube_embed_widget_show_popup,'1') ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_widget_show_in_popup_radios" name="youtube_embed_widget_show_popup_radio" <?php checked($youtube_embed_widget_show_popup,'0') ?> value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">No</label>
                         <input type="hidden" name="youtube_embed_widget_show_popup" id="youtube_embed_widget_show_popup" value="<?php echo $youtube_embed_widget_show_popup; ?>">
                    </td>
                    
                </tr>            
                <tr>
                    <td>     
                    	Show information <span title="Set this option if you need to display YouTube videos information" class="desription_class">?</span>
                    </td> 				                 
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_show_title_radio" <?php checked($youtube_embed_widget_show_title,'1'); ?> value="1">Yes</label>
                        <label><input type="radio" name="youtube_embed_widget_show_title_radio" <?php checked($youtube_embed_widget_show_title,'0'); ?> value="0">No</label>
                        <input type="hidden" name="youtube_embed_widget_show_title" id="youtube_embed_widget_show_title" value="<?php echo $youtube_embed_widget_show_popup; ?>">
                    </td>
 				</tr> 
                <tr>                   
                    <td>     
                    	Show YouTube icon <span title="Set this option if you want to display YouTube icon" class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_show_youtube_icon_radio" <?php checked($youtube_embed_widget_show_youtube_icon,'1'); ?> value="1">Yes</label>
                        <label><input type="radio" name="youtube_embed_widget_show_youtube_icon_radio" <?php checked($youtube_embed_widget_show_youtube_icon,'0'); ?> value="0">No</label>
                        <input type="hidden" name="youtube_embed_widget_show_youtube_icon" id="youtube_embed_widget_show_youtube_icon" value="<?php echo $youtube_embed_widget_show_youtube_icon; ?>">
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Show annotations <span title="Set this option if you want to display annotations in YouTube videos" class="desription_class">?</span>
                    </td> 				                  
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_show_annotations_radio" <?php checked($youtube_embed_widget_show_annotations,'1'); ?> value="1">Yes</label>
                        <label><input type="radio" name="youtube_embed_widget_show_annotations_radio" <?php checked($youtube_embed_widget_show_annotations,'0'); ?> value="0">No</label>
                        <input type="hidden" name="youtube_embed_widget_show_annotations" id="youtube_embed_widget_show_annotations" value="<?php echo $youtube_embed_widget_show_annotations; ?>" >
                    </td>
                    </tr>
                 <tr>
                    <td>     
                    	Progress bar color <span title="Select YouTube player Progress bar color" class="desription_class">?</span>
                    </td>
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_show_progress_bar_color_radio" <?php checked($youtube_embed_widget_show_progress_bar_color,'red'); ?> value="red">Red</label>
                        <label><input type="radio" name="youtube_embed_widget_show_progress_bar_color_radio" <?php checked($youtube_embed_widget_show_progress_bar_color,'white'); ?> value="white">White</label>
                        <input type="hidden" name="youtube_embed_widget_show_progress_bar_color" id="youtube_embed_widget_show_progress_bar_color" value="<?php echo $youtube_embed_widget_show_progress_bar_color; ?>">
                    </td>
                </tr>
                 <tr>
                    <td>     
                    	Auto-hide parameters <span title="Set this option if you want automatically hide YouTube player parameters" class="desription_class">?</span>
                    </td>
 				                   
                    <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_autohide_parameters_radio" <?php checked($youtube_embed_widget_autohide_parameters,'1'); ?> value="1">Yes</label>
                        <label><input type="radio" name="youtube_embed_widget_autohide_parameters_radio" <?php checked($youtube_embed_widget_autohide_parameters,'0'); ?> value="0">No</label>
                        <input type="hidden" name="youtube_embed_widget_autohide_parameters" id="youtube_embed_widget_autohide_parameters" value="<?php echo $youtube_embed_widget_autohide_parameters; ?>" >
                    </td>
                    </tr> 
                <tr>
                    <td>     
                    	Player Initial Volume <span title="Set Initial Volume level for YouTube videos" class="desription_class">?</span>
                    </td>
                    <td>     
                    	<label><input type="checkbox" name="youtube_embed_widget_set_initial_volume_checkbox" id="youtube_embed_widget_set_initial_volume_checkbox" <?php checked($youtube_embed_widget_set_initial_volume,'1'); ?> value="1">Set initial value</label>
                        <div class="div_included_slider youtube_embed_widget_set_initial_volume" <?php if($youtube_embed_widget_set_initial_volume!=1 || $youtube_embed_widget_set_initial_volume!="1") echo "style='display:none;'" ?>>
                            <input type="text" name="youtube_embed_widget_initial_volume" id="youtube_embed_widget_initial_volume" class="slider_input" value="<?php echo $youtube_embed_widget_initial_volume; ?>">
                            <div class="slider_parametrs" id="youtube_embed_widget_initial_volume_div"></div>
                            <span id="youtube_embed_widget_initial_volume_span" class="slider_span"></span>
                        </div>
                        <input type="hidden" name="youtube_embed_widget_set_initial_volume" id="youtube_embed_widget_set_initial_volume" value="<?php echo $youtube_embed_widget_set_initial_volume; ?>">
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Disable player keyboard <span title="Set this option if you want to Enable/Disable keyboard for YouTube videos" class="desription_class">?</span>
                    </td>
                   <td class="radio_input">     
                    	<label><input type="radio" name="youtube_embed_widget_disable_keyboard_radio" <?php checked($youtube_embed_widget_disable_keyboard,'1'); ?> value="1">Disable</label>
                        <label><input type="radio" name="youtube_embed_widget_disable_keyboard_radio" <?php checked($youtube_embed_widget_disable_keyboard,'0'); ?> value="0">Enable</label>
                        <input type="hidden" name="youtube_embed_widget_disable_keyboard" id="youtube_embed_widget_disable_keyboard" value="<?php echo $youtube_embed_widget_disable_keyboard; ?>">
                    </td>
                </tr>                
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" width="100%"><button type="button" id="save_button_design" class="save_button button button-primary"><span class="save_button_span">Save Settings</span> <span class="saving_in_progress"> </span><span class="sucsses_save"> </span><span class="error_in_saving"> </span></button></th>
                </tr>
            </tfoot>
		</table>
         <?php wp_nonce_field('youtube_embed_widget_content_default_save_nonce','youtube_embed_widget_content_default_save_nonce'); ?>
	</div><br /><br /><span class="error_massage"></span>
   
		<script>
		
		
		
		jQuery(document).ready(function(e) {
			
			/* ######### INITIAL VOLUME CODE #############*/
			jQuery('#youtube_embed_widget_set_initial_volume_checkbox').click(function(){
				if(jQuery(this).prop('checked')==true){
					jQuery('.youtube_embed_widget_set_initial_volume').show('normal');
				}
				else{
					jQuery('.youtube_embed_widget_set_initial_volume').hide('normal');
				}
			});
			jQuery('.youtube_embed_widget_show_in_popup_radios').click(function(){
				if(jQuery(this).val()=='1'){
					jQuery('.popup_settings').show('normal');
				}
				else{
					jQuery('.popup_settings').hide('normal');
				}
			});
			
			jQuery( "#youtube_embed_widget_initial_volume_div" ).slider({
				range: "min",
				value: "<?php echo ($youtube_embed_widget_initial_volume)?$youtube_embed_widget_initial_volume:'100';  ?>",
				min: 0,
				max: 100,
				slide: function( event, ui ) {
					jQuery( "#youtube_embed_widget_initial_volume" ).val( ui.value);
					jQuery( "#youtube_embed_widget_initial_volume_span" ).html( ui.value+'%' );
				}
			});
			jQuery( "#youtube_embed_widget_initial_volume" ).val(jQuery( "#youtube_embed_widget_initial_volume_div" ).slider( "value" ) );
			jQuery( "#youtube_embed_widget_initial_volume_span" ).html(jQuery( "#youtube_embed_widget_initial_volume_div" ).slider( "value" ) +'%');
	
			 jQuery('#save_button_design').click(function(){
					
					jQuery('#save_button_design').addClass('padding_loading');
					jQuery("#save_button_design").prop('disabled', true);
					jQuery('.saving_in_progress').css('display','inline-block');
					generete_radio_input('radio_input');
					if(jQuery('#youtube_embed_widget_set_initial_volume_checkbox').prop('checked')){
						jQuery('#youtube_embed_widget_set_initial_volume').val('1')
					}
					else{
						jQuery('#youtube_embed_widget_set_initial_volume').val('0')
					}
					//generete_radio_input_hidden(jQuery('#page_content_position'));
					jQuery.ajax({
						type:'POST',
						url: "<?php echo admin_url( 'admin-ajax.php?action=youtube_embed_widget_save_in_db' ); ?>",
						data: {youtube_embed_widget_content_default_save_nonce:jQuery('#youtube_embed_widget_content_default_save_nonce').val()<?php foreach($initial_values as $key => $value){echo ','.$key.':jQuery("#'.$key.'").val()';} ?>},
					}).done(function(date) {
						if(date=='sax_normala'){
							console.log
						jQuery('.saving_in_progress').css('display','none');
						jQuery('.sucsses_save').css('display','inline-block');
						setTimeout(function(){jQuery('.sucsses_save').css('display','none');jQuery('#save_button_design').removeClass('padding_loading');jQuery("#save_button_design").prop('disabled', false);},2500);
						}else{
							jQuery('.saving_in_progress').css('display','none');
							jQuery('.error_in_saving').css('display','inline-block');
							jQuery('.error_massage').css('display','inline-block');
							jQuery('.error_massage').html(date);
							setTimeout(function(){jQuery('#save_button_design').removeClass('padding_loading');jQuery("#save_button_design").prop('disabled', false);},5000);
						}

					});
				});
				function generete_radio_input(radio_class){
					jQuery('.'+radio_class).each(function(index, element) {
                       jQuery(this).find('input[type=hidden]').val(jQuery(this).find('input[type=radio]:checked').val())
                    });
				}
				function generete_checkbox(checkbox_class){
					jQuery('.'+checkbox_class).each(function(index, element) {
                       jQuery(this).find('input[type=hidden]').val(jQuery(this).find('input[type=radio]:checked').val())
                    });
				}

		});
			
        </script>

		<?php
	}	
	
}


 ?>