<?php

/**
	ReduxFramework Sample Config File
	For full documentation, please visit http://reduxframework.com/docs/
**/

/*
 *
 * Set the text domain for the theme or plugin.
 *
 */
define('Redux_TEXT_DOMAIN', 'crum');
/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options(){
    $args = array();


    // For use with a tab below
		$tabs = array();

		ob_start();

		$ct = wp_get_theme();
        $theme_data = $ct;
        $item_name = $theme_data->get('Name');
		$tags = $ct->Tags;
		$screenshot = $ct->get_screenshot();
		$class = $screenshot ? 'has-screenshot' : '';

		$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;' ), $ct->display('Name') );

		?>
		<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
			<?php if ( $screenshot ) : ?>
				<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
				<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
					<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
				</a>
				<?php endif; ?>
				<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
			<?php endif; ?>

			<h4>
				<?php echo $ct->display('Name'); ?>
			</h4>

			<div>
				<ul class="theme-info">
					<li><?php printf( __('By %s'), $ct->display('Author') ); ?></li>
					<li><?php printf( __('Version %s'), $ct->display('Version') ); ?></li>
					<li><?php echo '<strong>'.__('Tags', 'crum').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
				</ul>
				<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
				<?php if ( $ct->parent() ) {
					printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
						__( 'http://codex.wordpress.org/Child_Themes' ),
						$ct->parent()->display( 'Name' ) );
				} ?>

			</div>

		</div>

		<?php
		$item_info = ob_get_contents();

		ob_end_clean();


	if( file_exists( dirname(__FILE__).'/info-html.html' )) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}
		$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
	}


	// Setting dev mode to true allows you to view the class settings/info in the panel.
	// Default: true
	$args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	$args['icon_type'] = 'iconfont';
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['dev_mode_icon_class'] = 'icon-large';

	// If you want to use Google Webfonts, you MUST define the api key.
	//$args['google_api_key'] = 'xxxx';

	// Define the starting tab for the option panel.
	// Default: '0';
	//$args['last_tab'] = '0';

	// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
	// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
	// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
	// Default: 'standard'
	//$args['admin_stylesheet'] = 'standard';

	// Add HTML before the form.
	/*
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'crum');

	// Add content after the form.
	$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'crum');

	// Set footer/credit line.
	//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'crum');

	// Setup custom links in the footer for share icons
	$args['share_icons']['twitter'] = array(
		'link' => 'http://twitter.com/ghost1227',
		'title' => __('Follow me on Twitter', 'crum'),
		'img' => Redux_OPTIONS_URL . 'img/social/Twitter.png'
	);
	$args['share_icons']['linked_in'] = array(
		'link' => 'http://www.linkedin.com/profile/view?id=52559281',
		'title' => __('Find me on LinkedIn', 'crum'),
		'img' => Redux_OPTIONS_URL . 'img/social/LinkedIn.png'
	);
*/
	// Enable the import/export feature.
	// Default: true
	$args['show_import_export'] = true;
	$args['show_options_object'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	$args['import_icon_type'] = 'iconfont';
	// Default: refresh
	$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

	// Set a custom option name. Don't forget to replace spaces with underscores!
	$args['opt_name'] = 'second-touch';

	// Set a custom menu icon.
	//$args['menu_icon'] = '';

	// Set a custom title for the options page.
	// Default: Options
	$args['menu_title'] = __('Options', 'crum');

	// Set a custom page title for the options page.
	// Default: Options
	$args['page_title'] = __('Options', 'crum');

	// Set a custom page slug for options page (wp-admin/themes.php?page=***).
	// Default: redux_options
	$args['page_slug'] = 'redux_options';

	// Set a custom page capability.
	// Default: manage_options
	//$args['page_cap'] = 'manage_options';

	// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
	// Default: menu
	//$args['page_type'] = 'submenu';

	// Set the parent menu.
	// Default: themes.php
	// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	//$args['page_parent'] = 'options-general.php';

	// Set a custom page location. This allows you to place your menu where you want in the menu order.
	// Must be unique or it will override other items!
	// Default: null
	//$args['page_position'] = null;

	// Set a custom page icon class (used to override the page icon next to heading)
	//$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';
	//$args['dev_mode_icon_type'] = 'image';
	//$args['import_icon_type'] == 'image';

	// Disable the panel sections showing as submenu items.
	// Default: true
	//$args['allow_sub_menu'] = false;

	$assets_folder = get_template_directory_uri() .'/assets/';

	// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
	/* $args['help_tabs'][] = array(
			'id' => 'redux-opts-1',
			'title' => __('Theme Information 1', 'crum'),
			'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'crum')
		);
		$args['help_tabs'][] = array(
			'id' => 'redux-opts-2',
			'title' => __('Theme Information 2', 'crum'),
			'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'crum')
		);

		// Set the help sidebar for the options page.
		$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'crum');
	*/




    $sections = array();

    //Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';

    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) :

      if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
      	$sample_patterns = array();

        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

          if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
          	$name = explode(".", $sample_patterns_file);
          	$name = str_replace('.'.end($name), '', $sample_patterns_file);
          	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
          }
        }
      endif;
    endif;

	$sections[] = array(
		// Redux uses the Font Awesome iconfont to supply its default icons.
		// If $args['icon_type'] = 'iconfont', this should be the icon name minus 'icon-'.
		// If $args['icon_type'] = 'image', this should be the path to the icon.
		// Icons can also be overridden on a section-by-section basis by defining 'icon_type' => 'image'
		'icon_type' => 'image',
		'icon' => Redux_OPTIONS_URL . 'assets/img/home.png',
		// Set the class for this icon.
		// This field is ignored unless $args['icon_type'] = 'iconfont'
		'icon_class' => 'icon-large',
		'title' => __('Getting Started', 'crum'),
		'fields' => array(
			array(
				'id' => 'font_awesome_info',
				'type' => 'raw',
				'content' => '<h3 style="text-align: center; border-bottom: none;">Welcome to the Options panel of the Second Touch theme!</h3>
<h4 style="text-align: center; font-size: 1.3em;">What does this mean to you?</h4>
	<p> From here on you will be able to regulate the main options of all the elements of the theme. </p>
    <p>Theme documentation you will find in the archive with the theme I the "Documentation" folder. </p>
    <p>If you have some questions on the theme, you can send them to our PM on <a href="http://themeforest.net/user/Crumina ">Themeforest.net</a>, you can send us email directly to <a href="mailto:info@crumina.net">info@crumina.net</a>, or you can post your questions on our <a href="http://support.crumina.net">Support Forum</a>.</p>'
			)
		)
	);


	$sections[] = array(
		'title' => __('Main Options', 'crum'),
		'desc' => __('<p class="description">Main options of site</p>', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'awesome-globe',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(

			array(
				'id' => 'envato-api-key',
				'type' => 'text',
				'title' => __('Item purchase code', 'crum'),
				'desc' => __('<p>Insert item purchase code to receive automatic theme updates.</p>', 'crum'),
				'default' => ''
			),

			array(
				'id' => 'scroll_animation',
				'type' => 'button_set',
				'title' => __('Page scroll animation', 'crum'),
				'desc' => __('Enable or disable page scroll animation', 'crum'),
				'options' => array('on' => __('On','crum'), 'off' => __('Off', 'crum')),
				'default' => 'on'
			),

			array(
				'id' => 'custom_favicon',
				'type' => 'media',
				'title' => __('Favicon', 'crum'),
				'desc' => __('Select a 16px X 16px image from the file location on your computer and upload it as a favicon of your site', 'crum')
			),
			array(
				'id'      => 'custom_logo_image',
				'type'    => 'media',
				'title'   => __( 'Header Logotype image', 'crum' ),
				'desc'    => __( 'Select an image from the file location on your computer and upload it as a header logotype', 'crum' ),
				'default' => array(
					'url' => $assets_folder . 'img/logo.png',
				),
			),

			array(
				'id' => 'top_adress_block',
				'type' => 'button_set',
				'title' => __('Top block with address', 'crum'),

				'desc' => __('Enable or disable address block', 'crum'),
				'options' => array('1' => __('On','crum'), '0' => __('Off', 'crum')),
				'default' => '1'
			),

			array(
				'id' => 'top_login_block',
				'type' => 'button_set',
				'title' => __('Top block with login', 'crum'),

				'desc' => __('Enable or disable login block', 'crum'),
				'options' => array('1' => __('On','crum'), '0' => __('Off', 'crum')),
				'default' => '1'
			),

			array(
				'id' => 'disable_breadcrumbs',
				'type' => 'button_set',
				'title' => __('Breadcrumbs on page title panel', 'crum'),

				'desc' => __('Enable or disable breadcrumbs block', 'crum'),
				'options' => array('0' => __('On','crum'), '1' => __('Off', 'crum')),
				'default' => '0'
			),
			array(
				'id' => 'custom_portfolio-slug',
				'type' => 'text',
				'title' => __('Custom slug for portfolio items', 'crum'),
				'sub_desc' => __('<p>After change please go to <a href="options-permalink.php">Settings -> Permalinks</a> and press "Save changes" button to Save New permalinks</p>', 'crum'),
				'desc' => __('<p>Please write on latin without spaces</p>', 'crum'),
				'default' => ''
			),
			array(
				'id' => 'top_adress_field',
				'type' => 'textarea',
				'title' => __('Top adress panel', 'crum'),
				'sub_desc' => __('Please do not use single qoute here', 'crum'),
				'desc' => __('This is top adress info block.', 'crum'),
				'validate' => 'html',
				'default' => '+38 032 900 34 45 <span class="delim"></span> Mon. - Fri. 10:00 - 21:00'
			),
			array(
				'id' => 'top_panel_cart',
				'type' =>'button_set',
				'title' => __('Woocommerce cart in top panel', 'crum'),
				'desc' => __('If "On" woocommerce card will be displayed in top panel (If Woocommerce is enabled)', 'crum'),
				'options' => array('1' => __('On','crum'), '0' => __('Off', 'crum')),
				'default' => '0'
			),
			array(
				'id' => 'top_search_show',
				'type' =>'button_set',
				'title' => __('Search field in top panel', 'crum'),
				'options' => array('1' => __('On','crum'), '0' => __('Off', 'crum')),
				'default' => '0'
			),
			array(
				'id' => 'responsive_mode',
				'type' => 'button_set',
				'title' => __('Responsive CSS', 'crum'),
				'desc' => __('Enable or disable site responsive design', 'crum'),
				'options' => array('off' => __('Off', 'crum'), 'on' => __('On','crum')),
				'default' => 'on'
			),
			array(
				'id' => 'lang_shortcode',
				'type' => 'text',
				'title' => __('Language selection shortcode', 'crum'),

				'desc' => __('You can type shortcode of language select tht your translating plugin provide', 'crum'),
				'default'  => '<div class="lang-sel"><a href="#"><img src="'.$assets_folder.'/img/lang-icon.png" alt="GB"><strong>Change your language:</strong>English</a><ul><li><a href="#">English</a></li><li><a href="#">Russian</a></li><li><a href="#">French</a></li></ul></div>',
			),

			array(
				'id' => 'wpml_lang_show',
				'type' => 'button_set',
				'title' => __('WPML language switcher', 'crum'),

				'desc' => __('WPML plugin must be installed. It is not packed with theme. You can find it here: http://wpml.org/', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'
			),
			array(
				'id' => 'custom_js',
				'type' => 'ace_editor',
				'title' => __('Custom JS', 'crum'),
				'desc' => __('Generate your tracking code at Google Analytics Service and insert it here.', 'crum'),
			),
			array(
				'id' => 'custom_css',
				'type' => 'ace_editor',
				'title' => __('Custom CSS', 'crum'),
				'desc' => __('You may add any other styles for your theme to this field.', 'crum'),
				'mode' => 'css',
				'theme' => 'chrome',
			),
			array(
				'id' => 'fixed_menu_show',
				'type' =>'button_set',
				'title' => __('Disable fixed menu?', 'crum'),
				'desc' => __('Enable or disable sticky menu', 'crum'),
				'options' => array('1' => __('Yes','crum'), '0' => __('No', 'crum')),
				'default' => '0'
			),
			array(
				'id' => 'mobile_menu_show',
				'type' =>'button_set',
				'title' => __('Mobile menu button', 'crum'),
				'desc' => __('Hide items udnder button', 'crum'),
				'options' => array('1' => __('Hide', 'crum'), '0' => __('Show', 'crum')),
				'default' => '0'
			),
		),

	);

	$sections[] = array(
		'title' => __('Social accounts', 'crum'),
		'desc' => __('<p class="description">Type links for social accounts</p>', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'awesome-user',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'vb_link',
				'type' => 'text',
				'title' => __('Viber link', 'crum'),
				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://viber.com'
			),
			array(
				'id' => 'vb_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'sk_link',
				'type' => 'text',
				'title' => __('Skype link', 'crum'),
				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://skype.com'
			),
			array(
				'id' => 'sk_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'wa_link',
				'type' => 'text',
				'title' => __('Whatsapp link', 'crum'),
				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://whatsapp.com'
			),
			array(
				'id' => 'wa_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'fb_link',
				'type' => 'text',
				'title' => __('Facebook link', 'crum'),
				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://facebook.com'
			),
			array(
				'id' => 'fb_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'tw_link',
				'type' => 'text',
				'title' => __('Twitter link', 'crum'),
				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://twitter.com'
			),
			array(
				'id' => 'tw_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'in_link',
				'type' => 'text',
				'title' => __('Instagram link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://instagram.com'
			),
			array(
				'id' => 'in_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'vi_link',
				'type' => 'text',
				'title' => __('Vimeo link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://vimeo.com'
			),
			array(
				'id' => 'vi_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'lf_link',
				'type' => 'text',
				'title' => __('Last FM link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://lastfm.com'
			),
			array(
				'id' => 'lf_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'vk_link',
				'type' => 'text',
				'title' => __('Vkontakte link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://vk.com'
			),
			array(
				'id' => 'vk_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'yt_link',
				'type' => 'text',
				'title' => __('YouTube link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://youtube.com'
			),
			array(
				'id' => 'yt_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'de_link',
				'type' => 'text',
				'title' => __('Deviantart link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'https://deviantart.com/'
			),
			array(
				'id' => 'de_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'li_link',
				'type' => 'text',
				'title' => __('LinkedIN link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://linkedin.com'
			),
			array(
				'id' => 'li_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'gp_link',
				'type' => 'text',
				'title' => __('Google + link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'https://accounts.google.com/'
			),
			array(
				'id' => 'gp_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'pi_link',
				'type' => 'text',
				'title' => __('Picasa link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://picasa.com'
			),
			array(
				'id' => 'pi_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'pt_link',
				'type' => 'text',
				'title' => __('Pinterest link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://pinterest.com'
			),
			array(
				'id' => 'pt_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'wp_link',
				'type' => 'text',
				'title' => __('Wordpress link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://wordpress.com'
			),
			array(
				'id' => 'wp_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'db_link',
				'type' => 'text',
				'title' => __('Dropbox link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => 'http://dropbox.com'
			),

			array(
				'id' => 'db_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'fli_link',
				'type' => 'text',
				'title' => __('Flickr link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => ''
			),

			array(
				'id' => 'fli_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),

			array(
				'id' => 'tbr_link',
				'type' => 'text',
				'title' => __('Tumblr link', 'crum'),

				'desc' => __('Paste link to your account', 'crum'),
				'default' => ''
			),

			array(
				'id' => 'tbr_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),

			array(
				'id' => 'xi_link',
				'type' => 'text',
				'title' => __('Xing link', 'crum'),
				'desc' => __('Paste link to your account', 'crum'),
				'default' => ''
			),

			array(
				'id' => 'xi_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),

			array(
				'id' => 'rss_link',
				'type' => 'text',
				'title' => __('RSS', 'crum'),

				'desc' => __('Paste alternative link to Rss', 'crum'),
				'default' => ''
			),
			array(
				'id' => 'rss_show',
				'type' => 'checkbox',
				'title' => __('Show in header', 'crum'),
				'sub_desc' => __('If checked - will be display in header of theme ', 'crum'),

				'default' => '0'// 1 = on | 0 = off
			),
		),
	);

	$sections[] = array(
		'title' => __('Posts list options', 'crum'),
		'desc' => __('<p class="description">Parameters for posts and archives (social share etc)</p>', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'awesome-folder-open-alt',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(



			array(
				'id' => 'sharrre_blog_post',
				'type' => 'button_set',
				'title' => __('Share post block', 'crum'),
				'desc' => __('Small share buttons on standard posts', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'
			),

			array(
				'id' => 'archive_style',
				'type' => 'select',
				'title' => __('Archive page style', 'crum'),
				'sub_desc' => __('', 'crum'),
				'desc' => __('', 'crum'),
				'options' => array(
					'' => __('Default','crum'),
					'grid-2-columns'=>__('Posts grid 2 columns', 'crum'),
					'grid-3-columns'=>__('Posts grid 3 columns', 'crum'),
					'left-image'=>__('Posts with left aligned image', 'crum'),
					'right-image'=>__('Posts with right aligned image','crum')
				),
				'default' => ''
			),

			array(
				'id' => 'thumb_image_crop',
				'type' => 'button_set',
				'title' => __('Crop thumbnails', 'crum'),
				'desc' => __('Post thumbnails image crop', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'
			),

			array(
				'id' => 'post_thumbnails_width',
				'type' => 'text',
				'title' => __('Post thumbnail width (in px)', 'crum'),
				'validate' => 'numeric',
				'default' => '900'
			),
			array(
				'id' => 'post_thumbnails_height',
				'type' => 'text',
				'title' => __('Post  thumbnail height (in px)', 'crum'),
				'validate' => 'numeric',
				'default' => '400',
			),
			array(
				'id' => 'post_header',
				'type' => 'button_set',
				'title' => __('Post info', 'crum'),
				'desc' => __('It is information about the post (time and date of creation, author, comments on the post).', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'//this should be the key as defined above
			),
			array(
				'id' => 'excerpt_length',
				'type' => 'text',
				'title' => __('Excerpt length','crum'),
				'desc' => __('You can set excerpt length, that will be displayed on your blog page.','crum'),
				'validate' => 'numeric',
				'default' => '30'
			),
			array(
				'id' => 'read_more_style',
				'type' => 'button_set',
				'title' => __('Read more button','crum'),
				'desc' => __('Select style of read more button','crum'),
				'options' => array('1' => __('Link with text', 'crum'), '0' => __('Button', 'crum')),
				'default' => '1'
			),



			array(
				'id' => 'info_msc',
				'type' => 'info',
				'desc' => __('<h3 class="description">Inner post page options</h3>', 'crum')
			),


			array(
				'id' => 'post_share_button',
				'type' => 'button_set',
				'title' => __('Social share buttons', 'crum'),
				'desc' => __('With this option you may activate or deactivate social share buttons. and date on inner post page', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'custom_share_code',
				'type' => 'textarea',
				'title' => __('Custom share code', 'crum'),
				'desc' => __('You may add any other social share buttons to this field.', 'crum'),
			),

			array(
				'id' => 'autor_box_disp',
				'type' => 'button_set',
				'title' => __('Author Info', 'crum'),

				'desc' => __('This option enables you to insert information about the author of the post.', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'thumb_inner_disp',
				'type' => 'button_set', //the field type
				'title' => __('Thumbnail on inner page', 'crum'),
				'desc' => __('Display featured image on single post', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'//this should be the key as defined above
			),
			array(
				'id' => 'page_comments_display',
				'type' => 'button_set',
				'title' => __('Comments on pages', 'crum'),
				'desc' => __('Display comments block on pages. If you want to disable comments on particular page, edit that page and uncheck "Allow comments" in "Discussion" section. ', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'
			),



		),
	);

	$sections[] = array(
		'title' => __('Portfolio Options', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'awesome-camera',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(

			array(
				'id' => 'portfolio_page_select',
				'type' => 'select',
				'title' => __('Portfolio page', 'crum'),
				'desc' => __('Please select main portfolio page (for proper urls)', 'crum'),
				'options' => crum_portfolio_list(),
			),

			array(
				'id' => 'folio_breadcrumb_type',
				'type' => 'button_set', //the field type
				'title' => __('Breadcrumb type ', 'crum'),
				'sub_desc' => __('Select which page to display in breadcrumbs on single portfolio page.', 'crum'),
				'options' => array('1' => __('Portfolio page', 'crum'), '0' => __('Portfolio category', 'crum')),
				'default' => '1'//this should be the key as defined above
			),

			array(
				'id' => 'folio_sorting',
				'type' => 'button_set', //the field type
				'title' => __('Panel for items sorting ', 'crum'),
				'sub_desc' => __('Display panel for portfolio isotope items sorting by category', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'//this should be the key as defined above
			),
			array(
				'id' => 'portfolio_single_style',
				'type' => 'button_set', //the field type
				'title' => __('Portfolio text location', 'crum'),
				'sub_desc' => __('Select text layout on inner page', 'crum'),

				'options' =>array(
					'left'=>__('To the right', 'crum'),
					'full'=>__('Full width', 'crum'),
				),
				'default' => 'left',
			),
			array(
				'id' => 'portfolio_single_slider',
				'type' => 'button_set', //the field type
				'title' => __('Portfolio image display', 'crum'),
				'sub_desc' => __('Display attached images of inner portfolio page as:', 'crum'),

				'options' =>array(
					'slider'=>__('Slider','crum'),
					'full'=>__('Items','crum'),
				),
				'default' => 'slider',
			),

			array(
				'id' => 'portfolio_single_category',
				'type' => 'button_set', //the field type
				'title' => __('Limit navigation by category', 'crum'),
				'sub_desc' => __('Limit portfolio navigation links only inside current category', 'crum'),

				'options' =>array(
					'1'=>__('Yes', 'crum'),
					'0'=>__('No', 'crum'),
				),
				'default' => '0',
			),

			array(
				'id' => 'order_folio_posts',
				'type' => 'button_set',
				'title' => __('Order of portfolio sorting', 'crum'),
				'options' => array('ASC'=>__('Ascending', 'crum'),'DESC' => __('Descending', 'crum')),
				'default' => 'ASC'
			),

			array(
				'id' => 'orderby_folio_posts',
				'type' => 'select',
				'title' => __('Sort portfolios by', 'crum'),
				'options' => array('date'=>__('Date of publication', 'crum'),'title' => __('Title', 'crum'),'rand' => __('Display random', 'crum'),'menu_order' => __('By menu order','crum')),
				'default' => 'menu_order'
			),

			array(
				'id' => 'recent_items_disp',
				'type' => 'button_set', //the field type
				'title' => __('Display block under single item', 'crum'),
				'sub_desc' => __('Block with recent items', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'//this should be the key as defined above
			),

			array(
				'id' => 'portfolio_excerpt',
				'type' => 'button_set',
				'title' => __('Display Custom Excerpt '),
				'sub_desc' => __('If enabled custom excerpt will be displayed under portfolio featured images on portfolio Grid pages'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'
			),

			array(
				'id' => 'info_msc',
				'type' => 'info',
				'desc' => __('<h3 class="description">Single portfolio page</h3>', 'crum')
			),

			array(
				'id' => 'portfolio_single_featured',
				'type' => 'button_set', //the field type
				'title' => __('Featured image', 'crum'),
				'sub_desc' => __('', 'crum'),
				'desc' => __('', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'//this should be the key as defined above
			),

			array(
				'id' => 'block_single_folio_item',
				'type' => 'textarea',
				'title' => __('Block shortcode', 'crum'),
				'sub_desc' => __('By default here is displayed Block with recent items [mvb_recent_works  main_title="Recent projects"][/mvb_recent_works]', 'crum'),
				'default' => '[mvb_recent_works  main_title="Recent projects"][/mvb_recent_works]'
			),

		),
	);

	$sections[] = array(
		'title' => __('Styling Options', 'crum'),
		'desc' => __('<p class="description">Style parameters of body and footer</p>', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'awesome-cogs',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(

			array(
				'id' => 'info_msc',
				'type' => 'info',
				'desc' => __('<h3 class="description">Main site colors setup</h3>', 'crum')
			),

			array(
				'id' => 'main_site_color',
				'type' => 'color',
				'title' => __('Main site color', 'crum'),
				'desc' => __('Color of buttons, tabs, links, borders etc.', 'crum'),
				'default' => '#ff6565'
			),
			array(
				'id' => 'secondary_site_color',
				'type' => 'color',
				'title' => __('Secondary site color', 'crum'),
				'desc' => __('Color of inactive or hovered elements', 'crum'),
				'default' => '#36bae2'
			),
			array(
				'id' => 'font_site_color',
				'type' => 'color',
				'title' => __('Color of text', 'crum'),
				'desc' => __('Main text color', 'crum'),
				'default' => ''
			),

			array(
				'id' => 'info_sth',
				'type' => 'info',
				'desc' => __('<h3 class="description">Page title background options</h3>', 'crum')
			),
			array(
				'id' => 'stan_header_show_hide',
				'type' => 'button_set',
				'title' => __('Stunning header display', 'crum'),
				'options' => array('1' => __('Hide', 'crum'), '0' => __('Show', 'crum')),
				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 'stan_header',
				'type' => 'button_set',
				'title' => __('Page title background', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'required' => array('stan_header_show_hide','equals','0'),
				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'stan_header_color',
				'type' => 'color',
				'title' => __('Default background color for header', 'crum'),
				'required' => array('stan_header_show_hide','equals','0'),
				'default' => '#20bce3'
			),
			array(
				'id' => 'stan_header_image',
				'type' => 'media',
				'title' => __('Default background image for header', 'crum'),
				'desc' => __('Upload your own background image or pattern.', 'crum'),
				'required' => array('stan_header_show_hide','equals','0'),
				'default' => array(
					'url' => $assets_folder.'pic/page-header-default.jpg',
				),
			),

			array(
				'id' => 'stan_header_fixed',
				'type' => 'button_set',
				'title' => __('Fix image position', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'required' => array('stan_header_show_hide','equals','0'),
				'default' => '1'// 1 = on | 0 = off
			),

			array(
				'id' => 'stan_header_font_color',
				'type' => 'color',
				'title' => __('Select stunning header font color','crum'),
				'required' => array('stan_header_show_hide','equals','0'),
				'default' => '#fffafa'
			),

			array(
				'id' => 'show_page_title',
				'type' => 'button_set',
				'title' => __('Show page title', 'crum'),
				'options' => array('1' => __('Hide', 'crum'), '0' => __('Show', 'crum')),
				'required' => array('stan_header_show_hide','equals','1'),
				'default' => '1'// 1 = on | 0 = off
			),

			array(
				'id' => 'info_sth',
				'type' => 'info',
				'desc' => __('<h3 class="description">Body styling options</h3>', 'crum')
			),

			array(
				'id' => 'site_boxed',
				'type' => 'button_set',
				'title' => __('Body layout', 'crum'),


				'options' => array('0' => __('Full width','crum'), '1' => __('Boxed', 'crum')),
				'default' => '0',
			),

			array(
				'id' => 'full_width_layout_width',
				'type' => 'text',
				'title' => __('Layout width','crum'),
				'desc' => __('You can set custom width of layout. Leave empty for default width.','crum'),
				'validate' => 'numeric',
				'default' => ''
			),

			array(
				'id' => 'width_units',
				'type' => 'button_set',
				'title' => __('Width units', 'crum'),

				'options' => array('0' => __('px','crum'), '1' => __('%', 'crum')),
				'default' => '0',
			),

			array(
				'id' => 'info_bxd',
				'type' => 'info',
				'desc' => __('<h4 class="description">Content style options</h4>', 'crum')
			),


			//Body wrapper

			array(
				'id' => 'wrapper_bg_color',
				'type' => 'color',
				'title' => __('Content background color', 'crum'),
				'desc' => __('Select background color.', 'crum'),
				'default' => ''
			),
			array(
				'id' => 'wrapper_bg_image',
				'type' => 'media',
				'title' => __('Content background image', 'crum'),
				'desc' => __('Upload your own background image or pattern.', 'crum')
			),
			array(
				'id' => 'wrapper_custom_repeat',
				'type' => 'select',
				'title' => __('Content bg image repeat', 'crum'),
				'desc' => __('Select type background image repeat', 'crum'),
				'options' => array('repeat-y' => __('vertically','crum'),'repeat-x' => __('horizontally', 'crum'),'no-repeat' => __('no-repeat', 'crum'), 'repeat' => __('both vertically and horizontally', 'crum'), ),//Must provide key => value pairs for select options
				'default' => 'repeat'
			),


			array(
				'id' => 'info_bxd',
				'type' => 'info',
				'desc' => __('<h4 class="description">Boxed site body options</h4>', 'crum')
			),

			array(
				'id' => 'body_bg_color',
				'type' => 'color',
				'title' => __('Body background color', 'crum'),
				'desc' => __('Select background color.', 'crum'),
				'default' => ''
			),
			array(
				'id' => 'body_bg_image',
				'type' => 'media',
				'title' => __('Custom background image', 'crum'),

				'desc' => __('Upload your own background image or pattern.', 'crum')
			),
			array(
				'id' => 'body_custom_repeat',
				'type' => 'select',
				'title' => __('Background image repeat', 'crum'),
				'desc' => __('Select type background image repeat', 'crum'),
				'options' => array('repeat-y' => __('vertically','crum'),'repeat-x' => __('horizontally', 'crum'),'no-repeat' => __('no-repeat', 'crum'), 'repeat' => __('both vertically and horizontally', 'crum'), ),//Must provide key => value pairs for select options
				'default' => ''
			),
			array(
				'id' => 'body_bg_fixed',
				'type' => 'button_set',
				'title' => __('Fixed body background', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'// 1 = on | 0 = off
			),

			array(
				'id' => 'info_foot',
				'type' => 'info',
				'desc' => __('<h3 class="description">Footer section options</h3>', 'crum')
			),

			array(
				'id' => 'footer_bg_color',
				'type' => 'color',
				'title' => __('Footer background color', 'crum'),

				'desc' => __('Select footer background color. ', 'crum'),
				'default' => ''
			),
			array(
				'id' => 'footer_font_color',
				'type' => 'color',
				'title' => __('Footer font color', 'crum'),

				'desc' => __('Select footer font color.', 'crum'),
				'default' => ''
			),
			array(
				'id' => 'footer_bg_image',
				'type' => 'media',
				'title' => __('Custom footer background image', 'crum'),

				'desc' => __('Upload your own footer background image or pattern.', 'crum')
			),
			array(
				'id' => 'footer_custom_repeat',
				'type' => 'select',
				'title' => __('Footer background image repeat', 'crum'),

				'desc' => __('Select type background image repeat', 'crum'),
				'options' => array('repeat-y' => __('vertically','crum'),'repeat-x' => __('horizontally', 'crum'),'no-repeat' => __('no-repeat', 'crum'), 'repeat' => __('both vertically and horizontally', 'crum'), ),//Must provide key => value pairs for select options
				'default' => ''
			),
		),
	);

	$sections[] = array(
		'title' => __('Typography options', 'crum'),
		'desc' => __('Select custom font settings for h1-h6 tags and body', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' =>'awesome-font',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
			array(
				'id'          => 'h1_typography',
				'type'        => 'typography',
				'title'       => 'H1 ' . esc_html__( 'Typography', 'crum' ),
				'subtitle'    => esc_html__( 'Select custom typography for', 'crum' ).' h1 '.esc_html__('tag','crum'),
				'google'      => true,
				'font-backup' => true,
				'subsets'     => false,
				'text-align'  => false,
				'units'       => 'px',

			),
			array(
				'id'          => 'h2_typography',
				'type'        => 'typography',
				'title'       => 'H2 ' . esc_html__( 'Typography', 'crum' ),
				'subtitle'    => esc_html__( 'Select custom typography for', 'crum' ).' h2 '.esc_html__('tag','crum'),
				'google'      => true,
				'font-backup' => true,
				'subsets'     => false,
				'text-align'  => false,
				'units'       => 'px',

			),
			array(
				'id'          => 'h3_typography',
				'type'        => 'typography',
				'title'       => 'H3 ' . esc_html__( 'Typography', 'crum' ),
				'subtitle'    => esc_html__( 'Select custom typography for', 'crum' ).' h3 '.esc_html__('tag','crum'),
				'google'      => true,
				'font-backup' => true,
				'subsets'     => false,
				'text-align'  => false,
				'units'       => 'px',

			),
			array(
				'id'          => 'h4_typography',
				'type'        => 'typography',
				'title'       => 'H4 ' . esc_html__( 'Typography', 'crum' ),
				'subtitle'    => esc_html__( 'Select custom typography for', 'crum' ).' h4 '.esc_html__('tag','crum'),
				'google'      => true,
				'font-backup' => true,
				'subsets'     => false,
				'text-align'  => false,
				'units'       => 'px',

			),
			array(
				'id'          => 'h5_typography',
				'type'        => 'typography',
				'title'       => 'H5 ' . esc_html__( 'Typography', 'crum' ),
				'subtitle'    => esc_html__( 'Select custom typography for', 'crum' ).' h5 '.esc_html__('tag','crum'),
				'google'      => true,
				'font-backup' => true,
				'subsets'     => false,
				'text-align'  => false,
				'units'       => 'px',

			),
			array(
				'id'          => 'h6_typography',
				'type'        => 'typography',
				'title'       => 'H6 ' . esc_html__( 'Typography', 'crum' ),
				'subtitle'    => esc_html__( 'Select custom typography for', 'crum' ).' h6 '.esc_html__('tag','crum'),
				'google'      => true,
				'font-backup' => true,
				'subsets'     => false,
				'text-align'  => false,
				'units'       => 'px',

			),
			array(
				'id'          => 'body_typography',
				'type'        => 'typography',
				'title'       => 'Body ' . esc_html__( 'Typography', 'crum' ),
				'subtitle'    => esc_html__( 'Select custom typography for', 'crum' ).' body',
				'google'      => true,
				'font-backup' => true,
				'subsets'     => false,
				'text-align'  => false,
				'units'       => 'px',

			),
		),
	);
	
	$sections[] = array(
		'title' => __('Contact page options', 'crum'),
		'desc' => __('<p class="description">Contact page options</p>', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'awesome-map-marker',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'custom_form_shortcode',
				'type' => 'text',
				'title' => __('Custom Form Shortcode', 'crum'),

				'desc' => __('You can paste your shorcode custom form', 'crum'),
				'default' =>''
			),
			array(
				'id' => 'cont_m_disp',
				'type' => 'button_set',
				'title' => __('Display map on contacts page?', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '1'// 1 = on | 0 = off
			),
			array(
				'id' => 'cont_m_height',
				'type' => 'text',
				'title' => __('Height of Google Map (in px)', 'crum'),

				'default' =>''
			),
			array(
				'id' => 'cont_m_zoom',
				'type' => 'text',
				'title' => __('Zoom Level', 'crum'),
				'default' =>'14'
			),
			array(
				'id' => 'map_address',
				'type' => 'multi_text',
				'title' => __('Address on Google Map ', 'crum'),
				'desc' => __('Fill in your address to be shown on Google map.', 'crum'),
				'default' =>'London, Downing street, 10'
			),
			array(
				'id' => 'map_address_coords',
				'type' => 'multi_text',
				'title' => __('Coordinates on Google Map ', 'crum'),
				'desc' => __('Set address coordinates to be shown on Google map. If you want to display tooltip with address, separate it with a pipe "|"', 'crum'),
			),
			array(
				'id' => 'contacts_form_mail',
				'type' => 'text',
				'title' => __('Form address', 'crum'),
				'desc' => __('Email address for contact form', 'crum'),
				'default' => get_option('admin_email')
			),
			array(
				'id' => 'antispam_question',
				'type' => 'text',
				'title' => __('Type the antispam question', 'crum'),
				'desc' => __('Antispam question will protect you from spamers', 'crum'),
				'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
				'default' => 'How many legs does elephant have? (number) &#x200E;'
			),
			array(
				'id' => 'antispam_answer',
				'type' => 'text',
				'title' => __('Type the answer for antispam question', 'crum'),
				'desc' => __('Antispam question will protect you from spamers', 'crum'),
				'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
				'default' =>'4'
			),
                array(
                        'id'       => 'add_form_text',
                        'type'     => 'textarea',
                        'title'    => __( 'Additional form description', 'crum' ),
                        'desc'     => __( 'Will be displayed under contact form', 'crum' ),
                        'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                        'default'  => ''
                ),
                array(
                        'title'    => __( 'Show social icons ?', 'crum' ),
                        'id'      => 'cont_p_social_icons',
                        'type'    => 'button_set',
                        'options' => array( '1' => __( 'On', 'crum' ), '0' => __( 'Off', 'crum' ) ),
                        'default' => '1'// 1 = on | 0 = off
                ),

        ),
	);

	$sections[] = array(
		'icon' => 'awesome-wrench',
		'title' => __('Layouts Settings', 'crum'),
		'desc' => __('<p class="description">Configure layouts of different pages</p>', 'crum'),
		'fields' => array(
			array(
				'id' => 'pages_layout',
				'type' => 'image_select',
				'title' => __('Single pages layout', 'crum'),
				'sub_desc' => __('Select one type of layout for single pages', 'crum'),

				'options' => array(
					'1col-fixed' => array('title' => __('No sidebars', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/1col.png'),
					'2c-l-fixed' => array('title' => __('Sidebar on left', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cl.png'),
					'2c-r-fixed' => array('title' => __('Sidebar on right','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cr.png'),
					'3c-l-fixed' => array('title' => __('2 left sidebars', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cl.png'),
					'3c-fixed' => array('title' => __('Sidebar on either side', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cc.png'),
					'3c-r-fixed' => array('title' => __('2 right sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cr.png'),
				),//Must provide key => value(array:title|img) pairs for radio options
				'default' => '1col-fixed'
			),
			array(
				'id' => 'archive_layout',
				'type' => 'image_select',
				'title' => __('Archive Pages Layout', 'crum'),
				'sub_desc' => __('Select one type of layout for archive pages', 'crum'),

				'options' => array(
					'1col-fixed' => array('title' => __('No sidebars', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/1col.png'),
					'2c-l-fixed' => array('title' => __('Sidebar on left', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cl.png'),
					'2c-r-fixed' => array('title' => __('Sidebar on right','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cr.png'),
					'3c-l-fixed' => array('title' => __('2 left sidebars', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cl.png'),
					'3c-fixed' => array('title' => __('Sidebar on either side', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cc.png'),
					'3c-r-fixed' => array('title' => __('2 right sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cr.png'),
				),//Must provide key => value(array:title|img) pairs for radio options
				'default' => '2c-l-fixed'
			),
			array(
				'id' => 'single_layout',
				'type' => 'image_select',
				'title' => __('Single posts layout', 'crum'),
				'sub_desc' => __('Select one type of layout for single posts', 'crum'),

				'options' => array(
					'1col-fixed' => array('title' => __('No sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/1col.png'),
					'2c-l-fixed' => array('title' => __('Sidebar on left', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cl.png'),
					'2c-r-fixed' => array('title' => __('Sidebar on right','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cr.png'),
					'3c-l-fixed' => array('title' => __('2 left sidebars', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cl.png'),
					'3c-fixed' => array('title' => __('Sidebar on either side', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cc.png'),
					'3c-r-fixed' => array('title' => __('2 right sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cr.png'),
				),//Must provide key => value(array:title|img) pairs for radio options
				'default' => '2c-l-fixed'
			),
			array(
				'id' => 'search_layout',
				'type' => 'image_select',
				'title' => __('Search results layout', 'crum'),
				'sub_desc' => __('Select one type of layout for search results', 'crum'),

				'options' => array(
					'1col-fixed' => array('title' => __('No sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/1col.png'),
					'2c-l-fixed' => array('title' => __('Sidebar on left', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cl.png'),
					'2c-r-fixed' => array('title' => __('Sidebar on right','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cr.png'),
					'3c-l-fixed' => array('title' => __('2 left sidebars', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cl.png'),
					'3c-fixed' => array('title' => __('Sidebar on either side', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cc.png'),
					'3c-r-fixed' => array('title' => __('2 right sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cr.png'),
				),//Must provide key => value(array:title|img) pairs for radio options
				'default' => '2c-l-fixed'
			),
			array(
				'id' => '404_layout',
				'type' => 'image_select',
				'title' => __('404 Page Layout', 'crum'),
				'sub_desc' => __('Select one of layouts for 404 page', 'crum'),

				'options' => array(
					'1col-fixed' => array('title' => __('No sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/1col.png'),
					'2c-l-fixed' => array('title' => __('Sidebar on left', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cl.png'),
					'2c-r-fixed' => array('title' => __('Sidebar on right','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/2cr.png'),
					'3c-l-fixed' => array('title' => __('2 left sidebars', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cl.png'),
					'3c-fixed' => array('title' => __('Sidebar on either side', 'crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cc.png'),
					'3c-r-fixed' => array('title' => __('2 right sidebars','crum'), 'img' => Redux_OPTIONS_URL.'assets/img/3cr.png'),
				),//Must provide key => value(array:title|img) pairs for radio options
				'default' => '2c-l-fixed'
			)
		),
	);

	$sections[] = array(
		'title' => __('Twitter panel options', 'crum'),
		'desc' => __('<p class="description">More information about api keys and how to get it you can find in that tutorial <a href="http://crumina.net/how-do-i-get-consumer-key-for-sign-in-with-twitter/">http://crumina.net/how-do-i-get-consumer-key-for-sign-in-with-twitter/</a></a></p>', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' =>'awesome-twitter',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(

			array(
				'id' => 't_panel_padding',
				'type' => 'button_set',
				'title' => __('Section padding', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id' => 't_panel_bg_color',
				'type' => 'color',
				'title' => __('Background color for twitter panel', 'crum'),
				'default' => '#20bce3'
			),
			array(
				'id' => 't_panel_bg_image',
				'type' => 'media',
				'title' => __('Background image for twitter panel', 'crum'),
				'desc' => __('Upload your own background image or pattern.', 'crum'),
				'default' => array(
					'url' => $assets_folder.'pic/twitter-row-bg.jpg',
				),
			),


			array(
				'id' => 'footer_tw_disp',
				'type' => 'button_set',
				'title' => __('Display twitter statuses before footer', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'// 1 = on | 0 = off
			),

			array(
				'id' => 'cachetime',
				'type' => 'text',
				'title' => __('Cache Tweets in every:', 'crum'),
				'sub_desc' => __('In minutes', 'crum'),
				'default' => '1'
			),
			array(
				'id' => 'numb_lat_tw',
				'type' => 'text',
				'title' => __('Number of latest tweets display:', 'crum'),

				'default' => '10'
			),
			array(
				'id' => 'username',
				'type' => 'text',
				'title' => __('Username:', 'crum'),
				'default' => 'Envato'
			),

			array(
				'id' => 'twiiter_consumer',
				'type' => 'text',
				'title' => __('Consumer key:', 'crum'),
				'default' => '',

			),
			array(
				'id' => 'twiiter_con_s',
				'type' => 'text',
				'title' => __('Consumer secret:', 'crum'),
				'default' => '',
			),
			array(
				'id' => 'twiiter_acc_t',
				'type' => 'text',
				'title' => __('Access token:', 'crum'),

				'default' => '',
			),
			array(
				'id' => 'twiiter_acc_t_s',
				'type' => 'text',
				'title' => __('Access token secret:', 'crum'),
				'default' => '',
			),
		),
	);

	$sections[] = array(
		'title' => __('Footer section options', 'crum'),
		'desc' => __('<p class="description">Footer section options</p>', 'crum'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => 'awesome-tasks',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(


			array(
				'id' => 'footer_soc_networks',
				'type' => 'button_set',
				'title' => __('Display Social networks links in footer', 'crum'),
				'options' => array('1' => __('On', 'crum'), '0' => __('Off', 'crum')),
				'default' => '0'// 1 = on | 0 = off
			),

			array(
				'id' => 'logo_footer',
				'type' => 'media',
				'title' => __('Logotype in footer', 'crum'),
				'desc' => __('Will be displayed before copyright text', 'crum'),
				'default' => array(
					'url' => $assets_folder.'img/logo-footer.png',
				),
			),

			array(
				'id' => 'copyright_footer',
				'type' => 'text',
				'title' => __('Show copyright', 'crum'),

				'desc' => __('Fill in the copyright text.', 'crum'),
				'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
				'default' => 'My copyright info 2013'
			),

		),
	);

	$sections[] = array(
		'title' => __('Additional settings', 'crum'),
		'desc' => __('<p class="description">New theme features</p>', 'crum'),
		'icon' => 'awesome-gear',
		'fields' => array(
			array(
				'id' => 'shop_sort_panel',
				'type' => 'button_set',
				'title' => __('Type of sorting panel on shop page', 'crum'),
				'options' => array('1' => __('Like on portfolio', 'crum'), '0' => __('Default woocommerce', 'crum')),
				'default' => '0'// 1 = on | 0 = off
			),
			array(
				'id'       => 'map-api',
				'type'     => 'text',
				'title'    => esc_html__( 'Map api key', 'crum' ),
				'desc'     => esc_html__( 'Enter Google Map API key', 'crum' ),
				'subtitle' => wp_kses( __( 'If you don\'t know, how to get api keys, please check <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Tutorial</a>', 'crum' ), array(
					'br' => array(),
					'a'  => array(
						'href'   => array(),
						'target' => ''
					),
					'p'  => array()
				) ),
			),
		),
	);

	$tabs = array();

	if (function_exists('wp_get_theme')){
	$theme_data = wp_get_theme();
	$theme_uri = $theme_data->get('ThemeURI');
	$description = $theme_data->get('Description');
	$author = $theme_data->get('Author');
	$version = $theme_data->get('Version');
	$tags = $theme_data->get('Tags');
	}else{
	$theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()).'style.css');
	$theme_uri = $theme_data['URI'];
	$description = $theme_data['Description'];
	$author = $theme_data['Author'];
	$version = $theme_data['Version'];
	$tags = $theme_data['Tags'];
	}

	$theme_info = '<div class="redux-framework-section-desc">';
	$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'crum').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'crum').$author.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'crum').$version.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'crum').implode(', ', $tags).'</p>';
	$theme_info .= '</div>';

	if(file_exists(dirname(__FILE__).'/README.md')){
	$tabs['theme_docs'] = array(
				'icon' => ReduxFramework::$_url.'assets/img/glyphicons/glyphicons_071_book.png',
				'title' => __('Documentation', 'crum'),
				'content' => file_get_contents(dirname(__FILE__).'/README.md')
				);
	}//if


	// You can append a new section at any time.


    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => 'icon-large',
        'title' => __('Theme Information', 'crum'),
        'content' => $item_info
    );

    if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
        $tabs['docs'] = array(
			'icon' => 'book',
			'icon_class' => 'icon-large',
            'title' => __('Documentation', 'crum'),
            'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
        );
    }

    global $ReduxFramework;
    $ReduxFramework = new ReduxFramework($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);


/*
 *
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(somthing else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}



/**
	Use this function to hide the activation notice telling users about a sample panel.
**/
function removeReduxAdminNotice() {
	delete_option('REDUX_FRAMEWORK_PLUGIN_ACTIVATED_NOTICES');
}
add_action('redux_framework_plugin_admin_notice', 'removeReduxAdminNotice');
