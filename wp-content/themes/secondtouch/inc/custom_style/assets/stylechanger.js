jQuery(document).ready(function ($) { 
	$('.load-def').click(function () {

		if ($('.boxed_layout').hasClass('active')) {
			$('.boxed_layout').removeClass('active');
			$('#change_wrap_div').removeClass('boxed_lay');
			$('.boxed_bg').css('visibility','hidden');
		}
		$('#change_wrap_div, body').css('background','#ffffff');

        /*Main color*/
        $(".first_color .round_color").css("color","#ff6565");

        $("#font_color_1").text('#top-panel .login-header .avatar,article .entry-thumb .comments-link:hover, article.post .link-read-more, .light, .lang-sel ul > li:hover a,.breadcrumbs,.back-to-top, .filter li a:after,#wp-submit.button-primary, #commentform #submit, .pricetable-featured .pricing-table .title,.folio-dopinfo i,.team_member_box .text:before,  article.mini-news .mini-comm-count, .feature-box .back,.recent-block .tabs.horisontal dd a:after,.timelime .timeline-item .timeline-title:after, div.progress .meter,.highlight,.quantity .plus, #content .quantity .plus,.quantity .minus, #content .quantity .minus:hover,article .entry-thumb .comments-link {background-color:#ff6565;} ' +
            'article.post h3.entry-title a:hover, .share-icons a:hover,#comments h3 span,.pages-nav a,.entry-thumb a.link:before,.tabs.horisontal.no-styling dd.active a,.pricing-table .title .icon,.post-carousel-item .icon-format,.featured-news h3.entry-title a:hover,article.mini-news .box-name a:hover,.skills_widget .start-label, .skills_widget .finish-label,.folio-item .box-name:first-letter,.folio-item .box-name a:first-letter,.folio-item .box-name a .animated,.testimonials_item .box-name:first-letter,.instagram-autor .box-name:first-letter,.recent-posts-list .entry-title:first-letter,.recent-posts-list .entry-title .animated,.tags-widget a:hover, ul.products li.product .amount,.widget_shopping_cart .amount,.woocommerce p.stars a:hover:before, .woocommerce-page p.stars a:hover:before, .woocommerce p.stars a:focus:before, .woocommerce-page p.stars a:focus:before,.woocommerce p.stars a.active:before, .woocommerce-page p.stars a.active:before,a:hover, a:focus {color:#ff6565;} ' +
            'article .entry-thumb .comments-link:hover:before {    border-color: #ff6565 transparent transparent transparent; }'+
            'article .entry-thumb .comments-link:before {  border-color: #ff6565) transparent transparent transparent;}'+
            '.author-photo img, #footer .soc-icons a:hover, .charts-box .percent, div.bbp-template-notice, .woocommerce-info { border-color: #ff6565; }'+
            '.feature-block-image .picture:before {  border-color: transparent transparent transparent #ff6565; }');

        /*Secondary color*/
        $(".second_color .round_color").css("color","#47ccec");

        $("#font_color_2").text('.bbp-topic-meta a, td.product-remove a:hover, .product-ordering a:hover,.summary .price, a { color: #47ccec; }'+
            '.pricing-table:hover,#bbpress-forums ul.bbp-forums,#bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-replies,div.bbp-template-notice.info { border-color: #47ccec; } '+
            '.pricing-table:hover::before {border-color: transparent #47ccec transparent transparent;}'+
            '.twitter-row .icon,.page-numbers li:hover a,.page-numbers li a:focus,.page-numbers li.current a,.page-numbers li.current a:hover, .page-numbers li.current a:focus,.page-numbers li span:hover a,.page-numbers li span a:focus,.page-numbers li span.current,.tabs.horisontal dd a,.tabs.horisontal li a,.tabs.vertical dd a,.tabs.vertical li a,.button, #wp-submit, #commentform #submit,.map-holder .box-text,            .accodion_module .title,.contacts-widget,.tweet-list, .twitter-row .icon,.products  .product .button:before, ul.products li.product del .amount,.quantity .plus, #content .quantity .plus:hover,.quantity .minus, #content .quantity .minus { background-color: #47ccec; }');

        return false;

	} );
	
	$('.text_drop .drop_list a').click(function () { 
		var text = $(this).text(), 
			filter_el = $(this).parent().parent().parent().find('.drop_link_in');
		
		$(this).parent().parent().find('>li.current').removeClass('current');
		$(this).parent().addClass('current');
		
		filter_el.attr( { 
			title : text
		} ).text(text);
		
	} );




	$('.changer_button').bind('click', function () { 
		if ($(this).hasClass('active')) {

            $(this).removeClass('active');

			$('.style_changer').animate({right: "0"},'fast');

		} else {
            $(this).addClass('active');

			$('.style_changer').animate({right: "250"},'slow');


		}
		
		return false;
	} );

	/*Setting clorpicker*/
    colorpicker = $.farbtastic("#custom-style-colorpicker");
    $("#custom-style-colorpicker").append("<a class='close'>X</a>");

	jQuery("#tempate-switcher").show();
	
    $("#custom-style-wrapper").on({
        mouseenter:function(){
            $(this).stop();
            $(this).animate({left:0},'fast');
        },
        mouseleave:function(){
            $(this).stop();
            $(this).animate({left:"-290px"},'fast');
            $("#custom-style-colorpicker").hide();
            $(".pattern-select").hide();
            $(".pattern-example.image img").attr("src", customStyleImgUrl + 'title-icon.png');
        }
    });

    $(".template-option").each(function(){
        if( $(this).attr('href') == location.href ){
            $(this).find('img').attr("src", customStyleImgUrl + 'checkbox_1.png' )
        }
    });

    $("#custom-style-colorpicker a.close").on("click",function(){
        $("#custom-style-colorpicker").hide();
    });

	$('.check_wrap label').bind('click', function () {
		if ($('.boxed_layout').hasClass('active')) {
            $('.boxed_layout').removeClass('active');
            $('.wide_layout').addClass('active');
			$('#change_wrap_div').removeClass('boxed_lay');
			$('.boxed_bg').slideUp("fast");
		} else {
			$(this).addClass('active');
            $('.wide_layout').removeClass('active');
			$('#change_wrap_div').addClass('boxed_lay');
			$('.boxed_bg').slideDown("fast");
		}

		return false;
	} );
	

    $(".texture_bg .ch_picker.color").on("click", function(){
        $("#custom-style-colorpicker").show();
        $this = $(this);
        colorpicker.linkTo(function(){
            $('#footer,#sub-footer').css("background-color",colorpicker.color);
        });
        try{
            colorpicker.setColor( rgb2hex( $('#footer,#sub-footer').css("background-color") ) );
        } catch (e){
            console.log($('#footer,#sub-footer').css("background-color"));
        }

        $(".texture_bg .ch_picker.color").removeClass("active");
        $(this).addClass("active");
        $('#footer,#sub-footer').css("background-image","none");

        return false;
    });

	
	$(".boxed_bg .ch_picker").on("click", function(){
		$("#custom-style-colorpicker").show();
		$this = $(this);
		colorpicker.linkTo(function(){
			$('body').css("background-color",colorpicker.color);
		});

		$(".boxed_bg .ch_picker").removeClass("active");
		$(this).addClass("active");
		$('body').css("background-image","none");

        return false;
	});

    $(".body_bg .ch_picker").on("click", function(){
        $("#custom-style-colorpicker").show();
        $this = $(this);
        colorpicker.linkTo(function(){
            $('#change_wrap_div').css("background-color",colorpicker.color);
        });

        $(".body_bg .ch_picker").removeClass("active");
        $(this).addClass("active");
        $('#change_wrap_div').css("background-image","none");

        return false;
    });
	
	$(".first_color .round_color").on("click", function(){
		$("#custom-style-colorpicker").show();
		$this = $(this);
		colorpicker.linkTo(function(){

            $(".first_color .round_color").css("background",colorpicker.color);

			$("#font_color_1").text('#top-panel .login-header .avatar,article .entry-thumb .comments-link:hover, article.post .link-read-more, .light, .lang-sel ul > li:hover a,.breadcrumbs,.back-to-top, .filter li a:after,#wp-submit.button-primary, #commentform #submit, .pricetable-featured .pricing-table .title,.folio-dopinfo i,.team_member_box .text:before,  article.mini-news .mini-comm-count, .feature-box .back,.recent-block .tabs.horisontal dd a:after,.timelime .timeline-item .timeline-title:after, div.progress .meter,.highlight,.quantity .plus, #content .quantity .plus,.quantity .minus, #content .quantity .minus:hover,article .entry-thumb .comments-link {background-color:' + colorpicker.color + ';} ' +
                'article.post h3.entry-title a:hover, .share-icons a:hover,#comments h3 span,.pages-nav a,.entry-thumb a.link:before,.tabs.horisontal.no-styling dd.active a,.pricing-table .title .icon,.post-carousel-item .icon-format,.featured-news h3.entry-title a:hover,article.mini-news .box-name a:hover,.skills_widget .start-label, .skills_widget .finish-label,.folio-item .box-name:first-letter,.folio-item .box-name a:first-letter,.folio-item .box-name a .animated,.testimonials_item .box-name:first-letter,.instagram-autor .box-name:first-letter,.recent-posts-list .entry-title:first-letter,.recent-posts-list .entry-title .animated,.tags-widget a:hover, ul.products li.product .amount,.widget_shopping_cart .amount,.woocommerce p.stars a:hover:before, .woocommerce-page p.stars a:hover:before, .woocommerce p.stars a:focus:before, .woocommerce-page p.stars a:focus:before,.woocommerce p.stars a.active:before, .woocommerce-page p.stars a.active:before,a:hover, a:focus {color:' + colorpicker.color + ';} ' +
                'article .entry-thumb .comments-link:hover:before {    border-color: ' + colorpicker.color + ' transparent transparent transparent; }'+
                'article .entry-thumb .comments-link:before {  border-color: ' + colorpicker.color + ') transparent transparent transparent;}'+
                '.author-photo img, #footer .soc-icons a:hover, .charts-box .percent, div.bbp-template-notice, .woocommerce-info { border-color: ' + colorpicker.color + '; }'+
                '.feature-block-image .picture:before {  border-color: transparent transparent transparent ' + colorpicker.color + '; }');
        });

        return false;

	});

	$(".second_color .round_color").on("click", function(){
		$("#custom-style-colorpicker").show();
		$this = $(this);
		colorpicker.linkTo(function(){

            $(".second_color .round_color").css("color",colorpicker.color);

            $("#font_color_2").text('.bbp-topic-meta a, td.product-remove a:hover, .product-ordering a:hover,.summary .price, a { color: ' + colorpicker.color + '; }'+
                '.pricing-table:hover,#bbpress-forums ul.bbp-forums,#bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-replies,div.bbp-template-notice.info { border-color: ' + colorpicker.color + '; } '+
                '.pricing-table:hover::before {border-color: transparent ' + colorpicker.color + ' transparent transparent;}'+
                '.twitter-row .icon,.page-numbers li:hover a,.page-numbers li a:focus,.page-numbers li.current a,.page-numbers li.current a:hover, .page-numbers li.current a:focus,.page-numbers li span:hover a,.page-numbers li span a:focus,.page-numbers li span.current,.tabs.horisontal dd a,.tabs.horisontal li a,.tabs.vertical dd a,.tabs.vertical li a,.button, #wp-submit, #commentform #submit,.map-holder .box-text,            .accodion_module .title,.contacts-widget,.tweet-list, .twitter-row .icon,.products  .product .button:before, ul.products li.product del .amount,.quantity .plus, #content .quantity .plus:hover,.quantity .minus, #content .quantity .minus { background-color: ' + colorpicker.color + '; }');
		});

        return false;

	});
	
    /*Background image switching*/
    $(".boxed_bg .pattern-example.pic").on("click", function(){
        $(this).closest(".pattern-select").find(".pattern-example.pic").removeClass("current");
        $(this).addClass("current");
        var pic = $(this).find("img").attr("src");
        $('body').css("background-image", "url(" + pic.split("thumb/").join("") + ")").css("background-repeat","repeat");

    });

    /*Background image switching*/
    $(".body_bg .pattern-example.pic").on("click", function(){
        $(this).closest(".pattern-select").find(".pattern-example.pic").removeClass("current");
        $(this).addClass("current");
        var pic = $(this).find("img").attr("src");
        $('#change_wrap_div').css("background-image", "url(" + pic.split("thumb/").join("") + ")").css("background-repeat","repeat");

    });

    /*Background image switching*/
    $(".texture_bg .pattern-example.pic").on("click", function(){
        $(this).closest(".pattern-select").find(".pattern-example.pic").removeClass("current");
        $(this).addClass("current");
        var pic = $(this).find("img").attr("src");
        $('#footer, #sub-footer').css("background-image", "url(" + pic.split("thumb/").join("") + ")").css("background-repeat","repeat");

        return false;
    });
	
	var imagesForPreload = new Array();
	$(".pattern-select:eq(0) .pattern-example.pic img").each(function(){
		imagesForPreload.push( $(this).attr("src") );
	});

	preload( imagesForPreload );

} );

/*RGB to HEX */
var hexDigits = new Array
    ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");


function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}

function preload(arrayOfImages) {
    jQuery(arrayOfImages).each(function(){
        jQuery('<img/>')[0].src = this;
        // Alternatively you could use:
        // (new Image()).src = this;
    });
}