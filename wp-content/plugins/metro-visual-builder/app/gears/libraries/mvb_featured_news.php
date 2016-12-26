<?php

class MVB_Featured_News
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
            'title'           =>      __('Featured post', 'mvb'),
            'description'     =>      __('Add featured post row', 'mvb'),
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
                'col_span'  =>      'lbl_half'
            ),
            'categories' => array(
                'type'      =>      'select_multi',
                'title'     =>      __('Select category', 'mvb'),
                'label'     =>      __('Categories', 'mvb'),
                'callback'  =>      'mvb_get_select_options_multi',
                'options'   =>      'category',
                'col_span'  =>      'lbl_half'
            ),

            'separator' => array('type'     =>  'separator'),

            'no_of_posts' => array(
                'type'      =>      'text',
                'default'   =>      1,
                'label'     =>      __('Number of posts', 'mvb'),
                'col_span'  =>      'lbl_third'
            ),
            'link_label' => array(
                'type'      =>      'text',
                'label'     =>      __('Label for row', 'mvb'),
                'col_span'  =>      'lbl_third'
            ),

            'excerpt_length' => array(
                'type'      =>      'text',
                'default'   =>      20,
                'label'     =>      __('Length of excerpt', 'mvb'),
                'help'      =>      __('Number of words', 'mvb'),
                'col_span'  =>      'lbl_third'
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

        if( $load['link_url'] == '' AND $load['page_id'] > 0 )
        {
            $load['link_url'] = get_page_link($load['page_id']);
        }//endif;



        $args = array(
            'posts_per_page' => $load['no_of_posts'],
            'ignore_sticky_posts' => 'true',
        );

        $categories = explode(',', $load['categories']);

        if( $categories != '' AND !empty($categories) )
        {
              $args['category__in'] = $categories;
        }

        query_posts( $args );

        return $mvb_metro_factory->_load_view('html/public/mvb_featured_news.php', $load);
    }//end render();
}//end class