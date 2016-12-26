<?php

class MVB_Text_Image
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
			'title'           =>      __('Text with image', 'mvb'),
			'description'     =>      __('Add text with image', 'mvb'),
			'identifier'      =>      __CLASS__,
			'icon'            =>      'appbar.paper.png',
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
				's_title'   =>      TRUE,
				'label'     =>      __('Title', 'mvb'),
				'col_span'  =>      'lbl_half'
			),
			'sub_title' => array(
				'type'      =>      'text',
				'label'     =>      __('Subtitle', 'mvb'),
				'col_span'  =>      'lbl_half'
			),
			'image' => array(
				'type' => 'image',
				'label' => __('Image', 'mvb'),
				'col_span' => 'lbl_half'
			),
			'image_height' => array(
				'type' => 'text',
				'label' => __('Select custom height for image','mvb'),
				'col_span' => 'lbl_half',
			),
			'image_width' => array(
				'type' => 'text',
				'label' => __('Select custom width for image','mvb'),
				'col_span' => 'lbl_half',
			),
			'box_align' => array(
				'type'      =>      'select',
				'label'     =>      __('Alignment of image', 'mvb'),
				'default'   =>      0,
				'options'   =>      crum_image_align(),
				'col_span'  =>      'lbl_third',
			),
			'content' => array(
				'type'      =>      'textarea',
				'editor'    =>      TRUE,
				'label'     =>      __('Content', 'mvb'),
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

	public static function admin_render ( $atts = array(), $content = '')
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

	public static function render( $atts, $content = null)
	{
		global $mvb_metro_factory;

		$load = $atts;

		$load['content'] = $content;

		return $mvb_metro_factory->_load_view('html/public/mvb_text_image.php', $load);

	}//end render();
}//end class