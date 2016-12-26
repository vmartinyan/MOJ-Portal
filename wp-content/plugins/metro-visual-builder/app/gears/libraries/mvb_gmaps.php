<?php

class MVB_Gmaps
{
    /**
	 * The modules settings
	 *
	 * @access public
	 * @param none
	 * @return array settings
	 */

    public static function settings()
    {
        return array(
            'title'           =>      __('Google Maps', 'mvb'),
            'description'     =>      __('Adds a Google map', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.map.png',
            'section'         =>      'presentation',
            'color'           =>      'gray'
        );
    }//end settings()

    /**
	 * The shortcodes attributes with the field options
	 *
	 * @access private
	 * @param array $atts
	 * @return shortcode output
	 */

    public static function fields()
    {
        global $mvb_metro_factory;

        $the_fields = array(
            'main_title' => array(
                'type'      =>      'text',
                'label'     =>      __('Title', 'mvb'),
            ),

            'gmaps_address' => array(
                'type'      =>      'repeater',
                'button'    =>      __('Add Address', 'mvb'),
                'label'     =>      __('Address', 'mvb'),
                'lbl_d'     =>      __('for map pointer', 'mvb'),
                'fields'    =>      array(

                    'address' => array(
                        'type'      =>      'text',
                        's_title'   =>      TRUE,
                        'label'     =>      __('Address', 'mvb'),
                    ),
                )//end repeater_fields
            ),

            /*'address' => array(
                'type'      =>      'text',
                'label'     =>      __('Address to display on map', 'mvb'),
            ),*/

            'height' => array(
                'type'      =>      'text',
                'label'     =>      __('Height (in px) ! Only Digits !', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),
            'zoom' => array(
                'type'      =>      'text',
                'label'     =>      __('Map zoom (from 0 to 21+)', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'additional_info' => array(
                'type'      =>      'textarea',
                'editor'    =>      true,
                'label'     =>      __('Additional information', 'mvb'),
            ),

            'separator-effects' => array('type'     =>  'separator'),

            'effects' => array(
                'type'      =>      'select',
                'label'     =>      __('Appear effects', 'mvb'),
                'help'      =>      __('Select one of appear effects for block', 'mvb'),
                'default'   =>      0,
                'options'   =>      crum_appear_effects(),
                'col_span'  =>      'lbl_third'
            ),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS classes', 'mvb'),
                'help'      =>      __('Separated by space', 'mvb'),
                'col_span'  =>      'lbl_third'
            ),

            'unique_id' => array(
                'type'      =>      'text',
                'default'   =>      uniqid('mvbtab_'),
                'label'     =>      __('Unique ID', 'mvb'),
                'help'      =>      __('Must be unique for every tab on the page.', 'mvb'),
                'col_span'  =>      'lbl_third'
            ),

        );

        return $the_fields;
    }//end fields();


    /**
	 * The private code for the shortcode. used in the custom editor
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */

    public static function admin_render( $atts = array(), $content = '' )
    {
        global $mvb_metro_factory;
        global $mvb_metro_form_builder;
        $form_fields = self::fields();

        $load = shortcode_atts( $mvb_metro_factory->defaults($form_fields), $atts );
        $load['content'] = $content;

        if( $mvb_metro_factory->show_pill_sc OR $mvb_metro_factory->show_pill_sc_column )
        {
            if( method_exists(__CLASS__, 'the_pill') )
            {
                return self::the_pill($load, self::settings());
            }
            else
            {
                return $mvb_metro_factory->the_pill($load, self::settings());
            }

        }
        else
        {
            $load['content'] = $mvb_metro_factory->do_repeater_shortcode($content);

            $load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);
            $load['settings'] = self::settings();
            $load['form_fields'] = $form_fields;
            $load['module_action'] = $mvb_metro_factory->module_action;

            return $mvb_metro_factory->_load_view('html/private/mvb_form.php', $load);
        }//endif

    }//end admin_render();


    public static function repeater_admin_render( $atts = array(), $content = '' )
    {
        global $__metro_core;

        if( !isset($atts['sh_keys']) OR trim($atts['sh_keys']) == '' )
            return;

        $keys = explode(",", $atts['sh_keys']);
        $tmp = array();

        foreach( $keys as $key )
        {
            if( $key != 'content' )
                $tmp[$key] = $atts[$key];
        }//endforeach;

        if( in_array('content', $keys) )
            $tmp['content'] = $content;

        $__metro_core->sh_tmp_repeater[] = $tmp;

        //array_push($mvb_metro_factory->sh_tmp_repeater, $tmp);
    }//end repeater_admin_render();

    public static function repeater_render( $atts = array(), $content = '' )
    {
        global $mvb_metro_factory;
        self::repeater_admin_render($atts, $content);
    }//end repeater_render()

    /**
	 * The public code for the shortcode
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */
    public static function render( $atts, $content = null )
    {
        global $mvb_metro_factory;

        $load = $atts;

        $load['r_items'] = $mvb_metro_factory->do_repeater_shortcode($content);


        $_sh_js = array(
            'depends' => array('jquery'),
            'js' => array(
                'gmap3' => get_template_directory_uri().'/assets/js/gmap3.min.js'
            )
        );

        $mvb_metro_factory->queue_scripts($_sh_js, __CLASS__);


        return $mvb_metro_factory->_load_view('html/public/mvb_gmaps.php', $load);
    }//end render();

}//end class