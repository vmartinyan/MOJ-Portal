<?php

/**
 * Abstract Widget Class
 *
 * @author 		Kopatheme
 * @category 	Widgets
 * @package 	KopaFramework/Abstracts
 * @since       1.0.0
 * @extends 	WP_Widget
 * @folked      WC_Widget from Woocommerce
 */
abstract class Kopa_Widget extends WP_Widget {

    /**
     * @access public
     * @var string widget properties
     */
    public $widget_cssclass;
    public $widget_description;
    public $widget_id;
    public $widget_name;
    public $widget_width;
    public $widget_height;

    /**
     * @access public
     * @var array form field arguments
     */
    public $settings;

    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => $this->widget_cssclass,
            'description' => $this->widget_description
        );

        $control_ops = array(
            'width' => $this->widget_width,
            'height' => $this->widget_height,
        );

        parent::__construct($this->widget_id, $this->widget_name, $widget_ops, $control_ops);

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    /**
     * get_cached_widget function.
     *
     * @since 1.0.0
     * @access public
     */
    function get_cached_widget($args) {
        $cache = wp_cache_get($this->widget_id, 'widget');

        if (!is_array($cache))
            $cache = array();

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return true;
        }

        return false;
    }

    /**
     * Cache the widget
     *
     * @since 1.0.0
     * @access public
     */
    public function cache_widget($args, $content) {
        $cache[$args['widget_id']] = $content;

        wp_cache_set($this->widget_id, $cache, 'widget');
    }

    /**
     * Flush the cache
     * @return [type]
     *
     * @since 1.0.0
     * @access public
     */
    public function flush_widget_cache() {
        wp_cache_delete($this->widget_id, 'widget');
    }

    /**
     * update function.
     *
     * @see WP_Widget->update
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     *
     * @since 1.0.0
     * @access public
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        if (!$this->settings) {
            return $instance;
        }

        foreach ($this->settings as $key => $settings) {

            if (!isset($settings['type'])) {
                continue;
            }

            $value = null;

            switch ($settings['type']) {
                case 'text':
                case 'number':
                case 'select':
                case 'gallery':
                case 'icon':
                case 'upload':
                case 'caption':
                    $value = sanitize_text_field($new_instance[$key]);
                    break;
                case 'taxonomy':
                case 'singular':
                    if (isset($settings['multiple']) && $settings['multiple']) {
                        $value = array_map('sanitize_text_field', (array) $new_instance[$key]);
                    } else {
                        $value = sanitize_text_field($new_instance[$key]);
                    }
                    break;
                case 'multiselect':
                    $value = array_map('sanitize_text_field', (array) $new_instance[$key]);
                    break;
                case 'checkbox':
                    if (!empty($new_instance[$key])) {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                    break;
                case 'textarea':
                    if (current_user_can('unfiltered_html')) {
                        $value = $new_instance[$key];
                    } else {
                        $value = stripslashes(wp_filter_post_kses(addslashes($new_instance[$key]))); // wp_filter_post_kses() expects slashed
                    }
                    break;
                case 'repeater':
                    $value = kopa_form_field_repeater_sanitize($new_instance[$key], $settings);
                    break;
                case 'repeater_link':
                    $value = kopa_form_field_repeater_link_sanitize($new_instance[$key], $settings);
                    break;
                case 'chosen':
                    $value = kopa_sanitize_option_chosen_sanitize($new_instance[$key], $settings);
                    break;
                case 'datetime':
                    $value = strtotime($new_instance[$key]);
                    break;
                case 'link':
                    $value = strip_tags($new_instance[$key]);
                    break;
                default:
                    $value = apply_filters('kopa_sanitize_option_' . $settings['type'], $new_instance[$key], $settings);
                    break;
            }

            $instance[$key] = $value;
        }

        $this->flush_widget_cache();

        return $instance;
    }

    /**
     * form function.
     *
     * @see WP_Widget->form
     * @param array $instance
     * @return void
     *
     * @since 1.0.0
     * @access public
     */
    function form($instance) {

        if (!$this->settings) {
            return;
        }

        printf('<div class="%s">', $this->control_options['id_base']);

        $_wrap_start = apply_filters('kopa_set_widget_form_wrap_start', '<div class="kopa-widget-blocks">');
        $_wrap_end = apply_filters('kopa_set_widget_form_wrap_end', '</div>');

        global $kopa_form_fields;

        foreach ($this->settings as $key => $settings) {

            $settings = wp_parse_args($settings, apply_filters('kopa_widget_form_parse_args', array(
								'type'       => '',
								'std'        => '',
								'label'      => '',
								'desc'       => '',
								'step'       => '',
								'min'        => '',
								'max'        => '',
								'options'    => '',
								'size'       => '',
								'rows'       => '',
								'mimes'      => '',
								'css'        => '',
								'format'     => 'Y/m/d H:i',
								'datepicker' => true,
								'timepicker' => true,
								'taxonomy'   => '',
								'post_type'  => ''
            )));

            $settings['value'] = isset($instance[$key]) ? $instance[$key] : $settings['std'];
            $settings['id'] = $this->get_field_id($key);
            $settings['name'] = $this->get_field_name($key);
            $settings['desc'] = !empty($settings['desc']) ? '<small class="kopa-widget-desc">' . $settings['desc'] . '</small>' : '';

            $form_field_callback = false;

            if (in_array($settings['type'], $kopa_form_fields)) {
                $form_field_callback = 'kopa_form_field_' . $settings['type'];
            }

            if ($settings['type'] == 'checkbox') {
                $wrap_start = $_wrap_start;
            } else {
                $wrap_start = $_wrap_start . sprintf('<label for="%s" class="widget-label">%s</label>', $this->get_field_id($key), $settings['label']);
            }

            $wrap_end = wp_kses_post($settings['desc']) . $_wrap_end;

            if ($form_field_callback && function_exists($form_field_callback)) {
                echo call_user_func($form_field_callback, $wrap_start, $wrap_end, $settings, $settings['value']);
            } else {
                echo apply_filters(sprintf('kopa_widget_form_field_%s', $settings['type']), '', $wrap_start, $wrap_end, $settings, $settings['value'], $key);
            }
        }

        echo '</div>';
    }

    /**
     * get default value
     * 	 	 
     * @return array $default
     *
     * @since 1.0.8
     * @access public
     */
    function get_default_instance() {
        $default = array();

        if ($this->settings) {
            foreach ($this->settings as $key => $value) {
                $default[$key] = $value['std'];
            }
        }
        return $default;
    }

    /**
     * Output the html at the start of a widget
     * @since 1.3.0
     * 
     * @param  array $args
     * @return string
     */
    public function widget_start($args, $instance) {

        print $args['before_widget'];

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        if (!empty($title)) {

            print $args['before_title'] . $title . $args['after_title'];
        }

        echo '<div class="widget-content">';
    }

    /**
     * Output the html at the end of a widget
     * @since 1.3.0
     * 
     * @param  array $args
     * @return string
     */
    public function widget_end($args) {
        echo '</div>';

        print $args['after_widget'];
    }

}
