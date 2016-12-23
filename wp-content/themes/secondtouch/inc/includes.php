<?php

/*
 * List of included into theme files
 */
require_once locate_template('/inc/components.php');           // Rewrite theme components
require_once locate_template('/inc/aq_resizer.php');           // Resize images on the fly
require_once locate_template('/inc/cleanup.php');              // Cleanup - remove unused HTML and functions
require_once locate_template('/inc/actions.php');              // Add Framework additional functions

require_once locate_template('/inc/menu.php');


require_once locate_template('/inc/scripts.php');             // Scripts and stylesheets
require_once locate_template('/inc/icons/icons.php');         // Theme icons pack

if(!class_exists('ReduxFramework')){
	require_once locate_template('/options/ReduxCore/framework.php');
}

require_once locate_template('/options/options.php');         // Theme options panel

require_once locate_template('/inc/post-type.php');           //  Pre-defined post types
require_once locate_template('/inc/widgets.php');             // Widgets & Sidebars

require_once locate_template('/inc/shortcodes/shortcodes.php');  // Shortcodes

require_once locate_template('/inc/extensions/hooks.php');


if(is_admin()) {
    require_once locate_template('/inc/custom_metabox/include-boxes.php');  // Custom boxes
    //require_once locate_template('/inc/lib/plugins.php');
}

require_once locate_template('/plugins/tgm-config.php');

//icon manager
require_once locate_template('inc/icon_manager/icon-manager.php');