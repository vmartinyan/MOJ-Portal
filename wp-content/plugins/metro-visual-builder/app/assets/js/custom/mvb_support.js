var mvb_data;
var is_mvb_call = true;
var id_iterator = 1;

jQuery(document).bind({
	ajaxStart: function() {
		if( is_mvb_call )
			jQuery('body').addClass("mvb_loading");
	},
	ajaxStop: function() {
		is_mvb_call = false;
		jQuery('body').removeClass("mvb_loading");
	}
});

jQuery(document).ready(function($){

    jQuery.widget( "ui.dialog", jQuery.ui.dialog, {
        /*! jQuery UI - v1.10.2 - 2013-12-12
         *  http://bugs.jqueryui.com/ticket/9087#comment:27 - bugfix
         *  http://bugs.jqueryui.com/ticket/4727#comment:23 - bugfix
         *  allowInteraction fix to accommodate windowed editors
         */
        _allowInteraction: function( event ) {
            if ( this._super( event ) ) {
                return true;
            }

            // address interaction issues with general iframes with the dialog
            if ( event.target.ownerDocument != this.document[ 0 ] ) {
                return true;
            }

            // address interaction issues with dialog window
            if ( jQuery( event.target ).closest( "div" ).length ) {
                return true;
            }
        },
        /*! jQuery UI - v1.10.2 - 2013-10-28
         *  http://dev.ckeditor.com/ticket/10269 - bugfix
         *  moveToTop fix to accommodate windowed editors
         */
        _moveToTop: function ( event, silent ) {
            if ( !event || !this.options.modal ) {
                this._super( event, silent );
            }
        }
    });

	var $__x = '';
	var $__xrow = '';
	var $__xcolumn = '';
	var where_to_add = 'top';

	$( ".columns" ).sortable({
		connectWith: ".columns",
		handle: '.mvb_module_handler',
		delay: 100,
		placeholder: "column_placeholder",
		dropOnEmpty: true,
		update : bs_update_field
	});

	$( "#mvb_sortable_list" ).sortable({update : bs_update_field, delay: 100, handle: '.bshaper_handler', axis: 'y', placeholder: 'row_placeholder'});

	$(".mvb_delete_section").live('click', function(e){
		e.preventDefault();

		if( confirm("Are you sure you want to remove this row?") )
		{
			$(this).parents(".bshaper_row").fadeOut("slow").remove();
			bs_update_field_manual();
		}//endif;
	});

	$("a.bshaper_delete_module").live('click', function(e){
		e.preventDefault();
		if( confirm("Are you sure you want to remove this module?") )
		{
			$(this).parents(".bshaper_module").fadeOut("slow").remove();
			bs_update_field_manual();
		}//endif;

	});

	$("a.mvb_row_settings").live('click', function(e){
		e.preventDefault();
		//bs_update_field_manual();
		is_mvb_call = true;
		var therow = $(this).parents('.bshaper_row');
		$__xrow = therow;
		var data = {
			action: 'getRowSettings',
			bgimage: therow.attr('data-mvb-bgimage'),
			bgrepeat: therow.attr('data-mvb-bgrepeat'),
			bgposition: therow.attr('data-mvb-bgposition'),
			bg_position: therow.attr('data-mvb-bg_position'),
			bgcolor: therow.attr('data-mvb-bgcolor'),
			textcolor: therow.attr('data-mvb-textcolor'),
			padding_top: therow.attr('data-mvb-paddtop'),
			padding_bottom: therow.attr('data-mvb-paddbottom'),
			css: therow.attr('data-mvb-css'),
			cssclass: therow.attr('data-mvb-cssclass'),
			animbg: therow.attr('data-mvb-animbg'),
			totop: therow.attr('data-mvb-totop')
		};

		$.post(ajaxurl, data, function(_html) {
			$('#bshaper_tmp').html(_html).dialog( {modal:true,height: 600,width: 700, 'title' : 'Row Settings', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
			mvb_do_asm_select();
			initialize_fields();

			$('#bshaper_tmp').find('.mvb_color_field').each(function(i){

				var element_s = $('#bshaper_tmp').find('.mvb_color_field:eq('+i+')');

				if( !element_s.hasClass('mvb_repeater_field') )
				{
					var c_id = element_s.attr('id');
					bshaper_artist_color_picker("#"+c_id);
					initialize_color_pickers();
				}//endif;
			});
		});
	});

	$(".mvb_submit_row_settings").live('click', function(){
		var therow = $__xrow;
		therow.attr('data-mvb-bgimage', $("#bshaper_tmp").find('.mvb_module_bgimage').val());
		therow.attr('data-mvb-bgrepeat', $("#bshaper_tmp").find('.mvb_module_bgrepeat').val());
		therow.attr('data-mvb-bgposition', $("#bshaper_tmp").find('.mvb_module_bgposition').val());
		therow.attr('data-mvb-bg_position', $("#bshaper_tmp").find('.mvb_module_bg_position').val());
		therow.attr('data-mvb-bgcolor', $("#bshaper_tmp").find('.mvb_module_bgcolor').val());
		therow.attr('data-mvb-textcolor', $("#bshaper_tmp").find('.mvb_module_textcolor').val());
		therow.attr('data-mvb-css', $("#bshaper_tmp").find('.mvb_module_css').val());
		therow.attr('data-mvb-paddtop', $("#bshaper_tmp").find('.mvb_module_padding_top').val());
		therow.attr('data-mvb-paddbottom', $("#bshaper_tmp").find('.mvb_module_padding_bottom').val());
		therow.attr('data-mvb-cssclass', $("#bshaper_tmp").find('.mvb_module_cssclass').val());
		therow.attr('data-mvb-animbg', $("#bshaper_tmp").find('.mvb_module_animbg').val());
		therow.attr('data-mvb-totop', $("#bshaper_tmp").find('.mvb_module_totop').val());

		$('#bshaper_tmp').dialog( "close" );

		bs_update_field_manual();

	});//end click .mvb_submit_row_settings

	$("a.mvb_column_settings").live('click', function(e){
		e.preventDefault();
		//bs_update_field_manual();
		is_mvb_call = true;
		var thecolumn = $(this).parents('.columns');
		$__xcolumn = thecolumn;
		var data = {
			action: 'getColumnSettings',
			bgimage: thecolumn.attr('data-mvb-bgimage'),
			bgrepeat: thecolumn.attr('data-mvb-bgrepeat'),
			bgposition: thecolumn.attr('data-mvb-bgposition'),
			bgcolor: thecolumn.attr('data-mvb-bgcolor'),
			textcolor: thecolumn.attr('data-mvb-textcolor'),
			css: thecolumn.attr('data-mvb-css'),
			cssclass: thecolumn.attr('data-mvb-cssclass'),
			totop: thecolumn.attr('data-mvb-totop'),
            animbg: thecolumn.attr('data-mvb-animbg'),
			padding_top: thecolumn.attr('data-mvb-paddtop'),
			padding_right: thecolumn.attr('data-mvb-paddright'),
			padding_bottom: thecolumn.attr('data-mvb-paddbottom'),
			padding_left: thecolumn.attr('data-mvb-paddleft'),
			smallclass: thecolumn.attr('data-mvb-smallclass')
		};

		$.post(ajaxurl, data, function(_html) {
			$('#bshaper_tmp').html(_html).dialog( {modal:true,height: 600,width: 700, 'title' : 'Column Settings', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
			mvb_do_asm_select();

			$('#bshaper_tmp').find('.mvb_color_field').each(function(i){
				initialize_fields();
				initialize_color_pickers();
				var element_s = $('#bshaper_tmp').find('.mvb_color_field:eq('+i+')');

				if( !element_s.hasClass('mvb_repeater_field') )
				{
					var c_id = element_s.attr('id');
					bshaper_artist_color_picker("#"+c_id);
					initialize_color_pickers();
				}//endif;
			});
		});
	});//click .mvb_column_settings

	$(".mvb_submit_column_settings").live('click', function(){
		var thecolumn = $__xcolumn;
		thecolumn.attr('data-mvb-bgimage', $("#bshaper_tmp").find('.mvb_module_bgimage').val());
		thecolumn.attr('data-mvb-bgrepeat', $("#bshaper_tmp").find('.mvb_module_bgrepeat').val());
		thecolumn.attr('data-mvb-bgposition', $("#bshaper_tmp").find('.mvb_module_bgposition').val());
		thecolumn.attr('data-mvb-bgcolor', $("#bshaper_tmp").find('.mvb_module_bgcolor').val());
		thecolumn.attr('data-mvb-textcolor', $("#bshaper_tmp").find('.mvb_module_textcolor').val());
		thecolumn.attr('data-mvb-cssclass', $("#bshaper_tmp").find('.mvb_module_cssclass').val());
		thecolumn.attr('data-mvb-totop', $("#bshaper_tmp").find('.mvb_module_totop').val());
		thecolumn.attr('data-mvb-css', $("#bshaper_tmp").find('.mvb_module_css').val());
		thecolumn.attr('data-mvb-smallclass', $("#bshaper_tmp").find('.mvb_module_smallclass').val());
		thecolumn.attr('data-mvb-paddtop', $("#bshaper_tmp").find('.mvb_module_padding_top').val());
		thecolumn.attr('data-mvb-paddright', $("#bshaper_tmp").find('.mvb_module_padding_right').val());
		thecolumn.attr('data-mvb-paddbottom', $("#bshaper_tmp").find('.mvb_module_padding_bottom').val());
		thecolumn.attr('data-mvb-paddleft', $("#bshaper_tmp").find('.mvb_module_padding_left').val());

		$('#bshaper_tmp').dialog( "close" );

		bs_update_field_manual();

	});//end click .mvb_submit_column_settings

	$("a.mvb_clear_content").live('click', function(e){
		e.preventDefault();
		if( confirm( $(this).attr('data-confirm') ) )
		{
			$("#mvb_sortable_list").empty();
			bs_update_field_manual();
		}//endif;

	});

	$( "a.bshaper_add_section" ).click(function(e) {
		where_to_add = $(this).attr('data-where');
		$('#bshaper_tmp').html('');
		is_mvb_call = true;
		$('#bshaper_tmp').load('admin-ajax.php?action=getSectionTypes').dialog( {modal:true,height: 200,width: 700, 'title' : 'Add section', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close } );

		e.preventDefault();
	});//end add_section click

	$("a.mvb_add_section_type").live('click', function(e){
		e.preventDefault();
		is_mvb_call = true;

		var $_html = '<li class="row bshaper_row">'+$($(this).attr("href")).html()+'</li>';

		if( where_to_add == 'bottom' )
		{
			$("#mvb_sortable_list").append($_html);
		}
		else
		{
			$("#mvb_sortable_list").prepend($_html);
		}

		$( ".columns" ).sortable({
			connectWith: ".columns",
			handle: '.mvb_module_handler',
			delay: 100,
			placeholder: "column_placeholder",
			dropOnEmpty: true,
			update : bs_update_field
		});

		$('#bshaper_tmp').dialog( "close" );

		bs_update_field_manual();
		return false;
	}); //end mvb_add_section_type click

	$( "a.bshaper_add_module" ).live('click', function(e) {
		$('#bshaper_tmp').html('');
		is_mvb_call = true;
		$('#bshaper_tmp').load('admin-ajax.php?action=bshaperGetModules').dialog( {modal:true,height: 600,width: 820, 'title' : 'Add a new module', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
		$__x = $(this);
		e.preventDefault();
	});//end bshaper_add_module click

	$(".bshaper_modules li a").live('click', function(e){
		e.preventDefault();
		is_mvb_call = true;
		$(".module_list").hide();
		$(".the_modules").slideDown();

		var data = {
			action: 'bshaperShowModule',
			module: $(this).attr("data-module")
		};
		$.post(ajaxurl, data, function(_html) {
			$('#bshaper_content_form_module')[0].innerHTML = _html;
			mvb_do_asm_select();
			initialize_fields();
			initTheEditor('txtInternalComments');
			$('#bshaper_content_form_module').find('.mvb_color_field').each(function(i){
				var element_s = $('#bshaper_content_form_module').find('.mvb_color_field:eq('+i+')');

				if( !element_s.hasClass('mvb_repeater_field') )
				{
					var c_id = element_s.attr('id');
					bshaper_artist_color_picker("#"+c_id);
				}//endif;
			});

			$('.module_form').show();
		});
	});

	$(".bshaper_back_to_module_list").live("click", function(e){
		e.preventDefault();
		$(".the_modules").hide();
		$('.module_form').hide();
		$(".module_list").slideDown();
		removeTinyMCE('txtInternalComments');
		return false;
	});//end bshaper_back_to_module_list;

	$(".bshaper_add_module_html").live('click', function(e){
		e.preventDefault();
		is_mvb_call = true;
		$(this).after('<div class="bshaper_loading">saving...</div>');

		mvb_data = find_all_vars($(this));
		mvb_data.action = 'bshaperAddModule';

		mvb_data.module = $(this).parents('.module_form').find('.mvb_the_module').val();
		mvb_data.sc_action = $(this).parents('.module_form').find('.mvb_the_action').val();



		$.post(ajaxurl, mvb_data, function(_html) {
			if( mvb_data.sc_action == 'edit')
			{
				$__x.parents('.bshaper_module').replaceWith(_html);
			}
			else
			{
				$__x.parents('.columns').append(_html);
			}
			bs_update_field_manual();
		});

		$('#bshaper_tmp').dialog( "close" );
		//dump(mvb_data);
		//alert(mvb_data.sc_action);
	});//bshaper_add_module_html click

	$( "a.bshaper_edit_module" ).live('click', function(e) {
		is_mvb_call = true;
		var shortcode = $(this).parents('.bshaper_module').find('.bshaper_sh').html();

		var data = {
			action: 'bshaperEditModule',
			shortcode: shortcode
		};
		$.post(ajaxurl, data, function(_html) {
			$('#bshaper_tmp').html(_html).dialog( {modal:true,height: 600,width: 700, 'title' : 'Edit module', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
			mvb_do_asm_select();
			initialize_fields();
			initialize_color_pickers();

			$('#bshaper_tmp').find('.mvb_color_field').each(function(i){

				var element_s = $('#bshaper_tmp').find('.mvb_color_field:eq('+i+')');

				if( !element_s.hasClass('mvb_repeater_field') )
				{
					var c_id = element_s.attr('id');
					bshaper_artist_color_picker("#"+c_id);
					initialize_color_pickers();
				}//endif;
			});
		});

		$__x = $(this);

		e.preventDefault();
	});//end bshaper_edit_module click
	//repeater field
	$(".bshaper_acc_add_section").live('click', function(e){
		e.preventDefault();
		var _what = $(this).attr('data-what');
		$("#"+_what).append($("."+_what+"_shadow_ul").html());

		//here
		initialize_color_pickers();
	});

	$(".bshaper_hide_section").live('click', function(e){
		e.preventDefault();
		var $a = $(this);
		$a.parent('.bshaper_hide_section_h').next('.bshaper_section_holder').slideToggle('fast', function(){
			if( $a.parent('.bshaper_hide_section_h').hasClass('bshaper_active') )
			{
				$a.parent('.bshaper_hide_section_h').removeClass('bshaper_active');
			}
			else
			{
				$a.parent('.bshaper_hide_section_h').addClass('bshaper_active');
			}//endif;
		});
	});//end bshaper_hide_section click

	$(".repeater_sortable .mvb_st_section_title").live('change', function(){
		var $obj = $(this);

		$obj.parents('li').find('.bshaper_section_name').text($obj.val());
	});

	//end repeater field

});//document ready

function initialize_fields()
{
	var $ = jQuery;

	if( $(".repeater_sortable").length > 0 )
	{
		$('.module_form').find(".repeater_sortable").each(function(i){
			var sort_field = $('.module_form').find('.repeater_sortable:eq('+i+')').attr('id');
			$("#"+sort_field).addClass('sortable').sortable({handle: ".bshaper_handler_acc", axis: 'y'});;
		});
	}//endif;



}//end initialize_fields

function initialize_color_pickers()
{
	var $ = jQuery;
	if( $(".repeater_sortable").length > 0 )
	{
		$('.repeater_sortable').find('.mvb_color_field').each(function(i){
			var element_t = $('#bshaper_tmp .repeater_sortable').find('.mvb_color_field:eq('+i+')');

			if( element_t.attr('data-hascp') != 'yes' )
			{
				var c_id = element_t.attr('id');

				var new_id = c_id+"_"+id_iterator;

				element_t.attr('id', new_id);
				element_t.attr('data-hascp', 'yes');
				bshaper_artist_color_picker("#"+new_id);

				id_iterator++;
			}//endif;
		});
	}//endif;
}//end initialize_color_pickers

function find_all_vars( cel )
{
	var $ = jQuery;
	var $_action = cel.parents('.module_form').find('.bshaper_artist_action').val();
	var obj_frm = cel.parents('.module_form');
	var mvb_data = {};
	var t = [];
	//simple fields

	obj_frm.find('.mvb_module_field').each(function(i){
		var field_tmp = obj_frm.find('.mvb_module_field:eq('+i+')');

		if( !field_tmp.hasClass('mvb_repeater_field') )
		{
			if( field_tmp.attr('type') == 'radio' )
			{
				var field_tmp = obj_frm.find('.mvb_module_field:eq('+i+')[checked="checked"]');
				mvb_data[field_tmp.attr('name')] = field_tmp.val();
			}
			else
			{
				if( field_tmp.attr('id') != 'txtInternalComments' )
					mvb_data[field_tmp.attr('name')] = field_tmp.val();
				else
					mvb_data[field_tmp.attr('name')] = tinyMCE.activeEditor.getContent();
			}//endif;
		}
	});

	if( $('.repeater_sortable').length > 0 )
	{
		var iterator = 0;
		var oname = '';

		$(".repeater_sortable li").each(function(){
			var tmp = {};
			var $frm = $(this);
			oname = $frm.parents('.repeater_sortable').attr('data-field');

			if( !$frm.find(".bshaper_remove_section_cbx").is(':checked') )
			{
				$frm.find('.mvb_module_field').each(function(the_index){
					var repeater_field_tmp = $frm.find('.mvb_module_field:eq('+the_index+')');
					tmp[repeater_field_tmp.attr('name')] = repeater_field_tmp.val();
				});

				t.push(tmp);
			}//endif;
		});

		mvb_data[oname] = t;
	}//endif repeater;

	return mvb_data;
}//end find_all_vars();

var bshaper_col_sortable = {
	connectWith: ".columns",
	handle: 'mvb_module_handler',
	delay: 300,
	placeholder: "column_placeholder",
	dropOnEmpty: true,
	update : bs_update_field
};

function bs_update_field(e, ui)
{
	var $ = jQuery;
	is_mvb_call = true;

	var bshaper_post_id = $(".bshaper_the_post_id").val();
	var bshaper_nonce = $(".bshaper_ajax_referrer").val();

	if (!ui.sender) {
		var _html = $("#mvb_sortable_list").html();
		var data = {
			action: 'bshaperSaveMeta',
			the_html: _html,
			bshaper_metro_nonce: bshaper_nonce,
			post_id: bshaper_post_id
		};
		$.post(
			ajaxurl,
			data,
			function(response) {
				$("#mvb_sortable_list").html(response);
				$("#bshaper_artist_content_html").text(response);
				$( ".columns" ).sortable({
					connectWith: ".columns",
					handle: '.mvb_module_handler',
					delay: 100,
					placeholder: "column_placeholder",
					dropOnEmpty: true,
					update : bs_update_field
				});
			}
		);
	}
}

/*misc functions*/

function bs_update_field_manual()
{
	var $ = jQuery;
	is_mvb_call = true;
	var bshaper_post_id = $(".bshaper_the_post_id").val();
	var bshaper_nonce = $(".bshaper_ajax_referrer").val();
	var _html = $("#mvb_sortable_list").html();

	var data = {
		action: 'bshaperSaveMeta',
		the_html: _html,
		bshaper_metro_nonce: bshaper_nonce,
		post_id: bshaper_post_id
	};

	$.post(
		ajaxurl,
		data,
		function(response) {
			$("#mvb_sortable_list").html(response);
			$("#bshaper_artist_content_html").text(response);
			$( ".columns" ).sortable({
				connectWith: ".columns",
				handle: '.mvb_module_handler',
				delay: 100,
				placeholder: "column_placeholder",
				dropOnEmpty: true,
				update : bs_update_field
			});
		}
	);
}//end bs_update_field_manual()

var bshaper_col_sortable = {
	connectWith: ".columns",
	placeholder: "column_placeholder",
	dropOnEmpty: true,
	cancel: ".bshaper_add_module",
	update : bs_update_field
};

function bshaper_artist_color_picker(_what)
{
	jQuery(_what).ColorPicker({
		color: "#"+jQuery(_what).val(),
		onChange: function (hsb, hex, rgb) {
			jQuery(_what).next('.bshaper_color_preview').css("backgroundColor", "#" + hex);
			jQuery(_what).val(hex);
		}
	});
}//end bshaper_artist_color_picker()

function mvb_dialog_open()
{
	jQuery('body').addClass('mvb_load_dialog');
	initTheEditor('txtInternalComments');
}//end mvb_dialog_open()

function mvb_dialog_close()
{
	jQuery('body').removeClass('mvb_load_dialog');

	if (!detectIE()){
		removeTinyMCE('txtInternalComments');
	}

}//end mvb_dialog_close()

function removeTinyMCE(inst) {


	if(tinyMCE.get(inst)) {
		tinyMCE.execCommand('mceFocus', false, inst);
		tinyMCE.execCommand('mceRemoveEditor', false, inst);
	}
}//removeTinyMce

function detectIE() {
	var ua = window.navigator.userAgent;
	var msie = ua.indexOf('MSIE ');
	var trident = ua.indexOf('Trident/');

	if (msie > 0) {
		// IE 10 or older => return version number
		return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
	}

	if (trident > 0) {
		// IE 11 (or newer) => return version number
		var rv = ua.indexOf('rv:');
		return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
	}

	// other browser
	return false;
}

function initTheEditor(elements)
{

	if (!detectIE()){
		removeTinyMCE(elements);
	}

	removeTinyMCE(elements);

	tinyMCE.init({

		mode                        : 'exact',
		language                    : mvb_l_lang,
		theme                       : "modern",
        "skin": "lightgray",
        "formats": {
            "alignleft": [
                {
                    "selector": "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",
                    "styles": {"textAlign":"left"},
                    "deep": false,
                    "remove": "none"
                },
                {
                    "selector": "img,table,dl.wp-caption",
                    "classes": ["alignleft"],
                    "deep":false,
                    "remove":"none"
                }
            ],
            "aligncenter": [
                {
                    "selector": "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",
                    "styles": {"textAlign":"center"},
                    "deep": false,
                    "remove": "none"
                },
                {
                    "selector": "img,table,dl.wp-caption",
                    "classes": ["aligncenter"],
                    "deep": false,
                    "remove": "none"
                }
            ],
            "alignright": [
                {
                    "selector": "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",
                    "styles": {"textAlign":"right"},
                    "deep": false,
                    "remove": "none"
                },
                {
                    "selector": "img,table,dl.wp-caption",
                    "classes": ["alignright"],
                    "deep": false,
                    "remove": "none"
                }
            ],
            "strikethrough": {"inline":"del","deep":true,"split":true}
        },
        "relative_urls": false,
        "remove_script_host": false,
        "convert_urls": false,
        "browser_spellcheck": true,
        "fix_list_elements": true,
        "entities": "38,amp,60,lt,62,gt",
        "entity_encoding": "raw",
        "keep_styles": false,
        "paste_webkit_styles": "font-weight font-style color",
        "preview_styles": "font-family font-size font-weight font-style text-decoration text-transform",
        "wpeditimage_disable_captions": false,
        "wpeditimage_html5_captions": false,
        "plugins": "charmap,hr,media,paste,tabfocus,textcolor, colorpicker,code, fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpview,image",
        "resize": "vertical",
        "menubar": false,
        "wpautop": true,
        "indent": false,
        "toolbar1": "bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,code, fullscreen,wp_adv",
        "toolbar2": "formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
        "toolbar3": "",
        "toolbar4": "",
        "tabfocus_elements": ":prev,:next",
        "body_class": "apid",
		width                       : 660,
		height                      : 300,
		elements                    : elements
	});


    jQuery(document).on('focusin click', function(e) {
        if (jQuery(event.target).closest("div").length) {
            e.stopPropagation();
        }
    });

}//initTheEditor

function dump(obj) {
	var out = '';
	for (var i in obj) {
		out += i + ": " + obj[i] + "\n";
	}

	alert(out);

	// or, if you wanted to avoid alerts...

	var pre = document.createElement('pre');
	pre.innerHTML = out;
	document.body.appendChild(pre)
}//dump

function mvb_do_asm_select()
{
	var $ = jQuery;
	$('#bshaper_tmp .mvb_asm_field').each(function(the_index){
		var the_field = $('#bshaper_tmp').find('.mvb_asm_field:eq('+the_index+')');

		$( "#"+the_field.attr('id') ).asmSelect({
			addItemTarget: 'top',
			sortable: the_field.attr('data-sortable')
		});
	});

}//end mvb_do_asm_select()