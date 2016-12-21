<?php
if (!defined('ABSPATH')) {
    die('-1');
}

function kopa_form_field_radio_image($wrap_start, $wrap_end, $field, $value) {
    ob_start();

    $options = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : false;

    if ($field['options']):
        ?>
        <div class="kp-ui-radio-image-container clearfix">
            <?php
            foreach ($field['options'] as $opt_val => $opt_img) :
                $rdo_classes = ( $opt_val === $value ) ? 'kp-ui-radio-image-label kp-state-checked' : 'kp-ui-radio-image-label';
                ?>
                <label class="<?php echo esc_attr($rdo_classes); ?>">
                    <input class="kp-ui-radio-image-input" type="radio" name="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr($opt_val); ?>" <?php checked($opt_val, $value); ?>>
                    <img  class="kp-ui-radio-image-img" src="<?php echo esc_url($opt_img); ?>" alt="">
                </label>
            <?php endforeach; ?>
        </div>
        <?php
    endif;

    $html = ob_get_clean();
    return $wrap_start . $html . $wrap_end;
}

add_filter('kopa_sanitize_option_radio_image', 'kopa_form_field_radio_image_sanitize', 10, 2);

function kopa_form_field_radio_image_sanitize($value, $field) {
    return $value;
}
