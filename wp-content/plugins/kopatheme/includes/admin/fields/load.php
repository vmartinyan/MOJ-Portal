<?php

if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Kopa Framework fields loader
 *
 * @author 		vutuansw
 * @category 	Fields
 * @package 	KopaFramework/Admin
 * @since     1.1.9
 */
require_once 'default_fields.php';
require_once 'deprecated_fields.php';

//Load advanced fields
require_once 'field_icon_picker.php';
require_once 'field_color.php';
require_once 'field_gallery_sortable.php';
require_once 'field_upload.php';
require_once 'field_backup.php';
require_once 'field_font.php';
require_once 'field_group.php';
require_once 'field_image.php';
require_once 'field_layout_manager.php';
require_once 'field_restore_default.php';
require_once 'field_sidebar_manager.php';
require_once 'field_title.php';
require_once 'field_caption.php';
require_once 'field_quote.php';
require_once 'field_chosen.php';
require_once 'field_repeater.php';
require_once 'field_repeater_link.php';
require_once 'field_radio_image.php';
require_once 'field_taxonomy.php';
require_once 'field_singular.php';
require_once 'field_link.php';
/**
 * Register form fields in global list
 */
global $kopa_form_fields;

$kopa_form_fields = array(
    'text',
    'url',
    'email',
    'number',
    'password',
    'select',
    'multiselect',
    'textarea',
    'checkbox',
    'multicheck',
    'radio',
    'textarea',
    'datetime',
    //Deprecated
    'icon',
    'gallery',
    'chosen_singular',
    //Advanced
    'icon_picker',
    'color',
    'gallery_sortable',
    'upload',
    'image',
    'caption',
    'quote',
    'chosen',
    'repeater',
    'repeater_link',
    'radio_image',
    'taxonomy',
    'singular',
    'link'
);
