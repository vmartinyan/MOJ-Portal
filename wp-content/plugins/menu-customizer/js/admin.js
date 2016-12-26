(function ($) {
	"use strict";
	$(function () {

        /**
         *  Menu selection
         */


        $('#menu-list').change(function () {
            $('#save_menu').click();
        });


        /**
         *  Colorpicker for BG color customization
         */

        $(document).ready(function(){

            var myOptions = {

                defaultColor: false,

                change: function (event, ui) {
                    var color = $( this ).val();
                    $(this).parents('.metro-menu-item').find('.menu-tile').css( "background-color", color );
                },

                clear: function() {},

                hide: true,

                palettes: true

            };

            $('.metro-item-color').wpColorPicker(myOptions);

        });

        /**
         *  Media uploader for BG image customization
         */

        var tgm_media_frame;
        var image_field;

        $(document.body).on('click', '.add-item-image', function(e){

            image_field = $(this).siblings('.metro-item-image');

            e.preventDefault();

            if ( tgm_media_frame ) {
                tgm_media_frame.open();
                return;
            }

            tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({

                frame: 'select',

                multiple: false,

                library: {
                    type: 'image'
                }

            });

            tgm_media_frame.on('select', function(){

                var media_attachment = tgm_media_frame.state().get('selection').first().toJSON();

                var image_link = media_attachment.url;

                $(image_field).val(image_link);

                $(image_field).parents('.metro-menu-item').find('.menu-tile').css("background-image", 'url(' + image_link + ')');

            });

            tgm_media_frame.open();
        });


        // Background image remove

        jQuery(".remove-item-image").on("click",function(){
            $(this).siblings('.metro-item-image').val("");
            $(this).parents('.metro-menu-item').find('.menu-tile').css("background-image","none");

            return false;
        });


        /**
         *  Icon customization
         */

        $( ".mnky-generator-insert" ).on("click",function(){
            var icon = $(".iconname").val();
            $(this).parents('.metro-menu-item').find('.tile-icon').addClass(icon);
        });

        $(".crum-icon-remove").on("click",function(){
            var icon = $(this).siblings('.iconname').val();
            $(this).siblings('.iconname').val("");
            $(this).parents('.metro-menu-item').find('.tile-icon').removeClass(icon);

            return false;
        });


	});





}(jQuery));


