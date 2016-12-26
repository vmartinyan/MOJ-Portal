<?php

class MVB_Recent_Works_Desc
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
            'title'           =>      __('Portfolio items + description', 'mvb'),
            'description'     =>      __('Add portfolio items list', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.newspaper.png',
            'section'         =>      'content',
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

            'content' => array(
                'type'      =>      'textarea',
                'label'     =>      __('Description', 'mvb')
            ),

            'separator' => array('type'     =>  'separator'),

            'link_url' => array(
                'type'      =>      'text',
                'label'     =>      __('Link (URL)', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'page_id' => array(
                'type'      =>      'mvb_dropdown',
                'label'     =>      __('Link to page', 'mvb'),
                'what'      =>      'pages',
                'default'   =>      0,
                'col_span'  =>      'lbl_half',
            ),

            'separator1' => array('type'     =>  'separator'),

            'read_more' => array(
                'type'      =>      'select',
                'label'     =>      __('Display the "read more" link', 'mvb'),
                'default'   =>      1,
                'options'   =>      mvb_yes_no(),
                'col_span'  =>      'lbl_half',
            ),

            'read_more_text' => array(
                'type'      =>      'text',
                'label'     =>      __('"Read more" link text', 'mvb'),
                'default'   =>      __('Read more', 'mvb'),
                'col_span'  =>      'lbl_half',
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
            $load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);
            $load['settings'] = self::settings();
            $load['form_fields'] = $form_fields;
            $load['module_action'] = $mvb_metro_factory->module_action;
            $load['content'] = $content;

            return $mvb_metro_factory->_load_view('html/private/mvb_form.php', $load);
        }//endif

    }//end admin_render();

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

        $load['content'] = $content;

        return $mvb_metro_factory->_load_view('html/public/mvb_recent_works_desc.php', $load);
    }//end render();
}//end class