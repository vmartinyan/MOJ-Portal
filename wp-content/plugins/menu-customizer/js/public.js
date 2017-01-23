jQuery(document).ready( function () {

    /*!
     * jQuery Double Tap To Go - v1.0.0 - 2015-04-20
     * http://github.com/zenopopovici/DoubleTapToGo
     * Copyright (c) 2015 Graffino
     */
    !function($,window,document,undefined){$.fn.doubleTapToGo=function(action){return"ontouchstart"in window||navigator.msMaxTouchPoints||navigator.userAgent.toLowerCase().match(/windows phone os 7/i)?(this.each("unbind"===action?function(){$(this).off(),$(document).off("click touchstart MSPointerDown",handleTouch)}:function(){function handleTouch(e){for(var resetItem=!0,parents=$(e.target).parents(),i=0;i<parents.length;i++)parents[i]==curItem[0]&&(resetItem=!1);resetItem&&(curItem=!1)}var curItem=!1;$(this).on("click",function(e){var item=$(this);item[0]!=curItem[0]&&(e.preventDefault(),curItem=item)}),$(document).on("click touchstart MSPointerDown",handleTouch)}),this):!1}}(jQuery,window,document);

    var isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
    if (! isSafari){
        jQuery('li.has-submenu').doubleTapToGo();
    }


    jQuery(".main-menu-item, .menu-item, .sub-menu-item").hover(function () {
        jQuery(this).addClass("hovered");
    }, function () {
        jQuery(this).removeClass("hovered");
    });

    jQuery('.metro-menu-item').each(function() {
        var $tile = jQuery(this).find('.menu-tile');
        if ($tile.data('inherit-color')){
            jQuery(this).find('.sub-menu li').css('background',$tile.data('inherit-color'));
        }
    });
});