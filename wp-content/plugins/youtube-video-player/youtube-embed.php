<?php
/**
 * Plugin Name: YouTube Embed WpDevArt
 * Plugin URI: http://wpdevart.com/wordpress-youtube-embed-plugin
 * Description: YouTube Embed plugin is an convenient tool for adding video to your website. Use YouTube Embed plugin to add YouTube videos in posts/pages, widgets.
 * Version: 2.0.4
 * Author: wpdevart
 * Author URI:    http://wpdevart.com
 * License URI: GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 

class youtube_embed{
	// required variables for YouTube Embed plugin
	
	private $plugin_url;
	
	private $plugin_path;
	
	private $version;
	
	public $options;

    /*############ Construct Function ##################*/	
	
	function __construct(){
		//
		define("wpdevart_youtube_support_url","https://wordpress.org/support/plugin/youtube-video-player");
		
		$this->plugin_url  = trailingslashit( plugins_url('', __FILE__ ) );
		$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->version     = 1.0;
		$this->call_base_filters();
		$this->create_admin_menu();
		$this->front_end();
		
	}

    /*############ Create admin menu Function ##################*/
	
	private function create_admin_menu(){
		
		require_once($this->plugin_path.'admin/admin_menu.php');
		
		$admin_menu = new youtube_admin_menu(array('plugin_url' => $this->plugin_url,'plugin_path' => $this->plugin_path));
		
		add_action('admin_menu', array($admin_menu,'create_menu'));
		
	}
	
    /*############ Front-end Function ##################*/	
	
	public function front_end(){
				
		require_once($this->plugin_path.'fornt_end/front_end.php');
		$youtube_embed_fornt_end = new youtube_embed_front_end(array('menu_name' => 'Youtube','plugin_url' => $this->plugin_url,'plugin_path' => $this->plugin_path));
		
		require_once($this->plugin_path.'fornt_end/fornt_end_widget.php');
		add_action('widgets_init', create_function('', 'return register_widget("youtube_embed_widget");'));
	}

    /*############ Register required scripts Function ##################*/
	
	public function registr_requeried_scripts(){		
		wp_register_script('youtube_front_end_api_js',$this->plugin_url.'fornt_end/scripts/youtube_embed_front_end.js',array('jquery'));
		wp_register_script('youtube_api_js',"https://www.youtube.com/iframe_api",array('youtube_front_end_api_js'));
		wp_register_style('admin_style_youtube_embed',$this->plugin_url.'admin/styles/admin_themplate.css');
		wp_register_style('front_end_youtube_style',$this->plugin_url.'fornt_end/styles/baze_styles_youtube.css');
		wp_register_style('jquery-ui-style',$this->plugin_url.'admin/styles/jquery-ui.css');		
	}
	
    /*############ Enqueue Requeried Scripts Function ##################*/	
	
	public function enqueue_requeried_scripts(){	
		wp_enqueue_style("jquery-ui-style");
		wp_enqueue_script("jquery-ui-slider");
		wp_enqueue_style('admin_style_youtube_embed',$this->plugin_url.'admin/styles/admin_themplate.css');
	}
	
	/*############ Base Filters Function ##################*/	
	
	public function call_base_filters(){
		add_action( 'init',  array($this,'registr_requeried_scripts') );
		add_action( 'admin_head',  array($this,'enqueue_requeried_scripts') );
		//for_upgrade
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this,'plugin_activate_sublink') );
	}
	
	 /*############ Activate Sublink Function ##################*/	
	
  	public function plugin_activate_sublink($links){
		$plugin_submenu_added_link=array();		
		 $added_link = array(
		 '<a target="_blank" style="color: rgba(10, 154, 62, 1); font-weight: bold; font-size: 13px;" href="http://wpdevart.com/wordpress-youtube-embed-plugin">Upgrade to Pro</a>',
		 );
		$plugin_submenu_added_link=array_merge( $plugin_submenu_added_link, $added_link );
		$plugin_submenu_added_link=array_merge( $plugin_submenu_added_link, $links );
		return $plugin_submenu_added_link;
	}
	
	/*############ Include File Function ##################*/	
	
	private function include_file(){
	
	}
}
$youtube_embed = new youtube_embed();

?>