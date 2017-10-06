<?php 

    /*############  Youtube Embed Admin Menu Class ################*/
require_once($this->plugin_path.'admin/content_default.php');
require_once($this->plugin_path.'admin/widget_default.php');
require_once($this->plugin_path.'admin/featured_plugins.php');
class youtube_admin_menu{
	
	private $menu_name;	
	
	private $plugin_url;
	
	private $plugin_path;
	
	public  $wdiget_default_params;
	
	public  $content_default_params;
	
	public  $featured_plugins;

    /*############ Construct Function ##################*/
	
	function __construct($param){
		$this->menu_name='YouTube Embed';	
		
		$this->content_default_params  =new youtube_embed_content_default( array( 'plugin_url'=> $this->plugin_url, 'plugin_path' => $this->plugin_path));
		$this->wdiget_default_params =new youtube_embed_widget_default( array( 'plugin_url' => $this->plugin_url, 'plugin_path' => $this->plugin_path));
		$this->featured_plugins		=new youtube_embed_featured_plugins( array( 'plugin_url' => $this->plugin_url, 'plugin_path' => $this->plugin_path));
		// Set YpuTube plugin url
		if(isset($param['plugin_url']))
			$this->plugin_url=$param['plugin_url'];
		else
			$this->plugin_url=trailingslashit(dirname(plugins_url('',__FILE__)));
		if(isset($param['plugin_path']))
			$this->plugin_path=$param['plugin_path'];
		else
			$this->plugin_path=trailingslashit(dirname(plugin_dir_path(__FILE__)));
		// Add button
		add_filter('media_buttons_context', array($this,"editor_buttonn"));
		
		// Add button window
		add_action('wp_ajax_youtube_embed_window_manager',array($this,'window_for_inserting_contentt'));
		

	}
	
	/*############ Function for adding new insert button ##################*/
	
	function editor_buttonn($context)
	{
		 $img = plugins_url( '/images/icon-youtube_post.png' , __FILE__ );

		  $title = 'Add Youtube';
		
		  $context .= '<a class="button thickbox" title=" Insert YouTube videos in posts/pages"    href="'.admin_url("admin-ajax.php").'?action=youtube_embed_window_manager&width=640&height=750"><span class="wp-media-buttons-icon" style="background: url('.$img.'); background-repeat: no-repeat; background-position: left bottom;"></span>Add Youtube Video</a>';  
		  return $context;
	}
	
    /*############ Content Inserting Function ##################*/

	public function window_for_inserting_contentt(){
		
	  
        $initial_values= array( 
			"youtube_embed_width"  				=> "640",
			"youtube_embed_height"  				=> "385",
			"youtube_embed_autoplay"  			=> "0",			
			"youtube_embed_loop_video"  			=> "0",
			"youtube_embed_enable_fullscreen"  	=> "1",
			"youtube_embed_show_realted"  			=> "0",	
			"youtube_embed_show_popup"  			=> "0",			
			"youtube_embed_show_title"  			=> "1",
			"youtube_embed_show_youtube_icon"  	=> "1",
			"youtube_embed_show_annotations"  	=> "1",
			"youtube_embed_show_progress_bar_color" => "red",
			"youtube_embed_autohide_parameters"  	=> "1",
			"youtube_embed_set_initial_volume" => "",
				"youtube_embed_initial_volume" 		=> "100",
			"youtube_embed_disable_keyboard"  	=>"0"
		);
	foreach($initial_values as $key => $value){
		if(!(get_option($key,12365498798465132148947984651)==12365498798465132148947984651))
			$$key=get_option($key);
		else
			$$key=$value;
	}
	?>		
       <style>
			.slider_parametrs{
				padding-left:5px;
				width:180px;
				float:left;
				margin-top:2px;
			}
			#TB_ajaxContent{
				 width:initial !important;
				 height:initial !important;
			 }
			 #TB_window{
				overflow:auto !important;
			 }
			 #youtube_embed_initial_volume_span{
				 padding-left:12px;
			}
        </style>
