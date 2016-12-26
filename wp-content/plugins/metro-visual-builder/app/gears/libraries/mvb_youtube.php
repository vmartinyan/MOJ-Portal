<?php

class MVB_Youtube
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
            'title'           =>      __('Youtube video module', 'mvb'),
            'description'     =>      __('Adds a youtube video', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.youtube.png',
            'section'         =>      'video',
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
                'col_span'  =>      'lbl_half'
            ),

            'heading' => array(
                'type'      =>      'select',
                'label'     =>      __('Heading', 'mvb'),
                'default'   =>      $mvb_metro_factory->default_heading,
                'options'   =>      mvb_get_headings(),
                'col_span'  =>      'lbl_forth',
            ),

            'heading_color' => array(
                'type'      =>      'colorpicker',
                'label'     =>      __('Color', 'mvb'),
                'default'   =>      $mvb_metro_factory->default_color,
                'col_span'  =>      'lbl_forth'
            ),

            'content' => array(
                'type'      =>      'text',
                'label'     =>      __('Video URL', 'mvb')
            ),

            'width' => array(
                'type'      =>      'text',
                'label'     =>      __('Width', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'height' => array(
                'type'      =>      'text',
                'label'     =>      __('Height', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS classes', 'mvb'),
                'help'      =>      __('Separated by space', 'mvb'),
            ),

            'module_tip' => array(
                'type'      =>      'helper',
                'value'     =>      __('Leave width and height empty to make the video responsive!', 'mvb'),
            )
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
        $load['allowfullscreen'] = 'true';

        if( $load['width'] == '' )
            $load['width'] = '100%';

        if( $load['height'] == '' )
            $load['height'] = '100%';

        return $mvb_metro_factory->_load_view('html/public/mvb_youtube.php', $load);
    }//end render();

}//end class