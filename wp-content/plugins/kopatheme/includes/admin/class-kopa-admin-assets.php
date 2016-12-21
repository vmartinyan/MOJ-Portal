<?php

/**
 * Load assets.
 *
 * @author 		Kopatheme
 * @category 	Admin
 * @package 	KopaFramework/Admin
 * @since       1.0.0
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

  if (!class_exists('Kopa_Admin_Assets')) {

  	class Kopa_Admin_Assets {

  		public function __construct() {
  			add_action('admin_enqueue_scripts', array($this, 'load_global_assets'));

  			$is_load_compiled = apply_filters('kopa_is_load_compiled_assets', false);

  			if ($is_load_compiled) {
  				add_action('admin_enqueue_scripts', array($this, 'load_compiled_assets'));
  			} else {
  				add_action('admin_enqueue_scripts', array($this, 'admin_styles'));
  				add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
  			}
  		}

  		public function load_global_assets($hook) {
  			if ($this->is_allow($hook)) {
                // Stylesheet.
  				wp_enqueue_media();
  				wp_enqueue_style('thickbox');
  				wp_enqueue_style('wp-color-picker');

                // Javascript.
  				wp_enqueue_script('thickbox');
  				wp_enqueue_script('wp-color-picker');
  				wp_enqueue_script('jquery-ui-core');
  				wp_enqueue_script('jquery-ui-dialog');
  				wp_enqueue_script('jquery-ui-position');
  				wp_enqueue_script('jquery-ui-droppable');
  				wp_enqueue_script('jquery-ui-draggable');

                // i18n.
  				$this->load_i18n_data();
  			}
  		}

  		public function load_compiled_assets($hook) {
  			if ($this->is_allow($hook)) {
  				$this->load_dependent_field_link( $hook );
  				wp_enqueue_style('kopatheme', KF()->framework_url() . '/assets/compiled/kopatheme.min.css', array(), NULL);
  				wp_enqueue_script('kopatheme', KF()->framework_url() . '/assets/compiled/kopatheme.min.js', array('jquery'), NULL);
  			}
  		}

  		public function load_dependent_field_link( $hook = '' ) {
  			if (!in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
  				wp_enqueue_style('editor-buttons');
  				wp_enqueue_script('wplink');
  				add_action('in_admin_header', 'kopa_link_editor_hidden');
  			}
  		}

  		public function admin_styles($hook) {
  			if ($this->is_allow($hook)) {
  				$ext = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '.css' : '.min.css';

  				wp_enqueue_style('font-awesome', KF()->framework_url() . '/assets/css/font-awesome' . $ext, array(), NULL);
  				wp_enqueue_style('font-themify', KF()->framework_url() . '/assets/css/font-themify' . $ext, array(), NULL);
  				wp_enqueue_style('kopa_admin', KF()->framework_url() . '/assets/css/admin' . $ext, array(), NULL);
  				wp_enqueue_style('kopa_custom_layout', KF()->framework_url() . '/assets/css/custom-layout' . $ext, array(), NULL);
  				wp_enqueue_style('kopa_widget', KF()->framework_url() . '/assets/css/widget' . $ext, array(), NULL);

  				if ($this->is_use_advanced_fields()) {
  					$this->load_dependent_field_link( $hook );
  					wp_enqueue_style('jquery-datetimepicker', KF()->framework_url() . '/assets/css/jquery.datetimepicker' . $ext, array(), NULL);
  					wp_enqueue_style('jquery-chosen', KF()->framework_url() . '/assets/css/jquery.chosen' . $ext, array(), NULL);
  				}
  			}
  		}

  		public function admin_scripts($hook) {

  			if ($this->is_allow($hook)) {

  				$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

  				wp_enqueue_script('kopa_admin', KF()->framework_url() . '/assets/js/admin' . $suffix . '.js', array('jquery'), NULL);
  				wp_enqueue_script('kopa_dynamic_sidebar', KF()->framework_url() . '/assets/js/admin-sidebar' . $suffix . '.js', array('jquery'), NULL);
  				wp_enqueue_script('kopa_dynamic_layout', KF()->framework_url() . '/assets/js/admin-layout' . $suffix . '.js', array('jquery'), NULL);
  				wp_enqueue_script('kopa_custom_layout', KF()->framework_url() . '/assets/js/custom-layout' . $suffix . '.js', array('jquery'), NULL);
  				wp_enqueue_script('kopa_media_uploader', KF()->framework_url() . '/assets/js/media-uploader' . $suffix . '.js', array('jquery'), NULL);                

  				if ($this->is_use_advanced_fields()) {                		
  					wp_enqueue_script('jquery-datetimepicker', KF()->framework_url() . '/assets/js/jquery.datetimepicker' . $suffix . '.js', array('jquery'), NULL);
  					wp_enqueue_script('jquery-chosen', KF()->framework_url() . '/assets/js/jquery-chosen' . $suffix . '.js', array('jquery'), NULL);
  					wp_enqueue_script('jquery-repeatable', KF()->framework_url() . '/assets/js/jquery-repeatable' . $suffix . '.js', array('jquery'), NULL);
  					wp_enqueue_script('kopa_custom_fields', KF()->framework_url() . '/assets/js/admin-fields' . $suffix . '.js', array('jquery'), NULL);
  				}
  			}
  		}

  		public function is_allow($hook) {
  			$screen = get_current_screen();
  			$is_theme_options = in_array($screen->id, kopa_get_screen_ids());
  			$is_other_pages = in_array($hook, apply_filters('kopa_admin_assets_allow_other_pages', array('widgets.php', 'post.php', 'post-new.php', 'edit-tags.php', 'term.php')));

  			return $is_other_pages || $is_theme_options;
  		}

  		public function is_use_advanced_fields() {
  			return apply_filters('kopa_admin_metabox_advanced_field', false);
  		}

  		public function load_i18n_data() {
  			wp_localize_script('jquery', 'kopa_google_fonts', kopa_google_font_property_list_array());
  			wp_localize_script('jquery', 'kopa_google_font_families', kopa_google_font_list());
  			wp_localize_script('jquery', 'kopa_system_fonts', kopa_system_font_list());
  			wp_localize_script('jquery', 'kopa_font_styles', kopa_font_style_options());
  			wp_localize_script('jquery', 'kopa_custom_font_attributes', $this->get_i18n_fonts());
  			wp_localize_script('jquery', 'kopa_admin_l10n', $this->get_i18n_admin());
  			wp_localize_script('jquery', 'kopa_sidebar_attributes_l10n', $this->get_i18n_sidebar());
  			wp_localize_script('jquery', 'kopa_upload_l10n', $this->get_i18n_uploader());
  			wp_localize_script('jquery', 'kopa_advanced_field', $this->get_i18n_fields());
  		}

  		public function get_i18n_fonts() {
  			return array(
  				'name' => array(
  					'type' => 'text',
  					'placeholder' => esc_html__('Enter font name', 'kopatheme'),
  					'required' => false,
  					'value' => esc_html__('Custom font', 'kopatheme'),
  					),
  				'woff' => array(
  					'type' => 'upload',
  					'placeholder' => esc_html__('Upload .woff font file', 'kopatheme'),
  					'mimes' => 'font/woff',
  					),
  				'ttf' => array(
  					'type' => 'upload',
  					'placeholder' => esc_html__('Upload .ttf font file', 'kopatheme'),
  					'mimes' => 'font/truetype',
  					),
  				'eot' => array(
  					'type' => 'upload',
  					'placeholder' => esc_html__('Upload .eot font file', 'kopatheme'),
  					'mimes' => 'font/eot',
  					),
  				'svg' => array(
  					'type' => 'upload',
  					'placeholder' => esc_html__('Upload .svg font file', 'kopatheme'),
  					'mimes' => 'font/svg',
  					),
  				);
  		}

  		public function get_i18n_admin() {
  			return array(
					'upload'         => esc_html__('Upload', 'kopatheme'),
					'remove'         => esc_html__('Remove', 'kopatheme'),
					'confirm_reset'  => esc_html__('Click OK to reset. Any selected settings will be lost!', 'kopatheme'),
					'confirm_import' => esc_html__('Click OK to import. Any selected settings will be lost!', 'kopatheme'),
					'confirm_delete' => esc_html__('Are you sure you want to delete?', 'kopatheme')
  				);
  		}

  		public function get_i18n_sidebar() {
  			return array(
					'ajax_url'          => admin_url('admin-ajax.php'),
					'warning'           => esc_html__('Warning', 'kopatheme'),
					'error'             => esc_html__('Error', 'kopatheme'),
					'info'              => esc_html__('Info', 'kopatheme'),
					'confirm_message'   => esc_html__('Are you sure you want to delete?', 'kopatheme'),
					'close'             => esc_html__('Close', 'kopatheme'),
					'remove'            => esc_html__('Delete', 'kopatheme'),
					'advanced_settings' => esc_html__('Advanced Settings', 'kopatheme'),
					'attributes'        => array(
						'name'          => esc_html__('Name', 'kopatheme'),
						'description'   => esc_html__('Description', 'kopatheme'),
						'before_widget' => esc_html__('Before Widget', 'kopatheme'),
						'after_widget'  => esc_html__('After Widget', 'kopatheme'),
						'before_title'  => esc_html__('Before Title', 'kopatheme'),
						'after_title'   => esc_html__('After Title', 'kopatheme'),
  					)
  				);
  		}

  		public function get_i18n_uploader() {
  			return array(
  				'upload' => '+',
  				'remove' => '&ndash;'
  				);
  		}

  		public function get_i18n_fields() {
  			return array(
					'ajax_url'  => admin_url('admin-ajax.php'),
					'translate' => array(
						'icon_picker' => esc_attr__('Icon Picker', 'kopatheme'),
						'untitle'     => esc_html__('Untitle', 'kopatheme'),
  					),
  				'icon' => array(
  					'shortcodes' => KF()->framework_url() . '/assets/images/shortcodes.png',
  					),
  				'icon_picker' => array(
  					'label' => array(
							'icon_picker' => esc_html__('Icon Picker', 'kopatheme'),
							'add'         => esc_html__('Add', 'kopatheme'),
							'use'         => esc_html__('Use', 'kopatheme'),
							'cancel'      => esc_html__('Cancel', 'kopatheme'),
							'remove'      => esc_html__('Remove', 'kopatheme'),
							'edit'        => esc_html__('Edit', 'kopatheme'),
  						),
  					'fonts' => array(
  						'awesome' => array(
								'name'   => esc_html__('Awesome', 'kopatheme'),
								'file'   => KF()->framework_url() . '/assets/data/font-awesome.json',
								'prefix' => 'fa'
  							),
  						'themify' => array(
								'name'   => esc_html__('Themify', 'kopatheme'),
								'file'   => KF()->framework_url() . '/assets/data/font-themify.json',
								'prefix' => ''
  							)
  						)
  					)
  				);
  		}

  	}

  }

  return new Kopa_Admin_Assets();
