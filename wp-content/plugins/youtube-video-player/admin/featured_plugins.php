<?php

    /*#################### Featured plugins page ########################*/
	
class youtube_embed_featured_plugins{

    /*############ Construct Function ##################*/
	
	function __construct($params){
		// Set plugin url
		if(isset($params['plugin_url']))
			$this->plugin_url=$params['plugin_url'];
		else
			$this->plugin_url=trailingslashit(dirname(plugins_url('',__FILE__)));
		// Set plugin path
		if(isset($params['plugin_path']))
			$this->plugin_path=$params['plugin_path'];
		else
			$this->plugin_path=trailingslashit(dirname(plugin_dir_path('',__FILE__)));
		/*Ajax parameters*/
		
	
	}
	
	

	

	/*#################### Featured plugins list function ########################*/	
	
	public function controller_page(){
		$plugins_array=array(
			'gallery_album'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/gallery-album-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-gallery-plugin',
						'title'			=>	'WordPress Gallery plugin',
						'description'	=>	'Gallery plugin is an useful tool that will help you to create Galleries and Albums. Try our nice Gallery views and awesome animations.'
						),
			'coming_soon'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/coming_soon.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-coming-soon-plugin/',
						'title'			=>	'WordPress Coming soon ',
						'description'	=>	'Coming soon and Maintenance mode plugin is an awesome tool for showing your visitors that you are working on your website to make it better.'
						),
			'Contact forms'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/contact_forms.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-contact-form-plugin/',
						'title'			=>	'Contact Form Builder',
						'description'	=>	'Contact Form Builder plugin is an handy tool for creating different types of contact forms on your WordPress websites.'
						),
			'Booking Calendar'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/Booking_calendar_featured.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-booking-calendar-plugin/',
						'title'			=>	'WordPress Booking Calendar',
						'description'	=>	'WordPress Booking Calendar plugin is an awesome tool for creating booking calendars for your website. Create booking calendars in a few minutes.'
						),	
			'countdown'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/countdown.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-countdown-plugin/',
						'title'			=>	'WordPress Countdown plugin',
						'description'	=>	'WordPress Countdown plugin is an nice tool to create and insert countdown timers into your website posts/pages and widgets.'
						),
			'lightbox'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/lightbox.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-lightbox-plugin',
						'title'			=>	'WordPress Lightbox Popup',
						'description'	=>	'WordPress lightbox Popup plugin is high customizable and responsive product for displaying images and videos in popup.'
						),
            'facebook-comments'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/facebook-comments-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-comments-plugin/',
						'title'			=>	'WordPress Facebook comments',
						'description'	=>	'Facebook comments plugin will help you to display Facebook Comments on your website. You can use Comments Box on pages/posts or in Php code.'
						),							
			'facebook'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/facebook.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-like-box-plugin',
						'title'			=>	'Facebook Like Box',
						'description'	=>	'Facebook like box plugin will help you to display Facebook like box on your wesite, just add Like box widget into your sidebar or insert it into your website posts/pages and use it.'
						),
			'poll'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/poll.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-polls-plugin',
						'title'			=>	'WordPress Polls sysyem',
						'description'	=>	'WordPress Polls plugin is an wonderful tool for creating polls and survey forms for your visitors. You can use polls almost everywhere - on widgets, posts and pages.'
						),
			'scroll'=>array(
						'image_url'		=>	$this->plugin_url.'admin/images/featured_plugins/Scroll.png',
						'site_url'		=>	'https://wordpress.org/plugins/wp-scroll-2',
						'title'			=>	'Scroll To Top plugin',
						'description'	=>	'Scroll plugin is an simple and nice plugin with the standard scroll settings. You can use it on your website different sides.'
						),						
											
			
		);
		?>
        <style>
         .featured_plugin_main{
			 background-color: #ffffff;
			 border: 1px solid #dedede;
			 box-sizing: border-box;
			 float:left;
			 margin-right:20px;
			 margin-bottom:20px;
			 
			 width:450px;
		 }
		.featured_plugin_image{
			padding: 15px;
			display: inline-block;
			float:left;
		}
		.featured_plugin_image a{
		  display: inline-block;
		}
		.featured_plugin_information{			
			float: left;
			width: auto;
			max-width: 282px;

		}
		.featured_plugin_title{
			color: #0073aa;
			font-size: 18px;
			display: inline-block;
		}
		.featured_plugin_title a{
			text-decoration:none;
					
		}
		.featured_plugin_title h4{
			margin:0px;
			margin-top: 20px;
			margin-bottom:8px;			  
		}
		.featured_plugin_description{
			display: inline-block;
		}
        
        </style>
        <script>
		
        jQuery(window).resize(like_box_feature_resize);
		jQuery(document).ready(function(e) {
            like_box_feature_resize();
        });
		
		function like_box_feature_resize(){
			var like_box_width=jQuery('.featured_plugin_main').eq(0).parent().width();
			var count_of_elements=Math.max(parseInt(like_box_width/450),1);
			var width_of_plugin=((like_box_width-count_of_elements*24-2)/count_of_elements);
			jQuery('.featured_plugin_main').width(width_of_plugin);
			jQuery('.featured_plugin_information').css('max-width',(width_of_plugin-160)+'px');
		}
       	</script>
        	<h2>Featured Plugins</h2>
            <br>
            <br>
            <?php foreach($plugins_array as $key=>$plugin) { ?>
            <div class="featured_plugin_main">
            	<span class="featured_plugin_image"><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><img src="<?php echo $plugin['image_url'] ?>"></a></span>
                <span class="featured_plugin_information">
                	<span class="featured_plugin_title"><h4><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><?php echo $plugin['title'] ?></a></h4></span>
                    <span class="featured_plugin_description"><?php echo $plugin['description'] ?></span>
                </span>
                <div style="clear:both"></div>                
            </div>
            <?php } 
	}	
	
}


 ?>