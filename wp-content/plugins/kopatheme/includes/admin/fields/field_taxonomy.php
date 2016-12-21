<?php

if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Taxonomy dropdown
 *
 * @param string $wrap_start Start Container of the field
 * @param string $wrap_end End Container of the field
 * @param array $settings see Kopa_Admin_Settings::sanitize_option_arguments()
 * @param $value
 *
 * @since 1.0.11
 * @return string - html string.
 */
function kopa_form_field_taxonomy($wrap_start, $wrap_end, $settings, $value) {

    $settings['options'] = array('' => esc_html__('-- Select --', 'kopatheme'));

    if (empty($settings['taxonomy'])) {
        $settings['taxonomy'] = 'category';
    }

    $terms = get_terms($settings['taxonomy']);

    if ($terms) {
        foreach ($terms as $term) {
            $settings['options'][$term->term_id] = $term->name;
        }
    }


    if (isset($settings['multiple']) && $settings['multiple']) {
        $settings['data']['is_multiple'] = 1;
        unset( $settings['options'][''] );
        return kopa_form_field_chosen($wrap_start, $wrap_end, $settings, $value);
    }

    return kopa_form_field_select($wrap_start, $wrap_end, $settings, $value);
}
