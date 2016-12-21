var Kopa_UI, Kopa_UI_DateTime, Kopa_UI_Gallery, Kopa_UI_Icon, Kopa_UI_Gallery_Sortable, Kopa_UI_Image, Kopa_UI_Repeater, Kopa_UI_Repeater_Link, Kopa_UI_Chosen, Kopa_UI_Icon_Picker;
var $kopa_icon_picker_activated;
var $kopa_gallery_sortable_uploader;
var $kopa_gallery_iframe;
var $kopa_gallery_button;

jQuery(document).ready(function () {
    Kopa_UI.init();
});

jQuery(document).ajaxSuccess(function () {
    Kopa_UI.init();
});

var Kopa_UI = {
    init: function () {
        Kopa_UI_DateTime.init();
        Kopa_UI_Image.init();
        Kopa_UI_Gallery.init();
        Kopa_UI_Gallery_Sortable.init();
        Kopa_UI_Icon.init();
        Kopa_UI_Icon_Picker.init();
        Kopa_UI_Repeater.init();
        Kopa_UI_Repeater_Link.init();
        Kopa_UI_Chosen.init();
        Kopa_UI_Radio_Image.init();
        Kopa_UI_Link.init();
        Kopa_UI_Group.init();
    }
}

var Kopa_UI_DateTime = {
    init: function () {
        if (jQuery('.kopa-framework-datetime').length > 0) {
            jQuery('.kopa-framework-datetime').each(function (index, element) {

                if (!jQuery(element).hasClass('kopa-framework-datetime--activated')) {

                    var kopa_timepicker = parseInt(jQuery(element).attr('data-timepicker'), 10);
                    var kopa_datepicker = parseInt(jQuery(element).attr('data-datepicker'), 10);
                    if (1 == kopa_timepicker) {
                        kopa_timepicker = true;
                    } else {
                        kopa_timepicker = false;
                    }
                    if (1 == kopa_datepicker) {
                        kopa_datepicker = true;
                    } else {
                        kopa_datepicker = false;
                    }

                    jQuery(element).datetimepicker({
                        lang: 'en',
                        timepicker: kopa_timepicker,
                        datepicker: kopa_datepicker,
                        format: jQuery(element).attr('data-format'),
                        i18n: {
                            en: {
                                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                dayOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
                            }
                        }
                    });


                    jQuery(element).addClass('kopa-framework-datetime--activated');

                }

            });
        }
    }
};

var Kopa_UI_Gallery = {
    init: function () {
        jQuery('.kopa-framework-gallery-box').on('click', '.kopa-framework-gallery-config', function (event) {
            event.preventDefault();
            $kopa_gallery_button = jQuery(this);
            if ($kopa_gallery_iframe) {
                $kopa_gallery_iframe.open();
                return;
            }
            $kopa_gallery_iframe = wp.media.frames.$kopa_gallery_iframe = wp.media({
                title: 'Gallery config',
                button: {
                    text: 'Use'
                },
                library: {
                    type: 'image'
                },
                multiple: true
            });
            $kopa_gallery_iframe.on('open', function () {
                var ids, selection;
                ids = $kopa_gallery_button.parents('.kopa-framework-gallery-box').find('input.kopa-framework-gallery').val();
                if ('' !== ids) {
                    selection = $kopa_gallery_iframe.state().get('selection');
                    ids = ids.split(',');
                    jQuery(ids).each(function (index, element) {
                        var attachment;
                        attachment = wp.media.attachment(element);
                        attachment.fetch();
                        selection.add(attachment ? [attachment] : []);
                    });
                }
            });
            $kopa_gallery_iframe.on('select', function () {
                var result, selection;
                result = [];
                selection = $kopa_gallery_iframe.state().get('selection');
                selection.map(function (attachment) {
                    attachment = attachment.toJSON();
                    result.push(attachment.id);
                });
                if (result.length > 0) {
                    result = result.join(',');
                    $kopa_gallery_button.parents('.kopa-framework-gallery-box').find('input.kopa-framework-gallery').val(result);
                }
            });
            $kopa_gallery_iframe.open();
        });
    }
};

