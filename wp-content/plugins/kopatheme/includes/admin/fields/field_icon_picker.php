<?php
if (!defined('ABSPATH')) {
    die('-1');
}

function kopa_form_field_icon_picker($wrap_start, $wrap_end, $field, $value) {

    ob_start();

    $name = isset($field['name']) ? $field['name'] : $field['id'];
    $ui_classes = array('kopa-ui-icon-picker');

    if ($value) {
        $ui_classes[] = 'kopa-state-added';
        $button_text = esc_html__('Edit', 'kopa-toolkit');
    } else {
        $button_text = esc_html__('Add', 'kopa-toolkit');
    }

    if (isset($field['size']) && in_array($field['size'], array('xs', 'sm', 'md', 'lg'))) {
        $ui_classes[] = 'kopa-size--' . $field['size'];
    } else {
        $ui_classes[] = 'kopa-size--lg';
    }
    ?>
    <div class="<?php echo esc_attr(implode(' ', $ui_classes)); ?>">
        <i class="<?php echo esc_attr($value); ?>"></i>
        <span class="kopa-ui-icon-picker-action kopa-ui-icon-picker-add"><?php echo esc_html($button_text); ?></span>				
        <input type="hidden" id="<?php echo esc_attr($field['id']); ?>" name="<?php echo $name ?>" value="<?php echo esc_attr($value); ?>">
    </div>
    <?php
    $html = ob_get_clean();

    return $wrap_start . $html . $wrap_end;
}

add_filter('kopa_sanitize_option_icon_picker', 'kopa_sanitize_option_icon_picker_sanitize', 10, 2);

function kopa_sanitize_option_icon_picker_sanitize($icon, $field) {
    return esc_attr($icon);
}
