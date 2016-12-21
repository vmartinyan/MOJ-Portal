<?php
/**
 * Link Field
 */
if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Field Link
 *
 * @param string $wrap_start Start Container of the field
 * @param string $wrap_end End Container of the field
 * @param array $settings see Kopa_Admin_Settings::sanitize_option_arguments()
 * @param $value
 *
 * @since 1.3.0
 * @return string - html string.
 */
function kopa_form_field_link($wrap_start, $wrap_end, $settings, $value) {

    ob_start();

    echo $wrap_start;

    /**
     * @var array Attributes
     */
    $attrs = array();
    
    $attrs[] = 'id="' . $settings['id'] . '"';
    $attrs[] = 'name="' . $settings['name'] . '"';

    $attrs[] = 'data-type="' . $settings['type'] . '"';
    
    $link = kopa_build_link($value);

    $json_value = htmlentities(json_encode($link), ENT_QUOTES, 'utf-8');

    $input_value = htmlentities($value, ENT_QUOTES, 'utf-8');

    $uniqid = uniqid();
    ?>
    <div class="kopa-field kopa-field-link" id="kopa-link-<?php echo esc_attr($uniqid) ?>">

        <?php printf('<input type="hidden" class="kopa_value" value="%1$s" data-json="%2$s" %3$s/>', $input_value, $json_value, implode(' ', $attrs)); ?>

        <a href="#" class="button link_button"><?php echo esc_attr__('Select URL', 'kopatheme') ?></a> 
        <span class="group_title">
            <span class="link_label_title link_label"><?php echo esc_attr__('Link Text:', 'kopatheme') ?></span> 
            <span class="title-label"><?php echo isset($link['title']) ? esc_attr($link['title']) : ''; ?></span> 
        </span>
        <span class="group_url">
            <span class="link_label"><?php echo esc_attr__('URL:', 'kopatheme') ?></span> 
            <span class="url-label">
                <?php
                echo isset($link['href']) ? esc_url($link['href']) : '';
                echo isset($link['target']) ? ' ' . esc_attr($link['target']) : '';
                ?> 
            </span>
        </span>
    </div>
    <?php
    echo $wrap_end;

    return ob_get_clean();
}

/**
 * Build Link from string
 * 
 * @param string $value
 *
 * @since 1.3.0
 * @return array
 */
function kopa_build_link($value) {
    return kopa_parse_multi_attribute($value, array( 'href' => '', 'title' => '', 'target' => '', 'rel' => ''));
}

/**
 * Print link editor template
 * Link field need a hidden textarea to work
 * 
 * @since 1.3.0
 * @return void
 */
function kopa_link_editor_hidden() {
    echo '<textarea id="content" class="hide hidden"></textarea>';
    require_once ABSPATH . "wp-includes/class-wp-editor.php";
    _WP_Editors::wp_link_dialog();
}



/**
 * Parse string like "title:Link is useful|author:vutuansw" to array('title' => 'Link is useful', 'author' => 'vutuansw')
 *
 * @param $value
 * @param array $default
 *
 * @since 1.3.0
 * @return array
 */
function kopa_parse_multi_attribute($value, $default = array()) {
    $result = $default;
    $params_pairs = explode('|', $value);
    if (!empty($params_pairs)) {
        foreach ($params_pairs as $pair) {
            $param = preg_split('/\:/', $pair);
            if (!empty($param[0]) && isset($param[1])) {
                $result[$param[0]] = rawurldecode($param[1]);
            }
        }
    }

    return $result;
}
