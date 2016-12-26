<?php
/* 
Plugin Name: FontPress
Plugin URI: http://codecanyon.net/item/fontpress-font-manager-plugin/1746759?ref=LCweb
Description: Give an unique touch to your website, using custom fonts. Choose among Cufons, Google and Adobe web fonts, Font-Face fonts and Adobe Typekit. Add and manage unlimited rules to customize whatever you want wherever you want in your pages. Use the shortcode wizard to customize text without knowing CSS selectors.  
Author: Luca Montanari
Version: 2.4
Author URI: http://codecanyon.net/user/LCweb?ref=LCweb
*/  


/////////////////////////////////////////////
/////// MAIN DEFINES ////////////////////////
/////////////////////////////////////////////

// plugin path
$wp_plugin_dir = substr(plugin_dir_path(__FILE__), 0, -1);
define( 'FP_DIR', $wp_plugin_dir );

// plugin url
$wp_plugin_url = substr(plugin_dir_url(__FILE__), 0, -1);
define( 'FP_URL', $wp_plugin_url );


// WPMU prefix
if(is_multisite()) {
	global $blog_id;
	define( 'FP_BID','_'.$blog_id);
} else {	
	define( 'FP_BID', '');
}



/////////////////////////////////////////////
/////// MAIN SCRIPT & CSS INCLUDES //////////
/////////////////////////////////////////////

// global script enqueuing
function fp_global_scripts() { 
	require_once(FP_DIR . '/functions.php');
	
	wp_enqueue_script("jquery");
	
	// admin css & js
	if (is_admin()) {  
		wp_enqueue_style('fp_admin', FP_URL . '/css/admin.css');
		
		// lcweb switch
		wp_enqueue_style( 'lc-switch', FP_URL.'/js/lc-switch/lc_switch.css', 999);
		
		// colorpicker
		wp_enqueue_style( 'fp-colpick', FP_URL.'/js/colpick/css/colpick.css', 999);
		
		wp_enqueue_script( 'jquery-ui-sortable' );	
	}
	
	
	if (!is_admin()) { 
		// frontend enabled cufon 
		fp_enqueue_enabled_cufon();
		
		// frontend enabled webfonts
		fp_enqueue_enabled_webfont();
		
		// enabled adobe typekits
		fp_enqueue_enabled_typekit();
	}
	
	if (!is_admin()) {
		if(!get_option('fp_inline_code')) {
			// frontend css
			if (file_exists(FP_DIR.'/custom_files/frontend'.FP_BID.'.css')) {
				wp_enqueue_style('fp_frontend_css', FP_URL.'/custom_files/frontend'.FP_BID.'.css', '2.4');		
			}
			
			// frontend js
			if (file_exists(FP_DIR.'/custom_files/frontend'.FP_BID.'.js')) {
				wp_enqueue_script('fp_frontend_js', FP_URL.'/custom_files/frontend'.FP_BID.'.js', '2.4');		
			}
		}
		else {add_action('wp_head', 'fp_inline_code', 999);}
	}
}
add_action( 'init', 'fp_global_scripts' );


///////////////////////////////////////
// INLINE CSS AND JS FOR BAD SERVERS

function fp_inline_code(){
	echo '<style type="text/css">';
	include_once(FP_DIR.'/frontend_css.php');
	echo '</style>';
	
	echo '<script type="text/javascript">';
	include_once(FP_DIR.'/frontend_js.php');
	echo '</script>';
}


/////////////////////////////////////////////
/////// MENU ITEMS //////////////////////////
/////////////////////////////////////////////