var Kopa_UI_Icon = {
    init: function () {
        if (jQuery('.kopa-icon-picker').length > 0) {
            jQuery('.kopa-icon-picker').click(function (event) {

                var btn;
                event.preventDefault();
                btn = jQuery(this);
                if (jQuery(Kopa_UI_Icon.get_id('#')).length !== 1) {
                    jQuery('body').append('<div id="' + Kopa_UI_Icon.get_id('') + '" class="upside-hide"></div>');
                    jQuery.ajax({
                        beforeSend: function (jqXHR) {},
                        success: function (data, textStatus, jqXHR) {
                            jQuery(Kopa_UI_Icon.get_id('#')).html(data);
                        },
                        complete: function () {
                            Kopa_UI_Icon.open_lighbox(btn);
                        },
                        url: kopa_advanced_field.ajax_url,
                        dataType: "html",
                        type: 'GET',
                        async: false,
                        data: {
                            action: 'get_lighbox_icons'
                        }
                    });
                } else {
                    Kopa_UI_Icon.open_lighbox(btn);
                }
            });
        }
    },
    open_lighbox: function (btn) {
        jQuery(Kopa_UI_Icon.get_id('#')).dialog({
            width: 360,
            height: 480,
            modal: true,
            closeText: '<i class="dashicons dashicons-dismiss"></i>',
            title: kopa_advanced_field.translate.icon_picker,
            buttons: [
                {
                    'text': 'Select',
                    'class': 'kopa-ui-button-use button button-primary',
                    'click': function () {
                        var icon;
                        icon = Kopa_UI_Icon.click_ok();
                        btn.parent().find('.kopa-icon-picker-value').val(icon);
                        btn.parent().find('.kopa-icon-picker-preview i').attr('class', icon);
                    }
                }
            ]
        });
    },
    click_ok: function () {
        var icon;
        icon = jQuery(Kopa_UI_Icon.get_id('#')).find('.kopa-icon-item.upside-active i').attr('class');
        jQuery(Kopa_UI_Icon.get_id('#')).dialog('close');
        return icon;
    },
    select_a_icon: function (event, obj) {
        event.preventDefault();
        obj.parents('.kopa-wrap').find('.kopa-icon-item').removeClass('upside-active');
        obj.addClass('upside-active');
    },
    filter_icons: function (event, obj) {
        var filter, regex, wrap;
        event.preventDefault();
        wrap = obj.parents('.kopa-list-of-icon');
        filter = obj.val();
        if (!filter) {
            wrap.find('.kopa-icon-item').show();
            return false;
        }
        regex = new RegExp(filter, "i");
        wrap.find('.kopa-icon-item i').each(function (index, element) {
            if (jQuery(this).data('title').search(regex) < 0) {
                jQuery(this).parent().hide();
            } else {
                jQuery(this).parent().show();
            }
        });
    },
    get_id: function ($prefix) {
        return $prefix + 'kopa_advanced_field_lighbox_icons';
    }
};

