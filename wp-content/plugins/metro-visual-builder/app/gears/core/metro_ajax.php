<?php

class Metro_Ajax
{
    function __construct()
    {
        add_action('wp_ajax_bshaperAddModule', array($this, 'add_module'));
        add_action('wp_ajax_bshaperEditModule', array($this, 'edit_module'));

        add_action('wp_ajax_getSectionTypes', array($this, 'get_section_types'));
        add_action('wp_ajax_bshaperGetModules', array($this, 'get_modules'));
        add_action('wp_ajax_bshaperShowModule', array($this, 'show_module'));

        add_action('wp_ajax_bshaperSaveMeta', array($this, 'save_meta'));

        add_action('wp_ajax_getRowSettings', array($this, 'get_row_settings'));
        add_action('wp_ajax_getColumnSettings', array($this, 'get_column_settings'));

        add_action( 'save_post', array($this, 'save_meta_post'), 10, 2 );
    }//end __construct

    public function get_section_types()
    {
        global $mvb_metro_factory;
        global $metro_admin_grid;
        global $metro_admin_rows;

        require_once($mvb_metro_factory->app_path.'/html/grids/admin-grid.php');


        $load['metro_admin_grid'] = $metro_admin_grid;
        $load['metro_admin_rows'] = $metro_admin_rows;

        echo $mvb_metro_factory->_load_view('html/section_types.php', $load);
        die();
    }//end get_section_types();

