<?php

class MVB_Tiles
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
            'title'           =>      __('Tiles module', 'mvb'),
            'description'     =>      __('Add tiles to the page', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.paper.png',
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

            'tab' => array(
                'type'      =>      'repeater',
                'button'    =>      __('Add tile', 'mvb'),
                'label'     =>      __('Tile', 'mvb'),
                'lbl_d'     =>      __('Tile title', 'mvb'),
                'fields'    =>      array(

                    'image' => array(
                        'type'      =>      'image',
                        'label'     =>      __('Image', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),
                    'flip_image' => array(
                        'type'      =>      'image',
                        'label'     =>      __('Flip Image', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),

                    'disable_flip' => array(
                        'type'      =>      'select',
                        'label'     =>      __('Disable flip', 'mvb'),
                        'help'      =>      __('Turn off flip effect', 'mvb'),
                        'default'   =>      0,
                        'options'   =>      mvb_yes_no(),
                        'col_span'  =>      'lbl_half'
                    ),
                    'separator0' => array('type'     =>  'separator'),

                    'tab_title' => array(
                        'type'      =>      'text',
                        's_title'   =>      TRUE,
                        'label'     =>      __('Tile title', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),
                    'color' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Color', 'mvb'),
                        'default'   =>      $mvb_metro_factory->default_color,
                        'col_span'  =>      'lbl_forth'
                    ),
                    'color_hover' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Hover color', 'mvb'),
                        'col_span'  =>      'lbl_forth'
                    ),

                    'separator' => array('type'     =>  'separator'),

                    'icon' => array(
                        'type'      =>      'icon',
                        'label'     =>      __('Icon', 'mvb'),
                        'col_span'  =>      'lbl_third',
                    ),

                    'link_url' => array(
                        'type'      =>      'text',
                        'label'     =>      __('Link (URL)', 'mvb'),
                        'col_span'  =>      'lbl_third'
                    ),

                    'page_id' => array(
                        'type'      =>      'mvb_dropdown',
                        'label'     =>      __('Link to page', 'mvb'),
                        'what'      =>      'pages',
                        'default'   =>      0,
                        'col_span'  =>      'lbl_third',
                    ),

                    'tile_content' => array(
                        'type'      =>      'textarea',
                        'label'     =>      __('Backflip content', 'mvb'),
                    ),
                )//end repeater_fields
            ),

            'separator-effects' => array('type'     =>  'separator'),

            'effects' => array(
                'type'      =>      'select',
                'label'     =>      __('Appear effects', 'mvb'),
                'help'      =>      __('Select one of appear effects for block', 'mvb'),
                'default'   =>      0,
                'options'   =>      crum_appear_effects(),
                'col_span'  =>      'lbl_half'
            ),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS classes', 'mvb'),
                'help'      =>      __('Separated by space', 'mvb'),
                'col_span'  =>      'lbl_half'
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

    /**
	 * The private code for the repeater shortcode. used in the custom editor
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */

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


        return $mvb_metro_factory->_load_view('html/public/mvb_tiles.php', $load);
    }//end render();
}//end class