<?php

/**
 * Kopa Framework Metabox
 *
 * This module allows you to define custom metabox for built-in or custom post types 
 *
 * @author 	Kopatheme
 * @category 	Metabox
 * @package 	KopaFramework
 * @since       1.0.5
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

if (!class_exists('Kopa_Admin_Meta_Box')) {

    /**
     * Kopa_Admin_Meta_Box Class
     */
    class Kopa_Admin_Meta_Box {

        /**
         * @access private
         * @var array meta boxes settings
         */
        private $settings = array();

        /**
         * Constructor
         *
         * @since 1.0.5
         * @access public
         */
        public function __construct($settings) {
            $this->settings = $settings;

            add_action('admin_enqueue_scripts', array($this, 'meta_box_scripts'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_meta_boxes'), 1, 2);
        }

        /**
         * Metabox scripts
         * 
         * @since 1.0.5
         * @access public
         */
        public function meta_box_scripts() {
            $screen = get_current_screen();
            $metabox = $this->settings;

            if (in_array($screen->id, (array) $metabox['pages'])) {
                wp_enqueue_script('kopa_media_uploader');
            }
        }

        /**
         * Add metaboxes
         *
         * @since 1.0.5
         * @access public
         */
        public function add_meta_boxes() {
            $metabox = $this->settings;

            $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;

            foreach ((array) $metabox['pages'] as $screen) {

                /**
                 * Show in front_page, posts_page
                 * @since 1.3.0
                 */
                if (($screen == 'front_page' && $post_id == get_option('page_on_front')) || ($screen == 'posts_page' && $post_id == get_option('page_for_posts') )) {
                    $screen = 'page';
                }

                add_meta_box($metabox['id'], $metabox['title'], array($this, 'output'), $screen, $metabox['context'], $metabox['priority']);
            }
        }

        /**
         * Check if we're saving, the trigger an action based on the post type
         *
         * @param  int $post_id
         * @param  object $post
         * 
         * @since 1.0.5
         * @access public
         */
        public function save_meta_boxes($post_id, $post) {
            $metabox = $this->settings;

            /* don't save if $_POST is empty */
            if (empty($_POST))
                return $post_id;

            /* don't save during autosave */
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;

            /* verify nonce */
            if (!isset($_POST[$metabox['id'] . '_nonce']) || !wp_verify_nonce($_POST[$metabox['id'] . '_nonce'], $metabox['id']))
                return $post_id;

            /* check permissions */
            if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            } else {
                if (!current_user_can('edit_post', $post_id))
                    return $post_id;
            }

            // Options to update will be stored here
            $update_options = array();

            $fields = array();

            if (!empty($metabox['groups'])) {
                foreach ($metabox['groups'] as $group) {
                    foreach ($group['fields'] as $field) {
                        $fields[] = $field;
                    }
                }
            } else {
                $fields = $metabox['fields'];
            }

            foreach ($fields as $settings) {
                if (!isset($settings['id'])) {
                    continue;
                }

                $type = isset($settings['type']) ? sanitize_title($settings['type']) : '';

                // Get the option name
                $value = null;

                if (isset($_POST[$settings['id']])) {
                    $value = $_POST[$settings['id']];
                }

                // For a value to be submitted to database it must pass through a sanitization filter
                if (has_filter('kopa_sanitize_option_' . $type)) {
                    $value = apply_filters('kopa_sanitize_option_' . $type, $value, $settings);
                }

                if (!is_null($value)) {
                    $update_options[$settings['id']] = $value;
                }
            }

            // Now save the options
            foreach ($update_options as $name => $settings) {
                update_post_meta($post_id, $name, $settings);
            }

            do_action(sprintf('kopa_%s_saved', $metabox['id']), $post_id, $post);

            return true;
        }

        /**
         * Output meta box fields
         *
         * @since 1.0.5
         * @access public
         */
        public function output($post, $args) {

            $metabox = $this->settings;

            $output = '';

            $output .= '<div class="kopa-metabox-wrapper">';

            /* Use nonce for verification */
            $output .= '<input type="hidden" name="' . $metabox['id'] . '_nonce" value="' . wp_create_nonce($metabox['id']) . '">';

            /* Meta box description */
            if (isset($metabox['desc']) && !empty($metabox['desc'])) {
                $allowed_tags = array(
                    'abbr' => array('title' => true),
                    'acronym' => array('title' => true),
                    'code' => true,
                    'em' => true,
                    'strong' => true,
                    'a' => array(
                        'href' => true,
                        'title' => true,
                    ),
                );
                $metabox['desc'] = wp_kses($metabox['desc'], $allowed_tags);
                $output .= '<p>' . $metabox['desc'] . '</p>';
            }

            /**
             * Integrate with versions < 1.1.9
             * @since 1.2.2
             */
            $is_use_advanced_field = apply_filters('kopa_admin_metabox_advanced_field', false);
            $advanced_fields = array('icon', 'color', 'gallery', 'datetime');

            if (empty($metabox['groups']) && !empty($metabox['fields'])) {

                /**
                 * Loop fields
                 */
                foreach ($metabox['fields'] as $index => $settings) {
                    $output.= $this->field_render($post, $settings, $advanced_fields, $is_use_advanced_field, $index);
                }
            } else if (!empty($metabox['groups'])) {
                /**
                 * Render group and fields
                 * @since 1.3.0
                 */
                $nav = '';

                $content = '';

                foreach ($metabox['groups'] as $i => $group) {
                    $name = !empty($group['icon']) ? sprintf('<i class="%s"></i>', $group['icon']) : '';
                    $name .=!empty($group['name']) ? sprintf('<span>%s</span>', $group['name']) : '';

                    $active = $i == 1 ? 'active' : '';
                    $id = $this->settings['id'] . '-group_' . $i;
                    $nav.= sprintf('<li><a href="#%s" class="%s">%s</a></li>', $id, $active, $name);

                    $field_output = '';

                    if (!empty($group['fields'])) {
                        foreach ($group['fields'] as $j => $field) {
                            $field_output .= $this->field_render($post, $field, $advanced_fields, $is_use_advanced_field, $j);
                        }
                    }

                    $content.= sprintf('<div id="%s" class="group_item %s">%s</div>', $id, $active, $field_output);
                }

                $output.='<div class="kopa_group">';
                $output.='<ul class="group_nav">' . $nav . '</ul>';
                $output.='<div class="group_panel">' . $content . '</div>';
                $output.='</div>';
            }

            $output .= '</div>'; // .kopa-metabox-wrapper

            echo $output;
        }

        /**
         * Process field
         * @since 1.3.0
         * 
         * @access public
         * @param WP_Post $post
         * @param array $settings
         * @param array $advanced_fields
         * @param bool $is_use_advanced_field
         * @param int $index Index of the field
         * @return string Field Html
         */
        public function field_render($post, $settings, $advanced_fields, $is_use_advanced_field, $index) {

						$settings         = Kopa_Admin_Settings::sanitize_option_arguments($settings);
						
						$settings['name'] = isset($settings['name']) ? $settings['name'] : $settings['id'];
						
						$wrap_start       = apply_filters('kopa_admin_meta_box_wrap_start', '', $settings, $index);
						$wrap_end         = apply_filters('kopa_admin_meta_box_wrap_end', '', $settings, $index);

            /**
             * Field value
             */
            $value = get_post_meta($post->ID, $settings['id']);

            if (empty($value)) {
                $value = $settings['default'];
            } elseif (isset($value[0])) {
                $value = $value[0];
            } else {
                $value = '';
            }

            $settings['value'] = $value;

            $output = '';

            /**
             * All Form Fields are available in framework
             * @since 1.1.9
             */
            global $kopa_form_fields;

            /**
             * Search field index
             * @since 1.1.9
             */
            $form_field_callback = false;

            if (in_array($settings['type'], $kopa_form_fields)) {
                $form_field_callback = 'kopa_form_field_' . $settings['type'];
            }

            /**
             * Check form field is exist then call function
             * @since 1.1.9
             */
            if ($form_field_callback && function_exists($form_field_callback)) {
                if (in_array($settings['type'], $advanced_fields)) {
                    /**
                     * Check is use advanced field to integrate with versions < 1.1.9
                     * @since 1.2.2
                     */
                    if ($is_use_advanced_field) {
                        $output.=call_user_func($form_field_callback, $wrap_start, $wrap_end, $settings, $settings['value']);
                    } else {
                        $output .= apply_filters('kopa_admin_meta_box_field_' . $settings['type'], '', $wrap_start, $wrap_end, $settings, $settings['value']);
                    }
                } else {
                    $output.=call_user_func($form_field_callback, $wrap_start, $wrap_end, $settings, $settings['value']);
                }
            } else {
                $output .= apply_filters('kopa_admin_meta_box_field_' . $settings['type'], '', $wrap_start, $wrap_end, $settings, $settings['value']);
            }

            return $output;
        }

    }

    // end class Kopa_Admin_Meta_Box
}