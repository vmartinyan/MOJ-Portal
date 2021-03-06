<?php

function top_menu_fallback() {
    echo '<div class="no-menu-box">';
    // Translators 1: Link to Menus, 2: Link to Customize
    printf( __( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'crum' ),
        sprintf(  __( '<a href="%s">Menus</a>', 'crum' ),
            get_admin_url( get_current_blog_id(), 'nav-menus.php' )
        ),
        sprintf(  __( '<a href="%s">Customize</a>', 'crum' ),
            get_admin_url( get_current_blog_id(), 'customize.php' )
        )
    );
    echo '</div>';
}

/*
* Custom Walker to remove all the wp_nav_menu junk
*/
class crum_clean_walker extends Walker_Nav_Menu
{
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $current_indicators = array('current-menu-parent', 'current_page_item', 'current_page_parent');

        $newClasses = array();

        foreach($classes as $el){
            //check if it's indicating the current page, otherwise we don't need the class
            if (in_array($el, $current_indicators)){
                array_push($newClasses, $el);
            }
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $newClasses), $item ) );
        if($class_names!='') $class_names = ' class="'. esc_attr( $class_names ) . '"';


        $output .= $indent . '<li' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        if($depth != 0)
        {
            //children stuff
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}