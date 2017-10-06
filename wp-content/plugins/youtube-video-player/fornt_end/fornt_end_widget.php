<?php 

    /*############ YOUTUBE EMBED WIDGET CLASS ##################*/
	
class youtube_embed_widget extends WP_Widget {
	// Constructor //	
	function __construct() {		
		$widget_ops = array( 'classname' => 'youtube_embed_widget', 'description' => 'YouTube Embed' ); // Widget Settings
		$control_ops = array( 'id_base' => 'youtube_embed_widget' ); // Widget Control Settings
		parent::__construct( 'youtube_embed_widget', 'YouTube Embed', $widget_ops, $control_ops ); // Creating widget
	}

    /*############ YouTube Widget Function ##################*/
	
	function widget($args, $instance) {
		extract( $args );
		// Before widget part //
		echo $before_widget;
		$title=$instance['title'];
		// Widget Title  //
		if ( isset($title) && $title ) { echo $before_title . $title . $after_title; }
		// Widget output part //
		if(!$instance['youtube_embed_widget_video']){
		 echo '<span style="color:red; font-size:16px">Set Vidio id</span>';	
		 return;
		}
	
		$allowfullScreen='';
		$voloutput ='';
		
		if($instance['youtube_embed_widget_set_initial_volume']=='true' || $instance['youtube_embed_widget_set_initial_volume']=='1')
		 	$voloutput = ' data-volume="' .$instance['youtube_embed_widget_initial_volume'] . '" ';
		if($instance['youtube_embed_widget_enable_fullscreen']=='1')
			$allowfullScreen=' allowFullScreen="true"';
		$parametrs=array(
			'autoplay' => $instance['youtube_embed_widget_autoplay'],
			'theme' => 'dark',
			'loop' => $instance['youtube_embed_widget_loop_video'],
			'fs' => $instance['youtube_embed_widget_enable_fullscreen'],
			'showinfo' => $instance['youtube_embed_widget_show_title'],
			'modestbranding' => $instance['youtube_embed_widget_show_youtube_icon']?'0':'1',
			'iv_load_policy' => $instance['youtube_embed_widget_show_annotations']?'1':'3',
			'color' => $instance['youtube_embed_widget_show_progress_bar_color'],
			'autohide' => $instance['youtube_embed_widget_autohide_parameters'],
			'disablekb' => $instance['youtube_embed_widget_disable_keyboard'],	
			'enablejsapi' => '1',	
			'version' => '3',	
		);
		 if($instance['youtube_embed_widget_playlist']){
			 $parametrs['list'] = $instance['youtube_embed_widget_playlist'];
			
		 }else{
		  if($instance['youtube_embed_widget_loop_video'])
			 	$parametrs['playlist']=$instance['youtube_embed_widget_video'];
		 }
			
		$link_youtube = '//www.youtube.com/embed/'.$instance['youtube_embed_widget_video'];
		$link_youtube = add_query_arg( $parametrs, $link_youtube );


		$code='<iframe class="youtube_embed_iframe"   '.$voloutput.$allowfullScreen.' style="width:'.$instance['youtube_embed_widget_width'].'px; height:'.$instance['youtube_embed_widget_height'].'px" src="'.$link_youtube.'"></iframe>';

		echo $code;
		// After widget part //
		
		echo $after_widget;
	}

	// Function for Updating YouTube Player Settings //
		function update($new_instance, $old_instance) {
		
		
		$initial_values= array( 
			"youtube_embed_widget_video"				=>'',
			"youtube_embed_widget_playlist"				=>'',
			"youtube_embed_widget_width"  				=> "320",
			"youtube_embed_widget_height"  				=> "265",
			"youtube_embed_widget_autoplay"  			=> "0",
			"youtube_embed_widget_loop_video"  			=> "0",
			"youtube_embed_widget_enable_fullscreen"  	=> "1",	
			"youtube_embed_widget_show_title"  			=> "1",
			"youtube_embed_widget_show_youtube_icon"  	=> "1",
			"youtube_embed_widget_show_annotations"  	=> "1",
			"youtube_embed_widget_show_progress_bar_color" => "red",
			"youtube_embed_widget_autohide_parameters"  	=> "1",
			"youtube_embed_widget_set_initial_volume" => "",
				"youtube_embed_widget_initial_volume" 		=> "100",
			"youtube_embed_widget_disable_keyboard"  	=>"0"
		);
		$initial_values['title']	= strip_tags($new_instance['title']);
		foreach($initial_values as $key => $value){
			$initial_values[$key]=$new_instance[$key];
		}
		return $initial_values;  /// Return new parameters value
		
	}