var Kopa_UI_Gallery_Sortable = {
    init: function () {
        $galleries = jQuery('div.kopa-ui-gallery');
        if ($galleries.length) {

            $galleries.map(function ($gallery) {

                var $_gallery = jQuery(this);

                if (!$_gallery.hasClass('kopa-ui-gallery--activated')) {

                    Kopa_UI_Gallery_Sortable._init_sortable($_gallery.find('ul').first());

                    $_gallery.on('click', '.kopa-ui-gallery__upload', function (event) {
                        Kopa_UI_Gallery_Sortable._edit(event, jQuery(this));
                    });

                    $_gallery.on('click', '.kopa-ui-gallery__remove', function (event) {
                        Kopa_UI_Gallery_Sortable._remove(event, jQuery(this));
                    });

                    $_gallery.addClass('kopa-ui-gallery--activated');

                }

            });

        }
    },
    _edit: function (event, $button) {
        event.preventDefault();

        $wrap = $button.parents('.kopa-ui-gallery');
        $sortable = $wrap.find('ul').first();
        $inputs = $wrap.find('input[type="hidden"]');
        $previews = $wrap.find('img');
        $gallery_name = $wrap.attr('data-name');

        if ($kopa_gallery_sortable_uploader) {
            $kopa_gallery_sortable_uploader.open();
            return;
        }

        $kopa_gallery_sortable_uploader = wp.media.frames.$kopa_gallery_sortable_uploader = wp.media({
            title: 'Uploader',
            $button: {
                text: 'Select'
            },
            library: {type: 'image'},
            multiple: true
        });

        $kopa_gallery_sortable_uploader.on('open', function () {

            if ($inputs.length) {

                selection = $kopa_gallery_sortable_uploader.state().get('selection');
                jQuery.each($inputs, function () {
                    var attachment = wp.media.attachment(parseInt(jQuery(this).val()));
                    attachment.fetch();
                    selection.add(attachment);
                });

            }
        });

        $kopa_gallery_sortable_uploader.on('select', function () {

            var $results = [];
            var selection = $kopa_gallery_sortable_uploader.state().get('selection');

            selection.map(function ($attachment) {
                $attachment = $attachment.toJSON();
                $results.push([$attachment.id, $attachment.sizes.thumbnail.url]);
            });
            console.log($results);
            if ($results.length) {
                $sortable.html('');

                $results.map(function ($image) {
                    $html = Kopa_UI_Gallery_Sortable._build_single($gallery_name, $image[0], $image[1]);
                    $sortable.append(jQuery($html));
                });
            }

        });

        $kopa_gallery_sortable_uploader.open();
    },
    _remove: function (event, $button) {
        event.preventDefault();
        $button.parents('.kopa-ui-gallery__image').remove();
    },
    _build_single: function ($gallery_name, $image_id, $image_src) {

        $html = '<li class="kopa-ui-gallery__image">';
        $html += '<input type="hidden" value="' + $image_id + '" name="' + $gallery_name + '[]">';
        $html += '<img alt="" src="' + $image_src + '">';
        $html += '<span class="kopa-ui-gallery__remove dashicons dashicons-trash">';
        $html += '</span>';
        $html += '</li>';

        return $html;
    },
    _init_sortable: function ($sortable) {
        $sortable.sortable({
            containment: 'parent'
        });
        $sortable.disableSelection();
    }
}

