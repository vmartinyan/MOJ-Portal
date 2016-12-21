<?php
if (!defined('ABSPATH')) {
    die('-1');
}

function kopa_form_field_repeater($wrap_start, $wrap_end, $field, $value) {

    $field_id = $field['id'];
    $field_id = str_replace('[', '-', $field_id);
    $field_id = str_replace(']', '', $field_id);

    $field_name = $field['name'];

    ob_start();
    ?>  

    <div class="kopa-ui-repeater" data-id="#kopa-template-<?php echo esc_attr($field_id); ?>">

        <div class="kopa-ui-repeater-container">
            <?php
            if ($value && is_array($value)) {
                for ($i = 0; $i < count($value); $i++) {
                    kopa_form_field_repeater_get_single($value[$i], $i, $field_name);
                }
            }
            ?>				
        </div>

        <p class="kopa-repeater-toolbar">
            <input type="button" class="button button-secondary kopa-repeater-add" value="<?php esc_attr_e('Add new option', 'kopatheme'); ?>"/>
        </p>

    </div>

    <script type="text/template" id="kopa-template-<?php echo esc_attr($field_id); ?>">
    <?php kopa_form_field_repeater_get_single(array('key' => esc_html__('Untitle', 'kopatheme')), '{?}', $field_name); ?>
    </script>

    <?php
    $html = ob_get_clean();

    return $wrap_start . $html . $wrap_end;
}

add_filter('kopa_sanitize_option_repeater', 'kopa_form_field_repeater_sanitize', 10, 2);

function kopa_form_field_repeater_sanitize($items, $field) {

    if ($items && is_array($items)) {

        $new_items = array();

        foreach ($items as $item) {

            $item = wp_parse_args($item, kopa_form_field_repeater_get_defaults());
            $key = $item['key'] ? esc_html($item['key']) : esc_html__('Untitle', 'kopatheme');
            $val = wp_kses_post($item['value']);

            if ($key) {
                $new_items[] = array('key' => $key, 'value' => $val);
            }
        }

        if (count($new_items)) {
            $items = $new_items;
        }
    } else {
        $items = array();
    }

    return $items;
}

function kopa_form_field_repeater_get_single($value, $i, $id) {
    $defaults = kopa_form_field_repeater_get_defaults();
    $value = wp_parse_args($value, $defaults);
    extract($value);

    if ($key):
        ?>
        <div class="kopa-repeater-group">

            <label>
                <span><?php echo esc_attr(strip_tags($key)); ?></span>					
                <i class="kopa-repeater-edit dashicons dashicons-edit"></i>
                <i class="kopa-repeater-delete dashicons dashicons-trash"></i>
            </label>

            <div class="kopa-repeater-item-content">
                <p>
                    <span><?php esc_html_e('Name:', 'kopatheme'); ?></span>
                    <input class="kopa-repeater-input-key" type="text" value="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($id); ?>[<?php echo esc_attr($i); ?>][key]">
                </p>

                <p>
                    <span><?php esc_html_e('Content:', 'kopatheme'); ?></span>
                    <input class="kopa-repeater-input-value" type="text" value="<?php echo esc_attr($value); ?>" name="<?php echo esc_attr($id); ?>[<?php echo esc_attr($i); ?>][value]">
                </p>										
            </div>

        </div>			
        <?php
    endif;
}

function kopa_form_field_repeater_get_defaults() {
    return array('key' => '', 'value' => '');
}
