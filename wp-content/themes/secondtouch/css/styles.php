<?php
//Function parses header styles


if ( ! function_exists( 'cr_hex2rgb' ) ) {
	function cr_hex2rgb( $hex ) {
		$hex = str_replace( "#", "", $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array( $r, $g, $b );

		return implode( ",", $rgb ); // returns the rgb values separated by commas
		//return $rgb; // returns an array with the rgb values
	}
}

add_action( 'wp_enqueue_scripts', 'crum_custom_css', 99 );

function crum_custom_css() {

	$options = get_option( 'second-touch' );

	$custom_css = '';

	/*
	 * Backgrounds
	 */
	//For content
	if ( $options["wrapper_bg_color"] ) {
		$custom_css .= '#change_wrap_div{ background-color: ' . $options["wrapper_bg_color"] . '}  ';
	}
	if (isset($options["wrapper_bg_image"]) &&  ! array($options["wrapper_bg_image"])){
		$options["wrapper_bg_image"] = array('url' => $options["wrapper_bg_image"]);
	}
	if (isset($options["wrapper_bg_image"]['url']) && !empty($options["wrapper_bg_image"]['url']) ) {
		$custom_css .= '#change_wrap_div{ background-image: url("' . $options["wrapper_bg_image"]['url'] . '")} ';
	}
	if ( $options["wrapper_custom_repeat"] ) {
		$custom_css .= '#change_wrap_div{ background-repeat: ' . $options["wrapper_custom_repeat"] . ' !important} ';
	}

	//For boxed style body
	if ( $options["body_bg_color"] ) {
		$custom_css .= 'body{ background-color: ' . $options["body_bg_color"] . '} ';
		if ( ! isset( $options["wrapper_bg_color"] ) || ( $options["wrapper_bg_color"] == '' ) ) {
			$custom_css .= '#change_wrap_div{ background-color: #fff}  ';
		}
	}
	if (isset($options["body_bg_image"]) &&  ! array($options["body_bg_image"])){
		$options["body_bg_image"] = array('url' => $options["body_bg_image"]);
	}
	if ( isset($options["body_bg_image"]['url']) && !empty($options["body_bg_image"]['url'])) {
		$custom_css .= 'body{ background-image: url("' . $options["body_bg_image"]['url'] . '")} ';
		if ( ! isset( $options["wrapper_bg_color"] ) || ( $options["wrapper_bg_color"] == '' ) ) {
			$custom_css .= '#change_wrap_div{ background-color: #fff}  ';
		}
	}
	if ( $options["body_custom_repeat"] ) {
		$custom_css .= 'body{ background-repeat: ' . $options["body_custom_repeat"] . '} ';
	}
	if ( $options["body_bg_fixed"] ) {
		$custom_css .= 'body{ background-attachment: fixed;} ';
	}

	if ( $options["footer_font_color"] ) {
		$custom_css .= '#footer, #footer .contacts-widget p, #sub-footer{ color: ' . $options["footer_font_color"] . '} ';
	}
	if ( $options["footer_bg_color"] ) {
		$custom_css .= '#footer, #sub-footer{ background-color: ' . $options["footer_bg_color"] . '} ';
	}
	if (isset($options["footer_bg_image"]) &&  ! array($options["footer_bg_image"])){
		$options["footer_bg_image"] = array('url' => $options["footer_bg_image"]);
	}
	if ( isset($options["footer_bg_image"]['url']) && !empty($options["footer_bg_image"]['url'])) {
		$custom_css .= '#footer, #sub-footer{ background-image: url("' . $options["footer_bg_image"]['url'] . '")} ';
	}
	if ( $options["footer_custom_repeat"] ) {
		$custom_css .= '#footer, #sub-footer{ background-repeat: ' . $options["footer_custom_repeat"] . '} ';
	}

	if ( $options["stan_header"] == '0' ) {
		$custom_css .= '.page-title-inner{color:inherit !important}';
	}

	if ( $options['stan_header_font_color'] ) {

		$custom_css .= '.page-title-inner .page-title {color: ' . $options['stan_header_font_color'] . '}';
		$custom_css .= '.page-title-inner .subtitle {color: ' . $options['stan_header_font_color'] . '}';


	}

	$layout_width       = $options['full_width_layout_width'];
	$layout_width_units = $options['width_units'];

	$meta_layout_width = get_post_meta(get_the_ID(),'meta_full_width_layout_width',true);
	$meta_width_units = get_post_meta(get_the_ID(),'meta_width_units',true);

	if(isset($meta_layout_width) && !empty($meta_layout_width)){
		$layout_width = $meta_layout_width;
	}

	if(isset($meta_width_units) && !empty($meta_width_units) && !('default' === $meta_width_units)){
		if ( 'px' === $meta_width_units ) {
			$layout_width_units = '0';
		} elseif('percent' === $meta_width_units) {
			$layout_width_units = '1';
		}
	}

	if ( isset( $layout_width ) && ( $layout_width > 0 ) ) {
		if ( '1' === $layout_width_units ) {
			$custom_css .= '.row {width:' . $layout_width . '%}';
			$custom_css .= '#change_wrap_div {width:' . ( $layout_width ) . '%; margin: 0 auto;}';
			$custom_css .= '.crumina-slider-wrap {padding: 24px 10px;}';
		} else {
			$custom_css .= '.row {width:' . $layout_width . 'px}';
			$custom_css .= '#change_wrap_div {width:' . ( $layout_width + 20 ) . 'px; margin: 0 auto;}';
			$custom_css .= '.crumina-slider-wrap {padding: 24px 10px;}';
		}

	}

	/*
 * Main theme color
 */

	if ( ( $options["main_site_color"] ) && ( $options["main_site_color"] != "#ff6565" ) ) {

		$custom_css .= '.tabs dd a, .tabs li a {
		border-right: 1px solid #ffffff;
		}

		article.post h3.entry-title a:hover,
		.share-icons a:hover,
		#comments h3 span,
		.pages-nav a,
		.entry-thumb a.link:before,
		.tabs.horisontal.no-styling dd.active a,
		.pricing-table .title .icon,
		.post-carousel-item .icon-format,
		.featured-news h3.entry-title a:hover,
		article.mini-news .box-name a:hover,
		.skills_widget .start-label, .skills_widget .finish-label,
		.folio-item .box-name:first-letter,
		.folio-item .box-name a:first-letter,
		.folio-item .box-name a .animated,
		.testimonials_item .box-name:first-letter,
		.instagram-autor .box-name:first-letter,
		.recent-posts-list .entry-title:first-letter,
		.recent-posts-list .entry-title .animated,
		.tags-widget a:hover,
		ul.products li.product .amount,
		.widget_shopping_cart .amount,
		.woocommerce p.stars a:hover:before, .woocommerce-page p.stars a:hover:before, .woocommerce p.stars a:focus:before, .woocommerce-page p.stars a:focus:before,
		.woocommerce p.stars a.active:before, .woocommerce-page p.stars a.active:before,
		a:hover, a:focus,
		.crumina-slider-wrap .item-content .icon-format,
		.crumina-slider-wrap .entry-title a:hover,
		.news-row .entry-thumb .mini-comm-count:before,
		.hover-box .more-link:before,
		.hover-box .zoom-link:before,
		.hover-box .like:before, .woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before';

		$custom_css .= '{ color: ' . $options["main_site_color"] . ' }';

		$custom_css .= '
		#top-panel .login-header .avatar,
		article .entry-thumb .comments-link:hover,
		article.post .link-read-more,
		.light,
		.lang-sel ul > li:hover a,
		.breadcrumbs,
		.back-to-top,
		.filter li a:after,
		#wp-submit.button-primary, #commentform #submit,
		.pricetable-featured .pricing-table .title,
		.folio-dopinfo i,
		.team_member_box .text:before,
		article.mini-news .mini-comm-count,
		.feature-box .back,
		.recent-block .tabs.horisontal dd a:after,
		.timelime .timeline-item .timeline-title:after,
		div.progress .meter,
		.highlight,
		.quantity .plus, #content .quantity .plus,
		.quantity .minus, #content .quantity .minus:hover,
		.pricing-table .cta-button .button.red,
		.crumina-slider-wrap .active .click-section,
		.tabs.vertical dd.active a,
		.tabs.vertical dd a .icon,
		.tabs.vertical dd.active .icon,
		.top-menu-button.active, article .entry-thumb .comments-link:hover .comments-link:hover:before';

		$custom_css .= '{ background-color: ' . $options["main_site_color"] . '}';

		$custom_css .= 'article .entry-thumb .comments-link:hover:before {
		border-color: ' . $options["main_site_color"] . ' transparent transparent transparent;
		background-color: ' . $options["main_site_color"] . ' transparent transparent transparent;
		}';

		$custom_css .= 'article .entry-thumb .comments-link
		{
		background: ' . $options["main_site_color"] . ';
		background: rgba(' . cr_hex2rgb( $options["main_site_color"] ) . ', 0.7);
		}';


		$custom_css .= '.crumina-slider-wrap .cat-name
		{
		background: ' . $options["main_site_color"] . ';
		background: rgba(' . cr_hex2rgb( $options["main_site_color"] ) . ', 0.6);
		}

		.crumina-slider-wrap .cat-name:hover {
		background: ' . $options["main_site_color"] . ';
		background: rgba(' . cr_hex2rgb( $options["main_site_color"] ) . ', 1);
		}

		article .entry-thumb .comments-link:before {
		border-color: ' . $options["main_site_color"] . ' transparent transparent transparent;
		border-color: rgba(' . cr_hex2rgb( $options["main_site_color"] ) . ', 0.7) transparent transparent transparent;
		}

		article .entry-thumb .comments-link:hover:before {
		border-color: ' . $options["main_site_color"] . ' transparent transparent transparent;
		border-color: rgba(' . cr_hex2rgb( $options["main_site_color"] ) . ', 0.7) transparent transparent transparent;
		}

		#crum-slider .item .item-content-metro {
		background: ' . $options["main_site_color"] . ';
		background: rgba(' . cr_hex2rgb( $options["main_site_color"] ) . ', 0.87);
		}

		.author-photo img {
		border-bottom: 3px solid ' . $options["main_site_color"] . '; }

		#footer .soc-icons a:hover,
		.charts-box .percent
		{
		border-bottom: 2px solid ' . $options["main_site_color"] . '; }

		#wp-submit.button-primary, #commentform #submit {box-shadow:none !important;}

		.feature-block-image .picture:before {
		border-color: transparent transparent transparent ' . $options["main_site_color"] . ';
		}

		div.bbp-template-notice
		{border-left: 3px solid ' . $options["main_site_color"] . ' !important;}

		.woocommerce-info {
		border-top: 3px solid ' . $options["main_site_color"] . '
		}

		.pricing-table .cta-button .button.red {box-shadow:none !important;}';

	}

	if ( ( $options["secondary_site_color"] ) && ( $options["secondary_site_color"] != "#36bae2" ) ) {

		$custom_css .= '
		.twitter-row .icon,
		.page-numbers li:hover a,
		.page-numbers li a:focus,
		.page-numbers li.current a,
		.page-numbers li.current a:hover, .page-numbers li.current a:focus,
		.page-numbers li span:hover a,
		.page-numbers li span a:focus,
		.page-numbers li span.current,
		.tabs.horisontal dd a,
		.tabs.horisontal li a,
		.tabs.vertical dd a,
		.tabs.vertical li a,
		.button, #wp-submit, #commentform #submit,
		.map-holder .box-text,
		.accodion_module .title,
		.contacts-widget,
		.tweet-list,
		.twitter-row .icon,
		.products  .product .button:before,
		ul.products li.product del .amount,
		.quantity .plus, #content .quantity .plus:hover,
		.quantity .minus, #content .quantity .minus


		{background-color:' . $options["secondary_site_color"] . ';}


		.bbp-topic-meta a,
		td.product-remove a:hover,
		.product-ordering a:hover,
		.summary .price,
		a
		{color:' . $options["secondary_site_color"] . ';}

		.pricing-table:hover
		{border: 2px solid ' . $options["secondary_site_color"] . ' }

		.pricing-table:hover::before {border-color: transparent ' . $options["secondary_site_color"] . ' transparent transparent;}

		#bbpress-forums ul.bbp-forums,#bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-replies {
		border-top: 3px solid ' . $options["secondary_site_color"] . ';
		}
		div.bbp-template-notice.info

		{border-left: 3px solid ' . $options["secondary_site_color"] . ' !important;}


		#crum-slider .item.even .item-content-metro {
		background: ' . $options["secondary_site_color"] . ';
		background: rgba(' . cr_hex2rgb( $options["secondary_site_color"] ) . ' , 0.87);

		}

		.button, #wp-submit, #commentform #submit, .pricing-table .cta-button .button.red {box-shadow:none !important;}';


	}

	if ( $options["font_site_color"] ) {

		$custom_css .= '
		article.post h3.entry-title,
		.author-description > h4 span,
		.comment-author .dop-link a,
		.tabs dd.active a,
		.tabs li.active a,
		.pricing-table .title,
		.pricing-table .bullet-item,
		.folio-dopinfo,
		.to-action-block .description,
		.news-row .box-name,
		.featured-news h3.entry-title,
		.skills_widget .skill-item .item-title .title,
		.list-box .feature-box.al-left li,
		.recent-block .tabs.horisontal dd a:hover,
		.recent-block .tabs.horisontal dd.active a,
		body,
		h1, h2, h3, h4, h5, h6,
		.block-title,
		.box-name,
		.dopinfo, .dopinfo a,
		.dopinfo a:hover, .entry-meta .author a,
		code, pre,
		table thead tr th, table tfoot tr td,
		table tbody tr td,
		abbr, acronym,
		ul.products li.product h3,
		ul.products li.product .prod-cat,
		ul.products li.product .prod-details,
		ul.products li.product .prod-details i,
		ul.products li.product .button,
		.woocommerce-message, .woocommerce-error, .woocommerce-info,
		.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before,
		ul.cart_list li a, ul.product_list_widget li a
		{color:' . $options["font_site_color"] . '}';

	}

	$custom_css .= second_typography_customization( 'h1' );
	$custom_css .= second_typography_customization( 'h2' );
	$custom_css .= second_typography_customization( 'h3' );
	$custom_css .= second_typography_customization( 'h4' );
	$custom_css .= second_typography_customization( 'h5' );
	$custom_css .= second_typography_customization( 'h6' );
	$custom_css .= second_typography_customization( 'body' );

	if ( isset($options['custom_css']) && !empty($options['custom_css']) ) {
		$custom_css .= $options["custom_css"];
	}

	wp_add_inline_style( 'crum_site_style', $custom_css );

}