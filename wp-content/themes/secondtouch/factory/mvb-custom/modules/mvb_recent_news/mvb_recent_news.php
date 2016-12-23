<?php

class MVB_recent_news
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
            'title'           =>      __('Recent post row', 'mvb'),
            'description'     =>      __('Add recent news list', 'mvb'),
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
            'categories' => array(
                'type'      =>      'select_multi',
                'title'     =>      __('Select category', 'mvb'),
                'label'     =>      __('Categories', 'mvb'),
                'callback'  =>      'mvb_get_select_options_multi',
                'options'   =>      'category',
            ),

            'no_of_posts' => array(
                'type'      =>      'text',
                'default'   =>      4,
                'label'     =>      __('Number of columns', 'mvb'),
                'col_span'  =>      'lbl_fourth'
            ),

            'all_of_posts' => array(
                'type'      =>      'text',
                'default'   =>      8,
                'label'     =>      __('Number of posts', 'mvb'),
                'col_span'  =>      'lbl_fourth'
            ),
            'display_title' => array(
	            'type'      =>      'select',
	            'label'     =>      __('Display title', 'mvb'),
	            'default'   =>      0,
	            'options'   =>      mvb_yes_no(),
	            'col_span'  =>      'lbl_fourth',
            ),
            'display_meta' => array(
	            'type'      =>      'select',
	            'label'     =>      __('Display meta', 'mvb'),
	            'default'   =>      0,
	            'options'   =>      mvb_yes_no(),
	            'col_span'  =>      'lbl_fourth',
            ),
            'display_comments' => array(
	            'type'      =>      'select',
	            'label'     =>      __('Display comments count', 'mvb'),
	            'default'   =>      0,
	            'options'   =>      mvb_yes_no(),
	            'col_span'  =>      'lbl_fourth',
            ),
            'excerpt' => array(
                'type'      =>      'select',
                'label'     =>      __('Display a short excerpt', 'mvb'),
                'default'   =>      0,
                'options'   =>      mvb_yes_no(),
                'col_span'  =>      'lbl_fourth',
            ),
            'enable_autoscroll' => array(
	            'type'     => 'select',
	            'label'    => __( 'Enable auto scroll', 'mvb' ),
	            'default'  => 0,
	            'options'  => mvb_yes_no(),
	            'col_span' => 'lbl_fourth',
            ),
            'autoscroll_speed'  => array(
	            'type'     => 'text',
	            'default'  => 3,
	            'label'    => __( 'Auto scroll speed', 'mvb' ),
	            'help'     => __( 'Rotation interval in seconds', 'mvb' ),
	            'col_span' => 'lbl_fourth'
            ),

            'excerpt_length' => array(
                'type'      =>      'text',
                'default'   =>      25,
                'label'     =>      __('Length of excerpt', 'mvb'),
                'help'      =>      __('Number of words', 'mvb'),
                'col_span'  =>      'lbl_fourth'
            ),

            'display_readmore' => array(
	            'type'      =>      'select',
	            'label'     =>      __('Display read more button', 'mvb'),
	            'default'   =>      0,
	            'options'   =>      mvb_yes_no(),
	            'col_span'  =>      'lbl_fourth',
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
    public static function render( $atts )
    {
        global $mvb_metro_factory;

        $load = $atts;

        $no_of_panels = mvb_base64_decode($load['no_of_posts']);

        if( $no_of_panels == 0 OR $no_of_panels > 12 )
        {
            return;
        }

        $load['column_number'] = mvb_num_to_string(12/$no_of_panels);
        $load['sizes'] = mvb_foundation_columns(ceil($mvb_metro_factory->no_of_columns/$no_of_panels));

	    $load['mvb_load_custom'] = strtolower(__CLASS__);

        return $mvb_metro_factory->_load_view('html/public/mvb_recent_news.php', $load);
    }//end render();
}//end class