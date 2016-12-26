<?php

class Metro_Factory
{
	public $app_url = '/app/';
	public $app_path = '/app/';

	public $version = '1.0';
	public $module_action = 'add';
	public $default_heading = 'h3';
	public $default_color = '';
	public $loaded_shortcodes = array();
	public $metro_load_scripts = array();
	public $show_pill_sc = FALSE;
	public $show_pill_sc_column = FALSE;
	public $no_of_columns;

	function __construct( $shortcodes )
	{
		$this->app_url = MVB_URL.$this->app_url;
		$this->app_path = MVB_PATH.$this->app_path;


		if ( function_exists( "__autoload" ) )
			spl_autoload_register( "__autoload" );

		spl_autoload_register( array( $this, 'autoload' ) );

		if( is_admin() )
		{
			global $pagenow;

			if( $pagenow == 'post.php' OR $pagenow == 'post-new.php' )
			{
				add_action( 'add_meta_boxes', array( &$this, 'add_the_meta_box' ) );
				add_action( 'admin_enqueue_scripts', array(&$this, 'load_assets'), 10, 1);
			}//endif;
			$this->loaded_shortcodes = $shortcodes;
		}
		else
		{
			add_action( 'wp_enqueue_scripts', array(&$this, 'load_assets'), 10, 1);
			add_action('wp_footer', array(&$this, 'load_scripts'));
		}//endif;

		add_filter('mvb_front_load_view_vars', array(&$this, 'front_load_view_vars'));
		add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) );
	}//end __construct()

	function mce_external_plugins( $plugins ) {

		// global
		global $wp_version;


		// WP 3.9 an above
		if ( version_compare( $wp_version, '3.9', '>=' ) ) {

			// add code
			$plugins['code'] = $this->app_url . 'assets/js/custom/tinymce.code.min.js';

		}

		// return
		return $plugins;

	}

	public function add_shortcode( $shortcode_class, $settings )
	{
		if( !array_key_exists($settings['section'], $this->loaded_shortcodes) )
			return;

		if( isset($settings['section']) )
		{
			$this->loaded_shortcodes[$settings['section']]['modules'][$shortcode_class] = $settings;
		}
		else
		{
			$this->loaded_shortcodes['misc']['modules'][$shortcode_class] = $settings;
		}//endif;
	}//end add_shortcode

	public function add_the_meta_box()
	{
		$mvb_cpts = mvb_get_option('cpts');
		$mvb_activate = mvb_get_option('activate');
		$mvb_show = mvb_get_option('show');

		if( is_array($mvb_cpts) AND !empty($mvb_cpts) AND $mvb_show == 1 AND $mvb_activate == 1 )
		{
			foreach( $mvb_cpts as $cpt )
			{
				add_meta_box(
					'mvb_metro_builder'
					,__( 'Metro Visual Builder', 'mvb' )
					,array( &$this, 'render_meta_box' )
					,$cpt
					,'advanced'
					,'high'
				);
			}//end foreach;
		}//endif;
	}//end add_the_meta_box()

	function render_meta_box()
	{
		$this->render_meta_box_content( );
	}//end render_meta_box()

	public function render_meta_box_content( $meta_value = '' )
	{
		global $post;
		$this->show_pill_sc = TRUE;
		$meta_key = '_bshaper_artist_content';
		$meta_value = get_post_meta( $post->ID, $meta_key, true );
		$activate_metro = get_post_meta( $post->ID, '_bshaper_activate_metro_builder', true );

		if( $activate_metro != '0' )
			$activate_metro = 1;

		$load['_bshaper_activate_metro_builder'] = $activate_metro;

		$meta_value = $this->editor_parse_mvb_array($meta_value);

		$load['meta_value'] = $meta_value;
		$load['post'] = $post;

		$this->_load_view('html/editor.php', $load, TRUE);

		$this->show_pill_sc = FALSE;
	}//end render_meta_box_content()

	public function editor_parse_mvb_array( $arr )
	{
		if( !is_array($arr) OR empty($arr) )
			return '';

		global $metro_admin_grid;
		global $metro_admin_rows;

		require_once($this->app_path.'/html/grids/admin-grid.php');

		$str = '';
		$the_row_class = $this->the_row_class();

		$_row_settings = '<a href="#" class="mvb_row_settings">'.__('row settings', 'mvb').'</a>';

		$_delete_row = '<div class="bshaper_handler"><span class="handler-title"><i class="awesome-move"> </i>' . __('Re-order rows', 'mvb').'</span> '. $_row_settings.'<a href="#" class="mvb_delete_section">'.__('delete section', 'mvb').'</a></div><div class="clear"><!-- --></div>';

		$_add_module = '<div class="mvb_column_actions"><a class="bshaper_add_module" href="#">+ '.__('Add module', 'mvb').'</a>';
		$_add_module .= '<a class="mvb_column_settings" href="#">+ '.__('Column settings', 'mvb').'</a></div>';

		foreach( $arr as $row )
		{
			$str .= '<li class="row bshaper_row" data-mvb-bgcolor="'.$row['settings']['bgcolor'].'" data-mvb-bgimage="'.$row['settings']['bgimage'].'" data-mvb-bgrepeat="'.$row['settings']['bgrepeat'].'" data-mvb-bgposition="'.$row['settings']['bgposition'].'" data-mvb-bg_position="'.$row['settings']['bg_position'].'" data-mvb-textcolor="'.$row['settings']['textcolor'].'" data-mvb-cssclass="'.$row['settings']['cssclass'].'" data-mvb-totop="'.$row['settings']['totop'].'" data-mvb-animbg="'.$row['settings']['animbg'].'" data-mvb-css="'.$row['settings']['css'].'" data-mvb-paddtop="'.$row['settings']['padding_top'].'"  data-mvb-paddbottom="'.$row['settings']['padding_bottom'].'">'.$_delete_row;
			foreach( $row['columns'] as $column )
			{
				$str .= '<div class="'.$metro_admin_grid[$column['size']].' columns" data-columns="'.$column['size'].'" data-mvb-bgcolor="'.$column['settings']['bgcolor'].'" data-mvb-bgimage="'.$column['settings']['bgimage'].'" data-mvb-bgrepeat="'.$column['settings']['bgrepeat'].'" data-mvb-bgposition="'.$column['settings']['bgposition'].'" data-mvb-textcolor="'.$column['settings']['textcolor'].'" data-mvb-cssclass="'.$column['settings']['cssclass'].'" data-mvb-totop="'.$column['settings']['totop'].'" data-mvb-animbg="'.$column['settings']['animbg'].'" data-mvb-css="'.$column['settings']['css'].'" data-mvb-smallclass="'.$column['settings']['smallclass'].'" data-mvb-paddtop="'.$column['settings']['padding_top'].'" data-mvb-paddright="'.$column['settings']['padding_right'].'" data-mvb-paddbottom="'.$column['settings']['padding_bottom'].'" data-mvb-paddleft="'.$column['settings']['padding_left'].'">'.do_shortcode($column['shortcodes']).$_add_module.'</div>';
			}
			$str .= '<div class="clear"><!-- --></div></li>';
		}//endforeach;

		return $str;
	}//end editor_parse_mvb_array();

	function _load_view( $_file, $vars = array(), $do_echo = FALSE )
	{
		$t = array(
			'app_path' => $this->app_path,
			'app_url' => $this->app_url
		);

		extract($t);

		if (!is_admin()) {
			$vars = apply_filters('mvb_front_load_view_vars', $vars);
		}

		if( !empty($vars) )
			extract($vars);

		$the_include_file = $app_path.$_file;

		if( isset($mvb_load_custom) AND $mvb_load_custom != '' )
			$the_include_file = MVB_C_PATH.'/modules/'.$mvb_load_custom.'/'.$_file;

		ob_start();
		include $the_include_file;

		if( !$do_echo )
			return ob_get_clean();

		echo ob_get_clean();
	}// end _load_view()

	public function autoload( $the_class )
	{
		$the_class = strtolower($the_class);
		if ( strpos( $the_class, 'mvb_' ) === 0 ) {

			$c_path = MVB_C_PATH . '/modules/'.$the_class.'/';
			$path = MVB_PATH . 'app/gears/libraries/';

			$the_file =  $path . $the_class. '.php';
			$the_c_file =  $c_path . $the_class. '.php';

			if( file_exists($the_c_file) )
				$the_file = $the_c_file;
			//echo $the_file;
			include_once($the_file);
		}//endif
	}//end autoload

	function defaults( $vars = array() )
	{
		$to_return  = array();

		foreach( $vars as $var_name => $var_options )
		{
			$to_return[$var_name] = isset($var_options['default']) ? $var_options['default'] : '';
		}

		return $to_return;
	}//end defaults();

	function get_sc_posts( $vars = array() )
	{
		$to_return  = array();
		$for_content = '';

		foreach( $vars as $var_name => $var_options )
		{
			if( $var_options['type'] == 'repeater' )
			{
				$for_content .= $this->do_post_repeater_shortcode($var_name, $var_options);
			}
			else
			{
				$to_return[$var_name] = isset($_POST[$var_name]) ? $this->clean_value($var_name, $_POST[$var_name], $var_options['type'] ) : '';
			}//endif;

		}//endforeach;

		if( !isset( $to_return['content'] ) )
			$to_return['content'] = $for_content;


		return $to_return;
	}//end get_sc_posts();

	public function do_post_repeater_shortcode( $var_name, $var_options )
	{
		$str_of_atts = '';
		$sh_name = 'mvb_'.$var_name;


		foreach( $_POST[$var_name] as $panel )
		{
			$str_of_atts .= '['.$sh_name;
			$arr_keys = array();

			foreach( $var_options['fields'] as $field => $field_settings )
			{
				if( $this->store_value($field) )
				{
					$value = isset($panel[$field]) ? $this->clean_value($field, $panel[$field], $field_settings['type']) : '';
					$str_of_atts .= ' '.$field.'="'.$value.'"';
				}//endif;
				$arr_keys[] = $field;
			}//endforeach;

			$str_of_atts .= ' sh_keys="'.implode(",", $arr_keys).'"';

			$str_of_atts .= ']';

			if( array_key_exists('content', $panel) )
			{
				$str_of_atts .= $this->clean_value('content', $panel['content'], 'textarea');
			}

			$str_of_atts .= '[/'.$sh_name.']';
		}//endforeach;

		return $str_of_atts;
	}//end do_post_repeater_shortcode()

	public function do_repeater_shortcode( $content )
	{
		global $__metro_core;
		$__metro_core->sh_tmp_repeater = array();
		$tmp_panels = do_shortcode($content);

		return $__metro_core->sh_tmp_repeater;
	}//end do_repeater_shortcode()

	function clean_value($key = '', $value, $type = 'text', $html = '') {
		if ($type == 'textarea' AND empty($html)) {
			$value = str_replace("\n", '<br class="mvb_break">', $value);
		} elseif ($type == 'textarea') {
			$value = str_replace("\n", '+|+', $value);
		} elseif ($type == 'select_multi') {
			if ( is_array($value)  ) {
				$value = implode( ",", $value );
			}
		}

		if (($type === 'text' || $type === 'textarea') && !in_array($key, array('unique_id'))) {
			$value = mvb_base64_encode($value);
		}

		return $value;
	}//end clean_value()

	public function the_pill( $vars, $settings )
	{
		$str_of_atts = '';
		foreach( $vars as $var_name => $var_value )
		{
			if( $this->store_value($var_name) )
				$str_of_atts .= ' '.$var_name.'="'.addslashes(wp_kses($var_value, array('span' => array('class') ))).'"';
		}//endforeach;

		$load['str_of_atts'] = $str_of_atts;
		$load['settings'] = $settings;
		$load['content'] = mvb_prepare_content_html($vars['content']);
		$load['main_title'] = isset($vars['main_title']) ? $vars['main_title'] : '';
		$load['image'] = isset($vars['image']) ? $vars['image'] : '';


		return $this->_load_view('html/private/the_pill.php', $load);

	}//end the_pill;

	public function store_value( $var_name )
	{
		if( $var_name == 'content' OR strstr($var_name, '_repeater') OR strstr($var_name, '_no_store') OR strstr($var_name, 'separator') )
			return FALSE;

		return TRUE;
	}//end store_value()

	function load_assets()
	{
		if( is_admin() )
		{
			wp_register_script(
				'mvb_support',
				$this->app_url.'assets/js/custom/mvb_support.js',
				array('jquery'),
				false, true
			);

			wp_register_script(
				'mvb_filemanager',
				$this->app_url.'assets/js/custom/mvb_filemanager.js',
				array('jquery'),
				false, true
			);

			wp_enqueue_script('mvb_support');
			wp_enqueue_script('mvb_filemanager');

			wp_register_style('colorpickerz_css', $this->app_url . 'assets/css/colorpicker.css');
			wp_enqueue_style( 'colorpickerz_css');
			wp_enqueue_script( 'colorpickerz', $this->app_url . 'assets/js/colorpicker/colorpicker.js' );

			wp_register_style(
				'mvb_style',
				$this->app_url.'assets/css/mvb_style.css'
			);

			wp_register_style(
				'bs-jquery-ui',
				$this->app_url.'assets/css/jquery-ui/metro/jquery-ui.css'
			);

			wp_register_style('bp_asmSelect_css', $this->app_url . 'assets/js/asmSelect/jquery.asmselect.css');
			wp_enqueue_style( 'bp_asmSelect_css');

			wp_enqueue_script( 'bp_asmSelect', $this->app_url . 'assets/js/asmSelect/jquery.asmselect.js', array('jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-droppable'), 1, TRUE );

			wp_enqueue_script('jquery-ui-dialog');


			wp_enqueue_style('mvb_style');
			wp_enqueue_style('bs-jquery-ui');
		}
		else
		{
			//load_public assets;
			wp_enqueue_script('jquery');
			wp_register_style(
				'metro_builder_shortcodes',
				$this->app_url.'assets/css/mvb_shortcodes.css'
			);

			//wp_enqueue_style('metro_builder_shortcodes');
		}
	}//end load_assets()

	public function load_scripts()
	{
		if( !empty($this->metro_load_scripts) )
		{
			//print_r($this->bshaper_artist_scripts);

			foreach( $this->metro_load_scripts as $sh )
			{
				if( !empty($sh['js']) )
				{
					foreach( $sh['js'] as $identifier => $_path )
					{
						wp_register_script( $identifier, $_path, array(), '1.0', TRUE );
						wp_enqueue_script( $identifier );
					}//endforeach;
				}//endif
			}//endforeach;
		}//endif;
	}//end load_scripts();

	public function queue_scripts($_js_scripts, $key = '-' )
	{
		if( !array_key_exists($key, $this->metro_load_scripts) )
		{
			$this->metro_load_scripts[$key] = $_js_scripts;
		}//endif;
	}// end queue_scripts()

	public function parse_mvb_array( $arr )
	{
		if( empty($arr) )
			return '';

		global $metro_grid_container;
		global $metro_basic_row;
		global $metro_basic_grid;
		global $metro_mobile_grid;

		$str = '<div class="mvb_container'.$metro_grid_container.'">';

		$grid_file = $this->get_grid_config_file();
		include_once($grid_file);


		$the_row_class = $this->the_row_class($metro_basic_row);

		foreach( $arr as $row )
		{
			$row_css = $this->build_mod_css($row['settings']);

			$my_row_css = $this->build_row_css($row['settings']);


			if ($row['settings']['totop']){
				$totop_button = '<a href="#" class="back-to-top"></a>';
			} else {
				$totop_button ='';
			}

			if ($row['settings']['animbg']){
				$row_id = uniqid('particles');
				wp_enqueue_script('particles-js', $this->app_url.'/assets/js/particles/particles.min.js',array(),false,true);
				$str .= '<script>
					jQuery(window).load(function(){
						particlesJS.load("'.  $row_id .'", "'.$this->app_url.'/assets/js/particles/particles.json", function(){
						jQuery("#'.  $row_id .'").find(" > .particles-js-canvas-el").css({position:"absolute",top:"0",height:"auto"});
						jQuery("#'.  $row_id .'").find(" > .row").css({position:"relative",zIndex:"1"});
						});
					});
				</script>';

			} else {
				$row_id = '';
			}

			$str .= '<section class="row-wrapper ' .$row['settings']['cssclass'].'"'.$row_css.'>';
			if ($row['settings']['animbg']){
				$str .= '<div id="'.$row_id .'" style="position:relative; overflow:hidden;">';
			}
			$str .= '<div class="'.$the_row_class.' '.$row['settings']['cssclass'].'" style="'.$my_row_css.'">';

			$str .= $totop_button;
			foreach( $row['columns'] as $column )
			{
				$column_css = $this->build_mod_css($column['settings']);

				$this->no_of_columns = $column['size'];

				$str .= '<div class="'.$this->the_column_class($column['size'], $column['settings']['smallclass'], $metro_basic_grid, $metro_mobile_grid ).' '.$column['settings']['cssclass'].'"><div class="mvb_inner_wrapper"'.$column_css.'>'.do_shortcode($column['shortcodes']).'</div></div>';
			}
			if ($row['settings']['animbg']){
				$str .= '</div>';
			}
			$str .= '</div></section>';
		}//endforeach;

		$str .= '</div>';


		return $str;
	}//end parse_mvb_array();

	public function crum_fixed_image( $settings ){
		$fixed_image = '';

		if( $settings['bgimage'] != '' AND $settings['bgposition'] == 'fixed' ) {

			$fixed_image .= 'background-image: url('.mvb_get_image_url($settings['bgimage'] ).');';

			if( isset($settings['bg_position']) AND $settings['bg_position'] != '' ){
				$fixed_image .= ' background-position: '.$settings['bg_position'].'; ';
			} else {
				$fixed_image .= ' background-position: center;';
			}
		}

		return $fixed_image;
	}

	public function build_row_css( $settings ){
		$css = '';
		if( $settings['css'])
			$css .= $settings['css'];

		return $css;
	}

	public function build_mod_css( $settings )
	{
		$css = '';

		if( $settings['bgimage'] != '' AND $settings['bgposition'] != 'fixed' ){
			$css .= 'background-image: url('.mvb_get_image_url($settings['bgimage'] ).');';
		} else {
			$css .= $fixed_image = $this->crum_fixed_image($settings);
		}
		//$css .= 'background-image: url('.mvb_get_image_url($settings['bgimage'] ).');';

		if( isset($settings['bgrepeat']) AND $settings['bgrepeat'] != '' )
			$css .= 'background-repeat: '.$settings['bgrepeat'].';';

		if( $settings['bgcolor'] != '' )
			$css .= 'background-color: #'.$settings['bgcolor'].';';

		if( $settings['textcolor'])
			$css .= 'color: #'.$settings['textcolor'].';';

		if( isset($settings['padding_top']) AND $settings['padding_top'] != '' )
			$css .= 'padding-top: '.$settings['padding_top'].';';

		if( isset($settings['padding_right']) AND $settings['padding_right'] != '' )
			$css .= 'padding-right: '.$settings['padding_right'].';';

		if( isset($settings['padding_bottom']) AND $settings['padding_bottom'] != '' )
			$css .= 'padding-bottom: '.$settings['padding_bottom'].';';

		if( isset($settings['padding_left']) AND $settings['padding_left'] != '' )
			$css .= 'padding-left: '.$settings['padding_left'].';';

		if( isset($settings['bgposition']) AND $settings['bgposition'] != '' ){
			$css .= ' background-attachment: '.$settings['bgposition'].'; ';
		} else {
			$css .= '';
		}

		if (isset($settings['css']) AND $settings['css'] != '' ){
			$css .= $settings['css'];
		}


		$css = ' style="'.$css.'"';

		return $css;
	}//end build_mod_css()

	public function the_row_class( $grid_row_class = '')
	{

		return $grid_row_class.' mvb_t_row';
	}//end the_row_class()

	public function the_column_class( $size, $smallsize = 12, $metro_basic_grid, $metro_mobile_grid )
	{
		return $metro_basic_grid[$size].' '.$metro_mobile_grid[$smallsize];
	}//end the_column_class;

	public function get_grid_config_file()
	{
		$mvb_grid = mvb_get_option('grid');

		if( $mvb_grid == 'custom' )
			return MVB_C_PATH.'/factory/mvb-custom/grids/custom.php';
		else
			return MVB_PATH.'/app/html/grids/'.$mvb_grid.'.php';
	}//end get_grid_config_file()

	public function front_load_view_vars($vars) {

		if (!is_array($vars)) {
			return $vars;
		}

		return self::decode_vars($vars);
	}

	private static function decode_vars($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if (is_array($value)) {
					$data[$key] = self::decode_vars($value);
				} else {
					if ( ! empty( $value ) && is_string($value) ) {
						$data[$key] = ( false !== strpos( $value, '?=' ) ) ? mvb_base64_decode( $value ) : $value;
					} else {
						$data[$key] = $value;
					}
				}
			}
		}

		return $data;
	}
}//end class