    public function row_settings_fields()
    {
        global $mvb_metro_factory;

        $the_fields = array(
            'bgimage' => array(
                'type'      =>      'image',
                'label'     =>      __('Background Image', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'bgrepeat' => array(
                'type'      =>      'select',
                'label'     =>      __('Background repeat', 'mvb'),
                'default'   =>      '',
                'options'   =>      mvb_get_bgrepeat(),
                'col_span'  =>      'lbl_half',
            ),

            'bgposition' => array(
                'type'      =>      'select',
                'label'     =>      __('Background Attachment', 'mvb'),
                'default'   =>      'normal',
                'options'   =>      crum_get_bgattachment(),
                'col_span'  =>      'lbl_half',
            ),
            'bg_position' => array(
                'type'      =>      'select',
                'label'     =>      __('Background position', 'mvb'),
                'default'   =>      '',
                'options'   =>      mvb_get_bgposition(),
            ),

            'separator' => array('type'     =>  'separator'),

            'bgcolor' => array(
                'type'      =>      'colorpicker',
                'label'     =>      __('Background Color', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'textcolor' => array(
                'type'      =>      'colorpicker',
                'label'     =>      __('Text Color', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS rules', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'animbg' => array(
                'type'      =>      'select',
                'label'     =>      __('Animated background', 'mvb'),
                'default'   =>      0,
                'options'   =>      mvb_yes_no(),
                'col_span'  =>      'lbl_half'
            ),

            'separator0' => array('type'     =>  'separator'),

            'cssclass' => array(
                'type'      =>      'select',
                'label'     =>      __('Row padding', 'mvb'),
                'default'   =>      'medium-padding',
                'options'   =>      crum_get_padding(),
                'col_span'  =>      'lbl_half'
            ),
            'totop' => array(
                'type'      =>      'select',
                'label'     =>      __('Disply back to top button', 'mvb'),
                'default'   =>      0,
                'options'   =>      mvb_yes_no(),
                'col_span'  =>      'lbl_half'
            ),


        );

        return $the_fields;
    }//end row_settings_fields();

    public function get_row_settings()
    {
        global $mvb_metro_form_builder;
        global $mvb_metro_factory;

        $atts = array(
            'bgimage'           =>      $_POST['bgimage'],
            'bgrepeat'          =>      $_POST['bgrepeat'],
            'bgposition'        =>      $_POST['bgposition'],
            'bg_position'        =>      $_POST['bg_position'],
            'bgcolor'           =>      $_POST['bgcolor'],
            'textcolor'         =>      $_POST['textcolor'],
            'padding_top'       =>      $_POST['padding_top'],
            'padding_bottom'    =>      $_POST['padding_bottom'],
            'cssclass'          =>      $_POST['cssclass'],
            'totop'            =>      $_POST['totop'],
            'animbg'            =>      $_POST['animbg'],
            'css'               =>      $_POST['css']
        );

        $form_fields = $this->row_settings_fields();

        $load = shortcode_atts( $mvb_metro_factory->defaults($form_fields), $atts );

        $load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);

        echo $mvb_metro_factory->_load_view('html/options/mvb_form_row_settings.php', $load);

        die();
    }//end get_row_settings();

    public function columns_settings_fields()
    {
        global $mvb_metro_factory;

        $the_fields = array(
            'bgimage' => array(
                'type'      =>      'image',
                'label'     =>      __('Background Image', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'bgrepeat' => array(
                'type'      =>      'select',
                'label'     =>      __('Background repeat', 'mvb'),
                'default'   =>      '',
                'options'   =>      mvb_get_bgrepeat(),
                'col_span'  =>      'lbl_half',
            ),

            'bgposition' => array(
                'type'      =>      'select',
                'label'     =>      __('Background position', 'mvb'),
                'default'   =>      '',
                'options'   =>      mvb_get_bgposition(),
                'col_span'  =>      'lbl_half',
            ),

            'separator' => array('type'     =>  'separator'),

            'bgcolor' => array(
                'type'      =>      'colorpicker',
                'label'     =>      __('Background Color', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'textcolor' => array(
                'type'      =>      'colorpicker',
                'label'     =>      __('Text Color', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'cssclass' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS classes', 'mvb'),
                'help'      =>      __('Separated by space', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'st_no_store' => array('type'     =>  'section_title', 'value'  =>  __('Column Padding', 'mvb')),

            'module_helper' =>  array(
                'type'      =>      'helper',
                'value'     =>      __('Enter a value (eg: 15px, or 2em, etc)', 'mvb')
            ),

            'padding_top' => array(
                'type'      =>      'text',
                'label'     =>      __('Top', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'padding_right' => array(
                'type'      =>      'text',
                'label'     =>      __('Right', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'padding_bottom' => array(
                'type'      =>      'text',
                'label'     =>      __('Bottom', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'padding_left' => array(
                'type'      =>      'text',
                'label'     =>      __('Left', 'mvb'),
                'col_span'  =>      'lbl_forth'
            ),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS rules', 'mvb'),
            ),

            'smallclass' => array(
                'type'      =>      'select',
                'label'     =>      __('Column span for small devices', 'mvb'),
                'default'   =>      '',
                'options'   =>      mvb_get_col_span(),
            ),
        );

        return $the_fields;
    }//end columns_settings_fields();

    public function get_column_settings()
    {
        global $mvb_metro_form_builder;
        global $mvb_metro_factory;

        $atts = array(
            'bgimage'           =>      $_POST['bgimage'],
            'bgrepeat'          =>      $_POST['bgrepeat'],
            'bgposition'        =>      $_POST['bgposition'],
            'bgcolor'           =>      $_POST['bgcolor'],
            'textcolor'         =>      $_POST['textcolor'],
            'padding_top'       =>      $_POST['padding_top'],
            'padding_right'     =>      $_POST['padding_right'],
            'padding_bottom'    =>      $_POST['padding_bottom'],
            'padding_left'      =>      $_POST['padding_left'],
            'cssclass'          =>      $_POST['cssclass'],
            'totop'            =>      $_POST['totop'],
            'animbg'            =>      $_POST['animbg'],
            'smallclass'        =>      $_POST['smallclass'],
            'css'               =>      $_POST['css']
        );

        $form_fields = $this->columns_settings_fields();

        $load = shortcode_atts( $mvb_metro_factory->defaults($form_fields), $atts );

        $load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);

        echo $mvb_metro_factory->_load_view('html/options/mvb_form_column_settings.php', $load);

        die();
    }//end get_column_settings();

    public function add_module()
    {
        $the_class = trim($_POST['module']);
        $sc_action = trim($_POST['sc_action']);
        global $mvb_metro_factory;
        //$mvb_metro_factory->no_of_columns;
        $the_class = new $the_class;

        $vars = array();

        if( method_exists($the_class, $sc_action) )
        {
            $vars = $the_class->$sc_action();
        }
        else
        {
            $sc_vars = $the_class->fields();
            $vars = $mvb_metro_factory->get_sc_posts($sc_vars);
        }

        if( !empty($vars) )
        {
            if( method_exists($the_class, 'the_pill') )
            {
                echo $the_class->the_pill($vars, $the_class->settings());
            }
            else
            {
                echo $mvb_metro_factory->the_pill($vars, $the_class->settings());
            }
        }
        die();
    }//end add_module();

    public function get_modules()
    {
        global $mvb_metro_factory;
        $load['mvb_shortcodes'] = $mvb_metro_factory->loaded_shortcodes;

        $mvb_metro_factory->_load_view('html/modules.php', $load, TRUE);
        die();
    }//end get_section_types();

    public function edit_module()
    {
        $shortcode = stripslashes($_POST['shortcode']);
        global $mvb_metro_factory;
        $mvb_metro_factory->module_action = 'edit';

        echo do_shortcode($shortcode);
        die();
    }//end edit_module();

    public function show_module()
    {
        $_module = trim($_POST['module']);
        $_module = new $_module;
        echo $_module->admin_render( array(), '');

        die();
    }//end show_module()

    function save_meta()
    {
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){ return; }
        if( !isset($_POST['post_id']) OR !is_numeric($_POST['post_id']) OR $_POST['post_id'] < 0 ){ return ; }

        check_ajax_referer( 'bshaper_metro_builder', 'bshaper_metro_nonce' );

        $meta_key = '_bshaper_artist_content';
        $post_id = intval($_POST['post_id']);
        $_html_brute = stripslashes($_POST['the_html']);
        global $mvb_metro_factory;

        $new_meta_value = $this->html_parse($_html_brute);

        $meta_value = get_post_meta( $post_id, $meta_key, true );

        if ( $new_meta_value AND $meta_value == '' )
        {
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );
        }
        elseif ( $new_meta_value AND $new_meta_value != $meta_value )
        {
            update_post_meta( $post_id, $meta_key, $new_meta_value );
        }
        elseif( $new_meta_value == '' AND $meta_value )
        {
            delete_post_meta( $post_id, $meta_key, $meta_value );
        }

        $mvb_metro_factory->show_pill_sc = TRUE;
        echo $mvb_metro_factory->editor_parse_mvb_array($new_meta_value);
        $mvb_metro_factory->show_pill_sc = FALSE;

        die();
    }//end save_meta()

    function column_parser($meta_value)
    {
        global $mvb_metro_factory;
        $mvb_metro_factory->show_pill_sc_column = TRUE;

        if( $meta_value != '' )
        {
            $_html = phpQuery::newDocument($meta_value);

            foreach( $_html->find('.bshaper_module') as $sc )
            {
                $sc = pq($sc);
                $mvb_metro_factory->no_of_columns = $sc->find('.bshaper_sh')->parents('.columns')->attr('data-columns');

                $sc->replaceWith( do_shortcode($sc->find('.bshaper_sh')->html()) );
            }
            $mvb_metro_factory->show_pill_sc_column = FALSE;
            return $_html;
        }
        else
        {
            $mvb_metro_factory->show_pill_sc_column = FALSE;
            return $meta_value;
        }//endif;

    }//end column_parser

    function save_meta_post()
    {
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){ return; }
        if( !isset($_POST['bshaper_the_post_id']) OR !is_numeric($_POST['bshaper_the_post_id']) OR $_POST['bshaper_the_post_id'] < 0 ){ return ; }

        if( !wp_verify_nonce( $_POST['bshaper_metro_nonce'], 'bshaper_metro_builder' ) )
        {
            return;
        }//endif;

        $meta_key = '_bshaper_artist_content';
        $post_id = intval($_POST['post_ID']);
        $meta_value = get_post_meta( $post_id, $meta_key, true );
        $_html_brute = ( isset( $_POST['bshaper_artist_content_html'] ) ? $_POST['bshaper_artist_content_html'] : '' );
        $new_meta_value = '';

        $_html_brute = stripslashes($_html_brute);

        /*********************************/
        //$this->html_parse($_html_brute);
        //die();
        /**************************************/

        if( $_html_brute != '' )
            $new_meta_value = $this->html_parse($_html_brute);

        if ( $new_meta_value AND $meta_value == '' )
        {
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );
        }
        elseif ( $new_meta_value AND $new_meta_value != $meta_value )
        {
            update_post_meta( $post_id, $meta_key, $new_meta_value );
        }
        elseif( $new_meta_value == '' AND $meta_value )
        {
            delete_post_meta( $post_id, $meta_key, $meta_value );
        }

        $this->save_meta_field('_bshaper_activate_metro_builder', $post_id);
    }//end save_meta_post()

    function save_meta_field( $meta_key, $post_id )
    {
        $meta_value = get_post_meta( $post_id, $meta_key, true );
        $new_meta_value = $_POST[$meta_key];

        if ( $meta_value == '' )
        {
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );
        }
        elseif ( $new_meta_value != $meta_value )
        {
            update_post_meta( $post_id, $meta_key, $new_meta_value );
        }
        elseif( $new_meta_value == '' AND $meta_value )
        {
            delete_post_meta( $post_id, $meta_key, $meta_value );
        }//endif;
    }//end save_meta_field()

    function html_parse($_html_brute)
    {
        $_html = phpQuery::newDocument($_html_brute);

        //$_html->find('.bshaper_row');

        $arr = array();
        $row_id = 0;

        foreach( pq('.bshaper_row') as $row )
        {
           //$tds = pq($row)->find('.columns');
           $arr[$row_id]['settings'] = array(
                'bgcolor'           =>          pq($row)->attr('data-mvb-bgcolor'),
                'bgimage'           =>          pq($row)->attr('data-mvb-bgimage'),
                'bgrepeat'          =>          pq($row)->attr('data-mvb-bgrepeat'),
                'bgposition'        =>          pq($row)->attr('data-mvb-bgposition'),
                'bg_position'        =>          pq($row)->attr('data-mvb-bg_position'),
                'textcolor'         =>          pq($row)->attr('data-mvb-textcolor'),
                'padding_top'       =>          pq($row)->attr('data-mvb-paddtop'),
                'padding_bottom'    =>          pq($row)->attr('data-mvb-paddbottom'),
                'cssclass'          =>          pq($row)->attr('data-mvb-cssclass'),
                'totop'            =>          pq($row)->attr('data-mvb-totop'),
                'animbg'            =>          pq($row)->attr('data-mvb-animbg'),
                'css'               =>          pq($row)->attr('data-mvb-css')
           );

           foreach( pq($row)->find('.columns') as $column )
           {
                $no_of_columns = pq($column)->attr('data-columns');

                $shortcodes = pq($column)->find('.bshaper_sh')->text();

                if( !isset($arr[$row_id]['columns']) )
                    $arr[$row_id]['columns'] = array();

                $settings = array(
                      'bgcolor'           =>          pq($column)->attr('data-mvb-bgcolor'),
                      'bgimage'           =>          pq($column)->attr('data-mvb-bgimage'),
                      'bgrepeat'          =>          pq($column)->attr('data-mvb-bgrepeat'),
                      'bgposition'        =>          pq($column)->attr('data-mvb-bgposition'),
                      'textcolor'         =>          pq($column)->attr('data-mvb-textcolor'),
                      'cssclass'          =>          pq($column)->attr('data-mvb-cssclass'),
                      'totop'            =>          pq($column)->attr('data-mvb-totop'),
                      'animbg'            =>          pq($column)->attr('data-mvb-animbg'),
                      'padding_top'       =>          pq($column)->attr('data-mvb-paddtop'),
                      'padding_right'     =>          pq($column)->attr('data-mvb-paddright'),
                      'padding_bottom'    =>          pq($column)->attr('data-mvb-paddbottom'),
                      'padding_left'      =>          pq($column)->attr('data-mvb-paddleft'),
                      'css'               =>          pq($column)->attr('data-mvb-css'),
                      'smallclass'        =>          pq($column)->attr('data-mvb-smallclass')
                 );

                $arr[$row_id]['columns'][] = array(
                    'size'          =>          $no_of_columns,
                    'settings'      =>          $settings,
                    'shortcodes'    =>          $shortcodes,
                );
           }//endforeach;

           $row_id++;
        }//endforeach;

        //echo '<pre>';
        //print_r($arr);

        if( empty($arr) )
            return '';

        return $arr;
    }//end html_parse($_html)
}//end class