<?php

class MVB_Image {
	/**
	 * The modules settings
	 *
	 * @access public
	 *
	 * @param none
	 *
	 * @return array settings
	 */

	public static function settings() {
		return array(
			'title'       => __( 'Image module', 'mvb' ),
			'description' => __( 'Add an image', 'mvb' ),
			'identifier'  => __CLASS__,
			'icon'        => 'appbar.image.multiple.png',
			'section'     => 'presentation',
			'color'       => 'gray'
		);
	}

	//end settings()

	/**
	 * The shortcodes attributes with the field options
	 *
	 * @access private
	 *
	 * @param array $atts
	 *
	 * @return shortcode output
	 */

	public static function fields() {
		global $mvb_metro_factory;

		$the_fields = array(
			'image'             => array(
				'type'     => 'image',
				'label'    => __( 'Image', 'mvb' ),
				'col_span' => 'lbl_half'
			),
			'image_height'      => array(
				'type'     => 'text',
				'label'    => __( 'Select custom height for image', 'mvb' ),
				'col_span' => 'lbl_half',
			),
			'image_width'       => array(
				'type'     => 'text',
				'label'    => __( 'Select custom width for image', 'mvb' ),
				'col_span' => 'lbl_half',
			),
			'main_title'        => array(
				'type'     => 'text',
				'label'    => __( 'Title', 'mvb' ),
				'col_span' => 'lbl_half'
			),
			'separator-effects' => array('type'     =>  'separator'),


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
			'new_window' => array(
				'type'      =>      'select',
				'label'     =>      __('Open link in new window', 'mvb'),
				'default'   =>      0,
				'options'   =>      mvb_yes_no(),
				'col_span'  =>      'lbl_third',
			),

			'separator-effects' => array( 'type' => 'separator' ),
			'effects'           => array(
				'type'     => 'select',
				'label'    => __( 'Appear effects', 'mvb' ),
				'help'     => __( 'Select one of appear effects for block', 'mvb' ),
				'default'  => 0,
				'options'  => crum_appear_effects(),
				'col_span' => 'lbl_half'
			),
			'css'               => array(
				'type'     => 'text',
				'label'    => __( 'Additional CSS classes', 'mvb' ),
				'help'     => __( 'Separated by space', 'mvb' ),
				'col_span' => 'lbl_half'
			),
		);

		return $the_fields;
	}

	//end fields();


	/**
	 * The private code for the shortcode. used in the custom editor
	 *
	 * @access public
	 *
	 * @param array $atts
	 *
	 * @return shortcode output
	 */

	public static function admin_render( $atts = array(), $content = '' ) {
		global $mvb_metro_factory;
		global $mvb_metro_form_builder;
		$form_fields = self::fields();

		$load            = shortcode_atts( $mvb_metro_factory->defaults( $form_fields ), $atts );
		$load['content'] = $content;

		if ( $mvb_metro_factory->show_pill_sc OR $mvb_metro_factory->show_pill_sc_column ) {
			if ( method_exists( __CLASS__, 'the_pill' ) ) {
				return self::the_pill( $load, self::settings() );
			} else {
				return $mvb_metro_factory->the_pill( $load, self::settings() );
			}

		} else {
			$load['content'] = $mvb_metro_factory->do_repeater_shortcode( $content );

			$load['form_fields_html'] = $mvb_metro_form_builder->build_form( $form_fields, $load );
			$load['settings']         = self::settings();
			$load['form_fields']      = $form_fields;
			$load['module_action']    = $mvb_metro_factory->module_action;

			return $mvb_metro_factory->_load_view( 'html/private/mvb_form.php', $load );
		}
		//endif

	}

	//end admin_render();


	/**
	 * The public code for the shortcode
	 *
	 * @access public
	 *
	 * @param array $atts
	 *
	 * @return shortcode output
	 */
	public static function render( $atts, $content = null ) {
		global $mvb_metro_factory;

		$load = $atts;

		return $mvb_metro_factory->_load_view( 'html/public/mvb_image.php', $load );
	}
	//end render();
}//end class