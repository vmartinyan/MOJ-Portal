<?php
class nictitate_lite_sweet_custom_menu {

    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/

    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    function __construct() {

        // add custom menu fields to menu
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'nictitate_lite_scm_add_custom_nav_fields' ) );

        // save menu custom fields
        add_action( 'wp_update_nav_menu_item', array( $this, 'nictitate_lite_scm_update_custom_nav_fields'), 10, 3 );
        
        // edit menu walker
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'nictitate_lite_scm_edit_walker'), 10, 2 );

    } // end constructor
    
    /**
     * Add custom fields to $item nav object
     * in order to be used in custom Walker
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    function nictitate_lite_scm_add_custom_nav_fields( $menu_item ) {
    
        $menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
        return $menu_item;
        
    }
    
    /**
     * Save menu custom fields
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    function nictitate_lite_scm_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    
        // Check if element is properly sent
        if ( isset( $_REQUEST['menu-item-icon'] ) && is_array( $_REQUEST['menu-item-icon'] ) ) {
            $icon_value = wp_filter_post_kses( $_REQUEST['menu-item-icon'][$menu_item_db_id] );
            update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
        }
        
    }
    
    /**
     * Define new Walker edit
     *
     * @access      public
     * @since       1.0 
     * @return      void
    */
    function nictitate_lite_scm_edit_walker($walker,$menu_id) {
    
        return 'Nictitate_Lite_Walker_Nav_Menu_Edit_Custom';
        
    }

}

// instantiate plugin's class
$GLOBALS['kopa_custom_menu'] = new nictitate_lite_sweet_custom_menu();

require get_template_directory() . '/inc/custom-menu/edit_custom_walker.php';
require get_template_directory() . '/inc/custom-menu/custom_walker.php';