var Kopa_UI_Image = {
    frame: {},
    init: function () {

        jQuery('.kopa-field-image').on('click', '.item-add', function (e) {
            e.preventDefault();

            var $this = jQuery(this);

            var id = $this.next('input').attr('id');

            if (Kopa_UI_Image.frame[id]) {
                Kopa_UI_Image.frame[id].open();
                return;
            }

            Kopa_UI_Image.frame[id] = wp.media.frames.file_frame = wp.media({
                title: 'Add Image',
                button: {
                    text: 'Add Image'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            });

            Kopa_UI_Image.frame[id].on('select', function () {

                var attachment = Kopa_UI_Image.frame[id].state().get('selection').first().toJSON();

                var source = attachment.sizes.thumbnail;
                if (attachment.sizes.hasOwnProperty('full')) {
                    source = attachment.sizes.full;
                }
                $this.html('<div class="img" style="background-image:url(' + source.url + ')"></div>');
                $this.next("input").val(attachment.id);
                $this.parent().addClass('hasimage');
            });

            Kopa_UI_Image.frame[id].open();
        });

        jQuery(document).on("click", ".kopa-field-image .item-remove", function (e) {
            jQuery(this).parent().find('.item-add').empty();
            jQuery(this).prev("input").val("");
            jQuery(this).parent().removeClass('hasimage');
            e.preventDefault();
        });
    }
};

var Kopa_UI_Repeater = {
    init: function () {
        var $repeaters;
        $repeaters = jQuery('.kopa-ui-repeater');

        if ($repeaters.length) {

            jQuery.each($repeaters, function () {
                var $_repeater;
                $_repeater = jQuery(this);

                if (!$_repeater.hasClass('kopa-ui-repeater--activated')) {

                    $_repeater.on('click', '.kopa-repeater-edit', function () {

                        var $wrap;
                        $wrap = jQuery(this).parents('.kopa-repeater-group');

                        if ($wrap.find('.kopa-repeater-item-content').is(":hidden")) {
                            $wrap.addClass('kopa-repeater-group--open');
                        } else {
                            $wrap.removeClass('kopa-repeater-group--open');
                        }

                    });

                    $_repeater.on('keyup', '.kopa-repeater-input-key', function () {
                        var $label, $new_key, $wrap;
                        $new_key = jQuery(this).val();
                        if ('' === jQuery.trim($new_key)) {
                            $new_key = kopa_advanced_field.translate.untitle;
                        } else {
                            $new_key = jQuery('<div>' + $new_key + '</div>').text();
                        }
                        $wrap = jQuery(this).parents('.kopa-repeater-group');
                        $label = $wrap.find('> label > span');
                        $label.text($new_key);
                    });

                    $_repeater.find('.kopa-ui-repeater-container').sortable();

                    $_repeater.find('.kopa-ui-repeater-container').repeatable({
                        addTrigger: $_repeater.find('.kopa-repeater-add'),
                        deleteTrigger: '.kopa-repeater-delete',
                        template: $_repeater.attr('data-id'),
                        itemContainer: '.kopa-repeater-group'
                    });

                    $_repeater.addClass('kopa-ui-repeater--activated');
                }

            });
        }
    }
};

var Kopa_UI_Repeater_Link = {
    init: function () {
        var $repeater_links;
        $repeater_links = jQuery('.kopa-ui-repeater-links');
        if ($repeater_links.length) {

            jQuery.each($repeater_links, function () {
                var $_repeater;
                $_repeater = jQuery(this);

                if (!$_repeater.hasClass('kopa-ui-repeater-links--activated')) {


                    $_repeater.on('click', '.kopa-repeater-edit', function () {

                        var $wrap;
                        $wrap = jQuery(this).parents('.kopa-repeater-group');

                        if ($wrap.find('.kopa-repeater-item-content').is(":hidden")) {
                            $wrap.addClass('kopa-repeater-group--open');
                        } else {
                            $wrap.removeClass('kopa-repeater-group--open');
                        }

                    });

                    $_repeater.on('keyup', '.kopa-repeater-input-title', function () {
                        var $label, $new_key, $wrap;
                        $new_key = jQuery(this).val();
                        if ('' === jQuery.trim($new_key)) {
                            $new_key = kopa_advanced_field.translate.untitle;
                        } else {
                            $new_key = jQuery('<div>' + $new_key + '</div>').text();
                        }
                        $wrap = jQuery(this).parents('.kopa-repeater-group');
                        $label = $wrap.find('> label > span');
                        $label.text($new_key);
                    });

                    $_repeater.find('.kopa-ui-repeater-container').sortable();
                    $_repeater.find('.kopa-ui-repeater-container').repeatable({
                        addTrigger: $_repeater.find('.kopa-repeater-add'),
                        deleteTrigger: '.kopa-repeater-delete',
                        template: $_repeater.attr('data-id'),
                        itemContainer: '.kopa-repeater-group',
                        afterAdd: function () {
                            Kopa_UI_Icon_Picker.init();
                        }
                    });

                    $_repeater.addClass('kopa-ui-repeater-links--activated');
                }

            });
        }
    }
};

var Kopa_UI_Chosen = {
    init: function () {
        var $et_selects;
        $et_selects = jQuery('.kopa-ui-chosen select');
        if ($et_selects.length) {
            jQuery.each($et_selects, function () {

                $cbo = jQuery(this);
                if (!$cbo.hasClass('kopa-ui-chosen--activated')) {

                    $cbo.chosen({
                        allow_single_deselect: true,
                        width: $cbo.attr('data-width')
                    });

                    $cbo.addClass('kopa-ui-chosen--activated');

                }

            });
        }
    }
};

var Kopa_UI_Icon_Picker = {
    init: function () {
        var $icon_pickers;
        $icon_pickers = jQuery('.kopa-ui-icon-picker');

        if ($icon_pickers.length) {

            jQuery.each($icon_pickers, function (index, el) {

                $_icon_pickers = jQuery(this);

                if (!$_icon_pickers.hasClass('kopa-ui-icon-picker--activated')) {

                    $_icon_pickers.on('click', '.kopa-ui-icon-picker-add', function () {
                        var $obj;
                        $obj = jQuery(this);
                        $kopa_icon_picker_activated = $obj.parents('.kopa-ui-icon-picker');
                        if (!Kopa_UI_Icon_Picker._getBoxObject().length) {
                            Kopa_UI_Icon_Picker._build_picker();
                            Kopa_UI_Icon_Picker._init_dialog();
                        }

                        Kopa_UI_Icon_Picker._add($obj);

                    });

                    $_icon_pickers.addClass('kopa-ui-icon-picker--activated');

                }

            });

        }

    },
    _getBoxObject: function () {
        return jQuery('#' + Kopa_UI_Icon_Picker._getBoxId());
    },
    _getBoxId: function () {
        return 'tmpl-kopa-icon-picker';
    },
    _add: function ($obj) {
        var $tmp_picker;
        $tmp_picker = Kopa_UI_Icon_Picker._getBoxObject();
        if ($tmp_picker.hasClass('ui-dialog-content')) {
            $tmp_picker.dialog('open');
        }
    },
    _build_picker: function () {
        var $selected, $tmp_html, $tmp_id, $tmp_picker, $tmp_picker_body;
        $tmp_id = Kopa_UI_Icon_Picker._getBoxId();
        if ($kopa_icon_picker_activated.length && $kopa_icon_picker_activated !== void 0) {
            $selected = $kopa_icon_picker_activated.find('input').val();
        } else {
            $selected = false;
        }
        $tmp_html = '<div id="' + $tmp_id + '">' + '<div class="kopa-ui__header">' + '<input type="text" class="kopa-ui__search" onkeyup="Kopa_UI_Icon_Picker._search( jQuery(this) );">' + '</div>' + '<div class="kopa-ui__body">' + '</div>' + '</div>';
        jQuery('body').append($tmp_html);
        $tmp_picker = Kopa_UI_Icon_Picker._getBoxObject();
        $tmp_picker_body = $tmp_picker.find('.kopa-ui__body');
        _.each(kopa_advanced_field.icon_picker.fonts, function ($font) {
            jQuery.getJSON($font.file, null, function ($json, $textStatus) {
                if ('success' === $textStatus) {
                    _.each($json, function ($item) {
                        var $names, $selector;
                        $selector = $item.selector;
                        $names = $selector.split(',');
                        _.each($names, function ($name) {
                            $name = _.unescape(jQuery.trim($name.replace(':before', '')).substring(1));
                            if ($font.prefix) {
                                $name = $font.prefix + ' ' + $name;
                            }
                            if ($selected && $name === $selected) {
                                $name += ' kopa-ui__active';
                            }
                            $tmp_picker_body.append('<span><i class="' + $name + '"></i></span>');
                        });
                    });
                }
            });
        });
        $tmp_picker_body.on('click', 'i', function (event) {
            var $wrap;
            event.preventDefault();
            if (!jQuery(this).hasClass('kopa-ui__active')) {
                $wrap = jQuery(this).parents('.kopa-ui__body');
                $wrap.find('i').removeClass('kopa-ui__active');
            }
            jQuery(this).toggleClass('kopa-ui__active');
        });
    },
    _init_dialog: function () {
        var $et_dialog;
        $et_dialog = Kopa_UI_Icon_Picker._getBoxObject();
        $et_dialog.dialog({
            title: kopa_advanced_field.icon_picker.label.icon_picker,
            dialogClass: 'kopa-ui-dialog kopa-ui-hide-title',
            closeText: '<i class="dashicons dashicons-dismiss"></i>',
            width: 400,
            height: 400,
            modal: true,
            closeOnEscape: false,
            resizable: false,
            autoOpen: false,
            buttons: [
                {
                    text: kopa_advanced_field.icon_picker.label.remove,
                    "class": 'kopa-ui-button-remove button button-link button-remove',
                    click: function () {
                        $et_dialog.dialog('close');
                        $kopa_icon_picker_activated.find('input').val('');
                        $kopa_icon_picker_activated.find('i').attr('class', '');
                        $kopa_icon_picker_activated.find('.kopa-ui-icon-picker-add').text(kopa_advanced_field.icon_picker.label.add);
                        Kopa_UI_Icon_Picker._clear();
                    }
                }, {
                    text: kopa_advanced_field.icon_picker.label.cancel,
                    "class": 'kopa-ui-button-cancel button button-secondary',
                    click: function () {
                        $et_dialog.dialog('close');
                        Kopa_UI_Icon_Picker._clear();
                    }
                }, {
                    text: kopa_advanced_field.icon_picker.label.use,
                    "class": 'kopa-ui-button-use button button-primary',
                    click: function () {
                        var $selected, $val;
                        if ($kopa_icon_picker_activated.length && $kopa_icon_picker_activated !== void 0) {
                            $selected = $et_dialog.find('.kopa-ui__active');
                            if ($selected.length) {
                                $val = jQuery.trim($selected.attr('class').replace('kopa-ui__active', ''));
                            } else {
                                $val = '';
                            }
                            $kopa_icon_picker_activated.toggleClass('kopa-state-added');
                            $kopa_icon_picker_activated.find('.kopa-ui-icon-picker-add').text(kopa_advanced_field.icon_picker.label.edit);
                            $kopa_icon_picker_activated.find('i').attr('class', $val);
                            $kopa_icon_picker_activated.find('input').val($val);
                        }
                        $et_dialog.dialog('close');
                        Kopa_UI_Icon_Picker._clear();
                    }
                }
            ]
        });
    },
    _search: function ($input) {
        var $regex, $tmp_picker, $tmp_picker_body, $value;
        $tmp_picker = Kopa_UI_Icon_Picker._getBoxObject();
        $tmp_picker_body = $tmp_picker.find('.kopa-ui__body');
        $value = $input.val();
        if (!$value) {
            $tmp_picker_body.find('i').parent().show();
        } else {
            $regex = new RegExp($value, 'i');
            $tmp_picker_body.find('i').each(function () {
                if (jQuery(this).attr('class').search($regex) < 0) {
                    jQuery(this).parent().hide();
                } else {
                    jQuery(this).parent().show();
                }
            });
        }
    },
    _clear: function () {
        var $tmp_picker;
        $kopa_icon_picker_activated = void 0;
        $tmp_picker = Kopa_UI_Icon_Picker._getBoxObject();
        $tmp_picker.find('.kopa-ui__search').val('');
        $tmp_picker.find('.kopa-ui__body span').show();
        $tmp_picker.find('.kopa-ui__body i.kopa-ui__active').removeClass('kopa-ui__active');
    }
};

var Kopa_UI_Radio_Image = {
    init: function () {

        var $rdo_images = jQuery('.kp-ui-radio-image-container');

        if ($rdo_images.length) {

            jQuery.each($rdo_images, function (index, el) {

                if (!jQuery(this).hasClass('kopa-ui-radio-image--activated')) {

                    jQuery(this).on('click', '.kp-ui-radio-image-label', function () {

                        if (!jQuery(this).hasClass('kp-state-checked')) {
                            $container = jQuery(this).parents('.kp-ui-radio-image-container');
                            $container.find('.kp-ui-radio-image-label.kp-state-checked').removeClass('kp-state-checked');
                            jQuery(this).addClass('kp-state-checked');
                        }

                    });

                    jQuery(this).addClass('kopa-ui-radio-image--activated');
                }

            });

        }

    },
};

var Kopa_UI_Link = {
    init: function () {
        jQuery(document).on('click', '.kopa-field-link .link_button', function (e) {

            e.preventDefault();
            var $block, $input, $url_label, $title_label, value_object, $link_submit, $kopa_link_submit, $kopa_link_nofollow, dialog;
            $block = jQuery(this).closest(".kopa-field-link");
            $input = $block.find("input.kopa_value");
            $url_label = $block.find(".url-label");
            $title_label = $block.find(".title-label");
            value_object = $input.data("json");
            $link_submit = jQuery("#wp-link-submit");
            $kopa_link_submit = jQuery('<input type="button" name="kopa_link-submit" id="kopa_link-submit" class="button-primary" value="Set Link">');
            $link_submit.hide();
            jQuery("#kopa_link-submit").remove();
            $kopa_link_submit.insertBefore($link_submit);
            $kopa_link_nofollow = jQuery('<div class="link-target kopa-link-nofollow"><label><span></span> <input type="checkbox" id="kopa-link-nofollow"> Add nofollow option to link</label></div>');
            jQuery("#link-options .kopa-link-nofollow").remove();
            $kopa_link_nofollow.insertAfter(jQuery("#link-options .link-target"));
            setTimeout(function () {
                var currentHeight = jQuery("#most-recent-results").css("top");
                jQuery("#most-recent-results").css("top", parseInt(currentHeight) + $kopa_link_nofollow.height())
            }, 200);
            dialog = window.wpLink;
            dialog.open('content');

            _.isString(value_object.href) && (jQuery("#wp-link-url").length ? jQuery("#wp-link-url").val(value_object.href) : jQuery("#url-field").val(value_object.href)), _.isString(value_object.title) && (jQuery("#wp-link-text").length ? jQuery("#wp-link-text").val(value_object.title) : jQuery("#link-title-field").val(value_object.title)), jQuery("#wp-link-target").length ? jQuery("#wp-link-target").prop("checked", !_.isEmpty(value_object.target)) : jQuery("#link-target-checkbox").prop("checked", !_.isEmpty(value_object.target)), jQuery("#kopa-link-nofollow").length && jQuery("#kopa-link-nofollow").prop("checked", !_.isEmpty(value_object.rel));
            $kopa_link_submit.unbind("click.kopaLink").bind("click.kopaLink", function (e) {

                e.preventDefault();
                e.stopImmediatePropagation();
                var string, options = {};
                options.href = jQuery("#wp-link-url").length ? jQuery("#wp-link-url").val() : jQuery("#url-field").val();
                options.title = jQuery("#wp-link-text").length ? jQuery("#wp-link-text").val() : jQuery("#link-title-field").val();
                var $checkbox = jQuery(jQuery("#wp-link-target").length ? "#wp-link-target" : "#link-target-checkbox");
                options.target = $checkbox[0].checked ? " _blank" : "";
                options.rel = jQuery("#kopa-link-nofollow")[0].checked ? "nofollow" : "";

                string = _.map(options, function (value, key) {
                    return _.isString(value) && 0 < value.length ? key + ":" + encodeURIComponent(value) : void 0
                }).join("|");

                $input.val(string).change();
                $input.data("json", options);
                $url_label.html(options.href + options.target);
                $title_label.html(options.title);
                dialog.close('noReset');
                window.wpLink.textarea = "";
                $link_submit.show();
                $kopa_link_submit.unbind("click.kopaLink");
                $kopa_link_submit.remove();
                jQuery("#wp-link-cancel").unbind("click.kopaLink");
                $checkbox.attr("checked", false);
                jQuery("#most-recent-results").css("top", "");
                jQuery("#kopa-link-nofollow").attr("checked", false);
                return false;
            });
            jQuery("#wp-link-cancel").unbind("click.kopaLink").bind("click.kopaLink", function (e) {
                e.preventDefault();
                dialog.close('noReset');
                $kopa_link_submit.unbind("click.kopaLink");
                $kopa_link_submit.remove();
                jQuery("#wp-link-cancel").unbind("click.kopaLink");
                jQuery("#wp-link-close").unbind("click.kopaCloseLink");
                window.wpLink.textarea = "";
                return false;
            });
            jQuery('#wp-link-close').unbind('click').bind('click.kopaCloseLink', function (e) {
                e.preventDefault();
                dialog.close('noReset');
                $kopa_link_submit.unbind("click.kopaLink");
                $kopa_link_submit.remove();
                jQuery("#wp-link-cancel").unbind("click.kopaLink");
                jQuery("#wp-link-close").unbind("click.kopaCloseLink");
                window.wpLink.textarea = "";
                return false;
            });
        });
    }
}


var Kopa_UI_Group = {
    init: function () {

        jQuery(document).on('click', '.kopa_group .group_nav a', function (e) {

            var $this = jQuery(this);
            var id = $this.attr('href');

            $this.closest('ul').find('.active').removeClass('active');
            $this.addClass('active');

            jQuery('.kopa_group .group_item.active').removeClass('active');

            var $panel =jQuery('.kopa_group ' + id);
            $panel.addClass('active');
            
            jQuery(document).trigger('kopa_group_active', [$panel]);

            e.preventDefault();
        });
    }
};