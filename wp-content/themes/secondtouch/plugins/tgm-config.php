<?php

	define( 'THEMENAME', 'crum' );

	require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
	add_action( 'tgmpa_register', 'crumina_register_required_plugins' );

	function crumina_register_required_plugins() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'     				=> 'SMK Sidebar Generator', // The plugin name
				'slug'     				=> 'smk-sidebar-generator', // The plugin slug (typically the folder name)
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			),
			array(
				'name'     				=> 'Crumina Menu Customizer', // The plugin name
				'slug'     				=> 'menu-customizer', // The plugin slug (typically the folder name)
				'source'   				=> 'http://up.crumina.net/plugins/menu-customizer.zip', // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.5.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented. If the plugin version is higher than the plugin version installed , the user will be notified to update the plugin
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     				=> 'Crumina page slider', // The plugin name
				'slug'     				=> 'crumina-page-slider', // The plugin slug (typically the folder name)
				'source'   				=> 'http://up.crumina.net/plugins/Secondtouch/crumina-page-slider.zip', // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.4.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented. If the plugin version is higher than the plugin version installed , the user will be notified to update the plugin
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     				=> 'Metro Visual Builder', // The plugin name
				'slug'     				=> 'metro-visual-builder', // The plugin slug (typically the folder name)
				'source'   				=> 'http://up.crumina.net/plugins/metro-visual-builder.zip', // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.9.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented. If the plugin version is higher than the plugin version installed , the user will be notified to update the plugin
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     				=> 'Price Table', // The plugin name
				'slug'     				=> 'pricetable', // The plugin slug (typically the folder name)
				'source'   				=> 'http://up.crumina.net/plugins/Secondtouch/pricetable.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),

			array(
				'name'     				=> 'LayerSlider WP', // The plugin name
				'slug'     				=> 'LayerSlider', // The plugin slug (typically the folder name)
				'source'   				=> 'http://up.crumina.net/plugins/layersliderwp.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '6.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented. If the plugin version is higher than the plugin version installed , the user will be notified to update the plugin
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'     				=> 'Installer Plugin', // The plugin name
				'slug'     				=> 'easy_installer', // The plugin slug (typically the folder name)
				'source'   				=> 'http://up.crumina.net/plugins/Secondtouch/easy_installer.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented. If the plugin version is higher than the plugin version installed , the user will be notified to update the plugin
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
		);

	// Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'crum';

		$config = array(
			'id'           => 'crum',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		);

		tgmpa( $plugins, $config );
 
}
       



?>