function fp_admin_actions() {  
	$menu_img = FP_URL.'/img/fontpress_small.png'; 
	$capability = 'install_plugins';
			
	add_menu_page('FontPress', 'FontPress', $capability, 'fp_settings', 'fp_rule_manager', $menu_img);
	
	// submenus
	add_submenu_page('fp_settings', __('Element Rules', 'fp_ml'), __('Element Rules', 'fp_ml'), $capability, 'fp_settings', 'fp_rule_manager');	
	add_submenu_page('fp_settings', __('Manage Cufons', 'fp_ml'), __('Manage Cufons', 'fp_ml'), $capability, 'fp_man_cufon', 'fp_man_cufon');	
	add_submenu_page('fp_settings', __('Manage Web Fonts', 'fp_ml'), __('Manage Web Fonts', 'fp_ml'), $capability, 'fp_man_gwf', 'fp_man_gwf');
	add_submenu_page('fp_settings', __('Man. Font-Face Fonts', 'fp_ml'), __('Man. Font-Face Fonts', 'fp_ml'), $capability, 'fp_man_fontface', 'fp_man_fontface');
	add_submenu_page('fp_settings', __('Man. Adobe Typekits', 'fp_ml'), __('Man. Adobe Typekits', 'fp_ml'), $capability, 'fp_man_adobe_typekit', 'fp_man_adobe_typekit');
}  
add_action('admin_menu', 'fp_admin_actions');  


// elements rules
function fp_rule_manager() {
	include_once(FP_DIR . '/rules_manager.php');
}

// manage cufon page
function fp_man_cufon() {
	include_once(FP_DIR . '/font-managers/cufons.php');	
}

//  manage google and adobe web fonts page
function fp_man_gwf() {
	include_once(FP_DIR . '/font-managers/web_fonts.php');	
}

//  manage @font-face fonts
function fp_man_fontface() {
	include_once(FP_DIR . '/font-managers/fontface.php');	
}

//  manage adobe typekits
function fp_man_adobe_typekit() {
	include_once(FP_DIR . '/font-managers/adobe_typekit.php');	
}




//////////////////////////////////////

// AJAX
include_once(FP_DIR . '/ajax.php');

// TINYMCE BUTTON
include_once(FP_DIR . '/tinymce_btn.php');

// SHORTCODE
include_once(FP_DIR . '/shortcodes.php');


////////////
// UPDATE NOTIFIER
if(!class_exists('lc_update_notifier')) {
	include_once(FP_DIR . '/lc_update_notifier.php');
}
$lcun = new lc_update_notifier(__FILE__, 'http://www.lcweb.it/envato_update/fp.php');
////////////


////////////////////////////////////////////////////////////////////////
// CREATES FRONTEND FILES AND PRELOAD GOOGLE AND ADOBE FONTS ON PLUGIN ACTIVATION

function fp_init_actions() {
	include(FP_DIR . '/functions.php');
	
	if(!get_option('fp_webfonts')) {
		$gwf = array(
			'Open Sans'	=> 'http://fonts.googleapis.com/css?family=Open+Sans:400,400italic',
			'Yanone Kaffeesatz' => 'http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700',
			'Lato' => 'http://fonts.googleapis.com/css?family=Lato:400,400italic,700',
			'Marck Script' => 'http://fonts.googleapis.com/css?family=Marck+Script',
			'Raleway' => 'http://fonts.googleapis.com/css?family=Raleway:100',
			'Homemade Apple' => 'http://fonts.googleapis.com/css?family=Homemade+Apple',
			'Josefin Slab' => 'http://fonts.googleapis.com/css?family=Josefin+Slab:600,700,600italic',
			'Seaweed Script' => 'http://fonts.googleapis.com/css?family=Seaweed+Script',
			
			'amaranth' => 'http://use.edgefonts.net/amaranth.js',
			'quattrocento-sans' => 'http://use.edgefonts.net/quattrocento-sans.js',
			'lobster-two' => 'http://use.edgefonts.net/lobster-two.js'
		);
		ksort($gwf);
			
		if(!get_option('fp_webfonts')) { add_option( 'fp_webfonts', '255', '', 'yes' ); }
		update_option('fp_webfonts', $gwf);	
	}
	
	// create CSS and JS or set the inline flag
	if(!fp_create_frontend_files()) {
		if(!get_option('fp_inline_code')) { add_option('fp_inline_code', '255', '', 'yes'); }
		update_option('fp_inline_code', 1);	
	}
	else {delete_option('fp_inline_code');}	
	
	return true;
}
register_activation_hook(__FILE__, 'fp_init_actions');

