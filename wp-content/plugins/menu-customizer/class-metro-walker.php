<?php
/**
 * Plugin Name.
 *
 * @package   Menu_Cusomizer
 * @author    Liondekam <info@crumina.net>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

/**
 * Plugin class.
 *
 *
 * @package Menu_Cusomizer
 * @author  Liondekam <info@crumina.net>
 */

class Crumina_Metro_Nav_Menu extends Walker_Nav_Menu {

    private $crum_menu_data;

    var $item_id = 0;


    public function __construct($id = 0)
    {

        $this->crum_menu_data = get_option("crumina_menu_data");
        $this->item_id = $id;
    }

    function crumina_get_theme_menu_name( $theme_location ) {
        if( ! $theme_location ) return false;

        $theme_locations = get_nav_menu_locations();
        if( ! isset( $theme_locations[$theme_location] ) ) return false;

        $menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );

        if ( function_exists('icl_object_id') ) {
            global $sitepress;
            $current_lang = $sitepress->get_current_language();
            $menu = icl_object_id( $menu_obj->term_id, 'nav_menu', true, $current_lang );
            $menu_obj = wp_get_nav_menu_object( $menu );
            return $menu_obj->slug;
        }

        if( ! $menu_obj ) $menu_obj = false;
        if( ! isset( $menu_obj->slug ) ) return false;

        return $menu_obj->slug;
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
    {
        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }

        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

// add classes to ul sub-menus
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth
        );
        $class_names = implode( ' ', $classes );

        // build html
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

// add main/sub classes to li's and links
//	function start_el( &$output, $item, $depth = 0, $args = array()) {
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0) {
        if ($this->item_id) {
            $slug_menu = $this->item_id;
        } else {
            $slug_menu = ( $this->crumina_get_theme_menu_name( 'main-menu' ) ) ? $this->crumina_get_theme_menu_name( 'main-menu' ) : $this->crumina_get_theme_menu_name( 'primary_navigation' );
        }

        $menu_settings = get_option('crumina_menu_data');

        if (isset($menu_settings[$slug_menu]['dropdown_style']) and $menu_settings[$slug_menu]['dropdown_style']){
            $dropdown_style = $menu_settings[$slug_menu]['dropdown_style'] ? $menu_settings[$slug_menu]['dropdown_style'] : 'classic';
        } else {
            $dropdown_style ='';
        }

        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        $class_names = (is_array($item->classes) && in_array("current_page_item",$item->classes)) ? ' current-menu-item ' : '';

        if ($dropdown_style) {
            $class_names .= 'style-' . $dropdown_style . ' ';
        }

        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >= 2 ? 'sub-sub-menu-item' : '' ),
            ( $depth  % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );


        // build html

        if ($args->has_children) {
            $class_names .= 'has-submenu';
        } else {
            $class_names .= "";
        }

        $item_width = '';

        if (($depth == 0) && (isset($menu_settings[$slug_menu]['item_size']) && $menu_settings[$slug_menu]['item_size'])) {
            $item_size = $menu_settings[$slug_menu]['item_size'] ? $menu_settings[$slug_menu]['item_size']: '';

            if ($item_size) {
                $item_width = 'style = "width:'.$item_size.'px;"';
            }
        }
			$class_current = (is_array($item->classes) && in_array("current_page_parent",$item->classes)) ? ' current-menu-item' : '';

            $output .= $indent . '<li  class="nav-menu-item-' . $item->ID . ' metro-menu-item ' . $depth_class_names . ' ' . $class_names . ''.$class_current.'" ' . $item_width . '>';


        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';


        if ($depth == 0) {

            $menu_id = $item->ID;

            if ($menu_settings){
	            $menu_font_color = (isset($menu_settings[$slug_menu][$menu_id]['font_color'])) ? $menu_settings[$slug_menu][$menu_id]['font_color'] : '';
                $menu_bg_color = (isset($menu_settings[$slug_menu][$menu_id]['bg_color'])) ? $menu_settings[$slug_menu][$menu_id]['bg_color'] : '';
	            $menu_bg_inherit = (isset($menu_settings[$slug_menu][$menu_id]['bg_color_inherit'])) ? $menu_settings[$slug_menu][$menu_id]['bg_color_inherit'] : '';
                $menu_bg_image = (isset($menu_settings[$slug_menu][$menu_id]['bg_image'])) ? $menu_settings[$slug_menu][$menu_id]['bg_image'] : '';
                $menu_icon = (isset($menu_settings[$slug_menu][$menu_id]['icon'])) ? $menu_settings[$slug_menu][$menu_id]['icon'] : '';
                $item_size = (isset($menu_settings[$slug_menu]['item_size'])) ? $menu_settings[$slug_menu]['item_size']: '';
            }

            $tile_styles = '';

	        if ( isset($menu_bg_inherit) && ($menu_bg_inherit == 'inherit')){
		        if ( isset($menu_bg_color) && !($menu_bg_color == '') ) {
			        $data_inherit = 'data-inherit-color="' . $menu_bg_color . '"';
		        } else {
			        $data_inherit = 'data-inherit-color="#FFAA31"';
		        }
	        }else{
		        $data_inherit = '';
	        }


	        if(isset($menu_font_color) && !($menu_font_color == '')){
		        $item_tile_styles = 'color:'.$menu_font_color.'';
	        }else{
		        $item_tile_styles = '';
	        }

            if (isset($item_size) and ($item_size)) {
                $tile_styles .= ' height:'.$item_size.'px;';
            }

            if(isset($menu_bg_color) and ($menu_bg_color)) {
                $tile_styles .= ' background-color:'.$menu_bg_color.';';
            }
            if(isset($menu_bg_image) and ($menu_bg_image)) {
                $tile_styles .= ' background-image: url('.$menu_bg_image.');';
            }
            if(isset($menu_icon)) {
                $menu_icon_show = ' <i class="tile-icon '.$menu_icon.' "></i>';
            } else {
                $menu_icon_show = '';
            };



            $item_output = sprintf( '%1$s<a%2$s>',
                $args->before,
                $attributes
            );

            $item_output .= sprintf( '<span class="menu-tile" style="%1s" %2s>%3s</span><span class="item-title" style="%4s">%5s</span>',
                $tile_styles,
	            $data_inherit,
                $menu_icon_show,
	            $item_tile_styles,
                apply_filters( 'the_title', $item->title, $item->ID )
            );

            $item_output .= sprintf( '</a>%1$s',
                $args->after
            );

        } else {
            $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                $args->before,
                $attributes,
                $args->link_before,
                apply_filters( 'the_title', $item->title, $item->ID ),
                $args->link_after,
                $args->after
            );
        }




        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}