	/* YouTube Embed plugin admin page options function */
	function form($instance) {
		global $wpdb;
		$initial_values= array( 
			'title'										=>'',
			"youtube_embed_widget_video"				=>'',
			"youtube_embed_widget_playlist"				=>'',
			"youtube_embed_widget_width"  				=> "320",
			"youtube_embed_widget_height"  				=> "265",
			"youtube_embed_widget_autoplay"  			=> "0",
			"youtube_embed_widget_loop_video"  			=> "0",
			"youtube_embed_widget_enable_fullscreen"  	=> "1",
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
			$initial_values[$key]=get_option($key);
		}
		$instance = wp_parse_args( (array) $instance, $initial_values );
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
        <table class="wp-list-table widefat fixed posts youtube_settings_table" style="width: 100%; table-layout: fixed;">            
            <tbody>
            	<tr>
                    <td width="25%">     
                    	Video Id:
                    </td>
                </tr>
                <tr>
                    <td>     
                    	<input type="text" style="width:95%;" name="<?php echo $this->get_field_name('youtube_embed_widget_video') ?>" id="<?php echo $this->get_field_id('youtube_embed_widget_video'); ?>" placeholder="9bZkp7q19f0" value="<?php echo $instance['youtube_embed_widget_video']; ?>">
                    </td>
                </tr>
                <tr>
                    <td width="25%">     
                 	   Playlist Id:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	<input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;" type="text" style="width:95%;" name="<?php echo $this->get_field_name('youtube_embed_widget_playlist') ?>" id="<?php echo $this->get_field_id('youtube_embed_widget_playlist'); ?>" placeholder="RDQvRhanJ4wlw#t=124" value="<?php echo $instance['youtube_embed_widget_playlist']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Width:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	<input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="text" name="<?php echo $this->get_field_name('youtube_embed_widget_width') ?>" id="<?php echo $this->get_field_id('youtube_embed_widget_width'); ?>" value="<?php echo $instance['youtube_embed_widget_width']; ?>"><span class="befor_input_small_desc">(px)</span>
                    </td>
                </tr> 
                <tr>
                     <td>     
                    	Height:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	<input  onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;" type="text" name="<?php echo $this->get_field_name('youtube_embed_widget_height') ?>" id="<?php echo $this->get_field_id('youtube_embed_widget_height'); ?>" value="<?php echo $instance['youtube_embed_widget_height']; ?>"><span class="befor_input_small_desc">(px)</span>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Autoplay:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_autoplay') ?>"  <?php checked($instance['youtube_embed_widget_autoplay'],'1') ?> value="1">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_autoplay') ?>" <?php checked($instance['youtube_embed_widget_autoplay'],'0') ?> value="0">No</label>
                    </td>
                </tr> 
                <tr>
                     <td>     
                     	Player Theme:<span class="pro_subtitle_span">Pro feature!</span>                 
                    </td>
                </tr>
                <tr>
                    <td>     
                    	<select  onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;" >
                            <option  value="light">Light</option>
                            <option value="dark" selected="selected">Dark</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td>     
                    	Loop video:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_loop_video') ?>" <?php checked($instance['youtube_embed_widget_loop_video'],'1') ?> value="1">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_loop_video') ?>" <?php checked($instance['youtube_embed_widget_loop_video'],'0') ?>  value="0">No</label>
                    </td>
 				</tr> 
                <tr>
                    <td>     
                    	Show Fullscreen button:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_enable_fullscreen') ?>" <?php checked($instance['youtube_embed_widget_enable_fullscreen'],'1') ?> value="1">Show</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_enable_fullscreen') ?>" <?php checked($instance['youtube_embed_widget_enable_fullscreen'],'0') ?> value="0">Hide</label>
                    </td>
 				</tr> 
                <tr>                     
                	<td>     
                    	Show related videos:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" checked="checked" value="1">Show</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" value="0">Hide</label>
                    </td>
                    
                </tr>
                <tr>                     
                	<td>     
                    	Show video in popup: <span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" class="<?php echo $this->get_field_id('youtube_embed_widget_show_popup') ?>show_in_popup_radios" name="<?php echo $this->get_field_name('youtube_embed_widget_show_popup') ?>"  value="1">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" class="<?php echo $this->get_field_id('youtube_embed_widget_show_popup') ?>show_in_popup_radios" name="<?php echo $this->get_field_name('youtube_embed_widget_show_popup') ?>"  checked="checked" value="0">No</label>
                    </td>
                    
                </tr>                 
                <tr>
                    <td>     
                    	Show information:<span class="pro_subtitle_span">Pro feature!</span>
                    </td> 
                </tr>
                <tr>				                 
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_title') ?>" <?php checked($instance['youtube_embed_widget_show_title'],'1'); ?> value="1">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_title') ?>" <?php checked($instance['youtube_embed_widget_show_title'],'0'); ?> value="0">No</label>
                    </td> 
 				</tr> 
                <tr>                   
                    <td>     
                    Show YouTube icon:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_youtube_icon') ?>" <?php checked($instance['youtube_embed_widget_show_youtube_icon'],'1'); ?> value="1">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_youtube_icon') ?>" <?php checked($instance['youtube_embed_widget_show_youtube_icon'],'0'); ?> value="0">No</label>
                    </td>
                </tr>
                <tr>
                    <td>     
                    	Show annotations:<span class="pro_subtitle_span">Pro feature!</span>
                    </td> 
                </tr>
                <tr>				                  
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_annotations') ?>" <?php checked($instance['youtube_embed_widget_show_annotations'],'1'); ?> value="1">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_annotations') ?>" <?php checked($instance['youtube_embed_widget_show_annotations'],'0'); ?> value="0">No</label>
                    </td>
                    </tr>
                 <tr>
                    <td>     
                    	Progress bar color:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_progress_bar_color') ?>" <?php checked($instance['youtube_embed_widget_show_progress_bar_color'],'red'); ?> value="red">Red</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"   type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_show_progress_bar_color') ?>" <?php checked($instance['youtube_embed_widget_show_progress_bar_color'],'white'); ?> value="white">White</label>
                    </td>
                </tr>
                 <tr>
                    <td>     
                    	Auto hide parameters:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
 				</tr>
                <tr>              
                    <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_autohide_parameters') ?>" <?php checked($instance['youtube_embed_widget_autohide_parameters'],'1'); ?> value="1">Yes</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_autohide_parameters') ?>" <?php checked($instance['youtube_embed_widget_autohide_parameters'],'0'); ?> value="0">No</label>
                    </td>
                    </tr> 
                <tr>
                    <td>     
                    	Player Initial Volume:<span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                    <td class="pro_feature_td">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="checkbox" name="<?php echo $this->get_field_name('youtube_embed_widget_set_initial_volume') ?>" id="<?php echo $this->get_field_id('youtube_embed_widget_set_initial_volume'); ?>" <?php checked($instance['youtube_embed_widget_set_initial_volume'],'1'); ?> value="1">Set initial value</label>
                        <div id="<?php echo $this->get_field_id('youtube_embed_widget_set_initial_volume'); ?>div" class="div_included_slider youtube_embed_widget_set_initial_volume" <?php if($instance['youtube_embed_widget_set_initial_volume']!=1 || $instance['youtube_embed_widget_set_initial_volume']!="1") echo "style='display:none;'" ?>>
                            <input type="hidden" name="<?php echo $this->get_field_name('youtube_embed_widget_initial_volume') ?>" id="<?php echo $this->get_field_id('youtube_embed_widget_initial_volume'); ?>" class="slider_input" value="<?php echo $instance['youtube_embed_widget_initial_volume']; ?>">
                            <div class="slider_parametrs" id="<?php echo $this->get_field_id('youtube_embed_widget_initial_volume_div'); ?>"></div>
                            <span id="<?php echo $this->get_field_id('youtube_embed_widget_initial_volume_span'); ?>" class="slider_span"></span>
                        </div>
                        
                    </td>
                </tr>
                <tr>
                    <td>     
                   		Disable player keyboard: <span class="pro_subtitle_span">Pro feature!</span>
                    </td>
                </tr>
                <tr>
                   <td class="radio_input">     
                    	<label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_disable_keyboard') ?>" <?php checked($instance['youtube_embed_widget_disable_keyboard'],'1'); ?> value="1">Enable</label>
                        <label onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"><input onMouseDown="alert('If you want to use this feature upgrade to Pro Version'); return false;"  type="radio" name="<?php echo $this->get_field_name('youtube_embed_widget_disable_keyboard') ?>" <?php checked($instance['youtube_embed_widget_disable_keyboard'],'0'); ?> value="0">Disable</label>
                    </td>
                </tr>                
            </tbody>
		</table>
        <br>
        <a href="http://wpdevart.com/wordpress-youtube-embed-plugin" target="_blank" style="color: rgba(10, 154, 62, 1);; font-weight: bold; font-size: 18px; text-decoration: none;">Upgrade to Pro Version</a>
           <br> <br>
		<script>
		
			jQuery('#<?php echo $this->get_field_id('youtube_embed_widget_set_initial_volume'); ?>').click(function(){
				if(jQuery(this).prop('checked')==true){
					jQuery('#<?php echo $this->get_field_id('youtube_embed_widget_set_initial_volume'); ?>div').show('normal');
				}
				else{
					jQuery('#<?php echo $this->get_field_id('youtube_embed_widget_set_initial_volume'); ?>div').hide('normal');
				}
			});
			jQuery('.<?php echo $this->get_field_id('youtube_embed_widget_thumb_popup_width'); ?>popup_settings').ready(function(e) {
                if(jQuery('.<?php echo $this->get_field_id('youtube_embed_widget_show_popup') ?>show_in_popup_radios').eq(0).prop('checked')){
					jQuery('.<?php echo $this->get_field_id('youtube_embed_widget_thumb_popup_width'); ?>popup_settings').show('normal');
				}
				else{
					jQuery('.<?php echo $this->get_field_id('youtube_embed_widget_thumb_popup_width'); ?>popup_settings').hide('normal');
				}
            });
			jQuery('.<?php echo $this->get_field_id('youtube_embed_widget_show_popup') ?>show_in_popup_radios').click(function(){
				if(jQuery(this).val()=='1'){
					jQuery('.<?php echo $this->get_field_id('youtube_embed_widget_thumb_popup_width'); ?>popup_settings').show('normal');
				}
				else{
					jQuery('.<?php echo $this->get_field_id('youtube_embed_widget_thumb_popup_width'); ?>popup_settings').hide('normal');
				}
			});
			
			jQuery("#<?php echo $this->get_field_id('youtube_embed_widget_initial_volume'); ?>_div").ready(function(e) {               
				jQuery( "#<?php echo $this->get_field_id('youtube_embed_widget_initial_volume'); ?>_div" ).slider({
					range: "min",
					value: "<?php echo ($instance['youtube_embed_widget_initial_volume'])?$instance['youtube_embed_widget_initial_volume']:'100';  ?>",
					min: 0,
					max: 100,
					slide: function( event, ui ) {
						return false
					}
				});	
				jQuery('.pro_feature_td .slider_parametrs,.pro_feature_td  .ui-slider-handle').mousedown(function(){
					alert('If you want to use this feature upgrade to Pro Version');
					return false;
				})		
				jQuery( "#<?php echo $this->get_field_id('youtube_embed_widget_initial_volume'); ?>_span" ).html( '<?php echo ($instance['youtube_embed_widget_initial_volume'])?$instance['youtube_embed_widget_initial_volume']:'100';  ?>%' );
			});
       </script><?php 
	}
}