<a href="http://wpdevart.com/wordpress-youtube-embed-plugin/" target="_blank" style="color: rgba(10, 154, 62, 1);; font-weight: bold; font-size: 18px; text-decoration: none;">Upgrade to Pro Version</a>
        <table class="wp-list-table widefat fixed posts youtube_settings_table" style="width: 100%; min-width:320px !important;table-layout: fixed;">
            
            <tbody>
            	<tr>
                    <td width="40%">     
                    	Video Id:
                    </td>
                    <td>     
                    	<input type="text" style="width:95%;" name="youtube_embed_video" id="youtube_embed_video" placeholder="9bZkp7q19f0">
                    </td>
                </tr>
                <tr>
                    <td >     
                 	   Playlist Id:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td>     
                    	<input type="text" style="width:95%;" name="youtube_embed_playlist" id="youtube_embed_playlist" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;" placeholder="RDQvRhanJ4wlw#t=124">
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Width:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td>     
                    	<input type="text" name="youtube_embed_width" id="youtube_embed_width" value="<?php echo $youtube_embed_width; ?>" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><span class="befor_input_small_desc">(px)</span>
                    </td>
                </tr> 
                <tr>
                     <td>     
                    	Height:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td>     
                    	<input type="text" name="youtube_embed_height" id="youtube_embed_height" value="<?php echo $youtube_embed_height; ?>" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><span class="befor_input_small_desc">(px)</span>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Autoplay:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_autoplay_radio"  <?php checked($youtube_embed_autoplay,'1') ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_autoplay_radio" <?php checked($youtube_embed_autoplay,'0') ?> value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">No</label>
                        <input type="hidden" name="youtube_embed_autoplay" id="youtube_embed_autoplay" value="<?php echo $youtube_embed_autoplay; ?>" >
                    </td>
                </tr> 
                <tr>
                     <td>     
                     	Player Theme:<span class="pro_subtitle_span">Pro feature!</span>                   
                    </td>
                    <td>     
                    	<select id="youtube_embed_theme" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">
                            <option  value="light">Light</option>
                            <option value="dark" selected="selected">Dark</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Loop video:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_loop_video_radio" <?php checked($youtube_embed_loop_video,'1') ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_loop_video_radio" <?php checked($youtube_embed_loop_video,'0') ?>  value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">No</label>
                        <input type="hidden" name="youtube_embed_loop_video" id="youtube_embed_loop_video"  value="<?php echo $youtube_embed_loop_video; ?>">
                    </td>
 				</tr> 
                <tr>
                    <td>     
                    	Show Fullscreen button:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_enable_fullscreen_radio" <?php checked($youtube_embed_enable_fullscreen,'1') ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Show</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_enable_fullscreen_radio" <?php checked($youtube_embed_enable_fullscreen,'0') ?> value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Hide</label>
                         <input type="hidden" name="youtube_embed_enable_fullscreen" id="youtube_embed_enable_fullscreen" value="<?php echo $youtube_embed_enable_fullscreen; ?>">
                    </td>
 				</tr>
                <tr>                     
                	<td>     
                    	Show related videos:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_show_realted_radios" name="youtube_embed_show_realted_radios" checked="checked" value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Show</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_show_realted_radios" name="youtube_embed_show_realted_radios"  value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Hide</label>
                         <input type="hidden" name="youtube_embed_show_realted" id="youtube_embed_show_realted" value="<?php echo $youtube_embed_show_realted; ?>">
                    </td>
                    
                </tr>  
                <tr>                     
                	<td>     
                    	Show video in popup:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_show_in_popup_radios" name="youtube_embed_show_popup_radio" value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" class="youtube_embed_show_in_popup_radios" name="youtube_embed_show_popup_radio" checked="checked" value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">No</label>
                       
                    </td>
                    
                </tr> 
                 <tr class='popup_settings'>
                    <td>     
                    	Thumbnail width:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td>     
                    	<input type="text" name="youtube_embed_thumb_popup_width" id="youtube_embed_thumb_popup_width" value="600" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><span class="befor_input_small_desc">(px)</span>
                    </td>
                </tr> 
               
                <tr>                   
                    <td>     
                        Show YouTube icon:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_show_youtube_icon_radio" <?php checked($youtube_embed_show_youtube_icon,'1'); ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_show_youtube_icon_radio" <?php checked($youtube_embed_show_youtube_icon,'0'); ?> value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">No</label>
                        <input type="hidden" name="youtube_embed_show_youtube_icon" id="youtube_embed_show_youtube_icon" value="<?php echo $youtube_embed_show_youtube_icon; ?>">
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Show annotations:<span class="pro_subtitle_span">Pro feature!</span>
                    </td> 				                  
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_show_annotations_radio" <?php checked($youtube_embed_show_annotations,'1'); ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_show_annotations_radio" <?php checked($youtube_embed_show_annotations,'0'); ?> value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">No</label>
                        <input type="hidden" name="youtube_embed_show_annotations" id="youtube_embed_show_annotations" value="<?php echo $youtube_embed_show_annotations; ?>" >
                    </td>
                    </tr>
                 <tr>
                    <td>     
                    	Progress bar color:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_show_progress_bar_color_radio" <?php checked($youtube_embed_show_progress_bar_color,'red'); ?> value="red" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Red</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_show_progress_bar_color_radio" <?php checked($youtube_embed_show_progress_bar_color,'white'); ?> value="white" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">White</label>
                        <input type="hidden" name="youtube_embed_show_progress_bar_color" id="youtube_embed_show_progress_bar_color" value="<?php echo $youtube_embed_show_progress_bar_color; ?>">
                    </td>
                </tr>
                 <tr>
                    <td>     
                    	Auto hide Parameters:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
 				                   
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_autohide_parameters_radio" <?php checked($youtube_embed_autohide_parameters,'1'); ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_autohide_parameters_radio" <?php checked($youtube_embed_autohide_parameters,'0'); ?> value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">No</label>
                        <input type="hidden" name="youtube_embed_autohide_parameters" id="youtube_embed_autohide_parameters" value="<?php echo $youtube_embed_autohide_parameters; ?>" >
                    </td>
                    </tr> 
                <tr>
                    <td>     
                    	Initial Volume:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                    <td>     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="checkbox" name="youtube_embed_set_initial_volume_checkbox" id="youtube_embed_set_initial_volume_checkbox" <?php checked($youtube_embed_set_initial_volume,'1'); ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Set initial value</label>
                        <div class="div_included_slider youtube_embed_set_initial_volume" <?php if($youtube_embed_set_initial_volume!=1 || $youtube_embed_set_initial_volume!="1") echo "style='display:none;'" ?>>
                            <input type="hidden" name="youtube_embed_initial_volume" id="youtube_embed_initial_volume" class="slider_input" value="<?php echo $youtube_embed_initial_volume; ?>">
                            <div class="slider_parametrs" id="youtube_embed_initial_volume_div"></div>
                            <span id="youtube_embed_initial_volume_span" class="slider_span"></span>
                        </div>
                        <input type="hidden" name="youtube_embed_set_initial_volume" id="youtube_embed_set_initial_volume" value="<?php echo $youtube_embed_set_initial_volume; ?>">
                    </td>
                </tr>
                <tr>
                    <td>     
                   		Disable player keyboard: <span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                   <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_disable_keyboard_radio" <?php checked($youtube_embed_disable_keyboard,'1'); ?> value="1" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Enable</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input type="radio" name="youtube_embed_disable_keyboard_radio" <?php checked($youtube_embed_disable_keyboard,'0'); ?> value="0" onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;">Disable</label>
                        <input type="hidden" name="youtube_embed_disable_keyboard" id="youtube_embed_disable_keyboard" value="<?php echo $youtube_embed_disable_keyboard; ?>">
                    </td>
                </tr>                
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" width="100%"><button type="button" onClick="insert_youtube_embed()" id="save_button_design" class="save_button button button-primary"><span class="save_button_span">Insert Video</span></button></th>
                	<th  width="100%"><button type="button" class="save_button button button-primary" style="float:right" onClick="tb_remove()">Close</button></th>
                </tr>
            </tfoot>
		</table>
	<br /><br /><span class="error_massage"></span>
     <style>
		.popup_settings{
			<?php echo $youtube_embed_show_popup?'':'display:none;'; ?>
		}
   </style>
    <script type="text/javascript">
			

	 		jQuery('#youtube_embed_set_initial_volume_checkbox').click(function(){
				if(jQuery(this).prop('checked')==true){
					jQuery('.youtube_embed_set_initial_volume').show('normal');
				}
				else{
					jQuery('.youtube_embed_set_initial_volume').hide('normal');
				}
			});
			jQuery('.youtube_embed_show_in_popup_radios').click(function(){
				if(jQuery(this).val()=='1'){
					jQuery('.popup_settings').show('normal');
				}
				else{
					jQuery('.popup_settings').hide('normal');
				}
			});
			jQuery( "#youtube_embed_initial_volume_div" ).slider({
				range: "min",
				value: "<?php echo ($youtube_embed_initial_volume)?$youtube_embed_initial_volume:'100';  ?>",
				min: 0,
				max: 100,
				slide: function( event, ui ) {
					return false;
				}
			});
			
			jQuery( "#youtube_embed_initial_volume_span" ).html( '<?php echo ($youtube_embed_initial_volume)?$youtube_embed_initial_volume:'100';  ?>%' );
        function insert_youtube_embed() {
			if(jQuery('#youtube_embed_video').val()){
				var generete_atributes='';
				
                tagtext = '[wpdevart_youtube]'+jQuery('#youtube_embed_video').val()+'[/wpdevart_youtube]';
                window.send_to_editor(tagtext);
              	tb_remove()
            }
			else{
				alert('enter url please')
			}
        }
		jQuery('.slider_parametrs,.ui-slider-handle').mousedown(function(){
			alert('If you want to use this feature upgrade to Pro Version');
			return false;
		})
    </script>
    <?php
	die();
	}
	
    /*############ Create Menu Function ##################*/	
	
	public function create_menu(){
		
		$manage_page_main = add_menu_page( $this->menu_name, $this->menu_name, 'manage_options', str_replace( ' ', '-', $this->menu_name), array($this->content_default_params, 'controller_page'),$this->plugin_url.'admin/images/icon-youtube.png');
							add_submenu_page( str_replace( ' ', '-', $this->menu_name), 'Post/Page Defaults', 'Post/Page Defaults', 'manage_options', str_replace( ' ', '-', $this->menu_name), array($this->content_default_params, 'controller_page'));
		$page_widget	  = add_submenu_page( str_replace( ' ', '-', $this->menu_name), 'Widget Defaults', 'Widget Defaults', 'manage_options', 'youtube-plus-widget-default', array($this->wdiget_default_params, 'controller_page'));
		$page_widget	  = add_submenu_page( str_replace( ' ', '-', $this->menu_name), 'Featured Plugins', 'Featured Plugins', 'manage_options', 'youtube-plus-featured-plugins', array($this->featured_plugins, 'controller_page'));
		add_action('admin_print_styles-' .$manage_page_main, array($this,'menu_requeried_scripts'));
		add_action('admin_print_styles-' .$page_widget, array($this,'menu_requeried_scripts'));	
	}
	
	/*#################### Menu required scripts function ########################*/	
	
	public function menu_requeried_scripts(){
		wp_enqueue_script('jquery-ui-style');
		wp_enqueue_script('jquery');	
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script("jquery-ui-widget");
		wp_enqueue_script("jquery-ui-mouse");
		wp_enqueue_script("jquery-ui-slider");
		wp_enqueue_script("jquery-ui-sortable");
		wp_enqueue_script('wp-color-picker');	
		wp_enqueue_style("jquery-ui-style");
		wp_enqueue_style("admin_style");		
		wp_enqueue_style( 'wp-color-picker' );
			
	}
	
}