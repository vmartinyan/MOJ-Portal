<?php
/**
 * Scripts and stylesheets
 */

function curum_scripts() {

    $options = get_option('second-touch');
    $uploads = wp_upload_dir();
    $css_dir = get_template_directory_uri() . '/css/'; // Shorten code, save 1 call

    /** Save on different directory if on multisite **/
    if(is_multisite()) {
        $aq_uploads_dir = trailingslashit($uploads['baseurl']);
    } else {
        $aq_uploads_dir = $css_dir;
    }

    /*
     * Css styles
     */

    wp_enqueue_style('foundation', get_template_directory_uri() . '/assets/css/foundation.css', false, null);
    wp_enqueue_style('crum_site_style', get_template_directory_uri() . '/assets/css/app.css', false, null);

    wp_enqueue_style('crum_effects_css', get_template_directory_uri() . '/assets/css/animate-custom.css', false, null);

	//slick styles
	wp_register_style('slick_slider_css', get_template_directory_uri() . '/assets/css/slick.css', false, null);

    /**
     * Check if WooCommerce is active
     **/
	if ( class_exists('woocommerce')  ) {
		wp_enqueue_style('woocommerce-css', get_template_directory_uri() . '/assets/css/woocommerce.css', false, null);
	}

    if ( in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        wp_enqueue_style('crum_visul_composer', get_template_directory_uri() . '/assets/css/visual-composer.css', false, null);
    }

    wp_enqueue_style('crum_bbpress', get_template_directory_uri() . '/assets/css/bbpress.css', false, null);
    wp_enqueue_style('isotope_style', get_template_directory_uri() . '/assets/css/jquery.isotope.css', false, null);
    wp_enqueue_style('flexslider_style', get_template_directory_uri() . '/assets/css/flexslider.css', false, null);

    if (isset($options['responsive_mode']) && ($options['responsive_mode'] != 'off')) {
        wp_enqueue_style('second_responsive', get_template_directory_uri() . '/assets/css/responsive.css', false, null);
    }

    wp_enqueue_style('prettyphoto_style', get_template_directory_uri() . '/assets/css/prettyPhoto.css', false, null);

	wp_enqueue_style('crum_theme_options', $aq_uploads_dir . 'options.css?'.filemtime(get_template_directory() . '/css/options.css'), false, null);

    /*
     * JS register
     */
    wp_register_script('crum_modernizr', get_template_directory_uri() . '/assets/js/modernizr.foundation.js', false, null, false);
    wp_register_script('crum_foundation', get_template_directory_uri() . '/assets/js/foundation.min.js', false, null, true);

    wp_register_script('smooth-scroll', get_template_directory_uri() . '/assets/js/jquery.smothscroll.min.js', false, '1.4.11', true);
    wp_register_script('crum_main', get_template_directory_uri() . '/assets/js/app.js', false, null, true);

    wp_register_script('crum_animation_js', get_template_directory_uri() . '/assets/js/animation.js', false, null, true);

    wp_register_script('isotope', ''.get_template_directory_uri().'/assets/js/jquery.isotope.min.js', false, null, true);
	wp_register_script('imagesloaded', ''.get_template_directory_uri().'/assets/js/imagesloaded.pkgd.min.js', false, null, true);
    wp_register_script('isotope-run', ''.get_template_directory_uri().'/assets/js/jquery.isotope.run.js', false, null, true);
    wp_register_script('js-masonry', ''.get_template_directory_uri().'/assets/js/jquery.masonry.min.js', true, null, false);
    wp_register_script('flexslider', ''.get_template_directory_uri().'/assets/js/jquery.flexslider-min.js', false, null, true);
    wp_register_script('gmap3', ''.get_template_directory_uri().'/assets/js/gmap3.min.js', false, null, true);
    wp_register_script('prettyphoto', ''.get_template_directory_uri().'/assets/js/jquery.prettyPhoto.js', false, null, true);
    wp_register_script('qr_code', ''.get_template_directory_uri().'/assets/js/qrcode.min.js', false, null, false);
    wp_register_script('custom-share', ''.get_template_directory_uri().'/assets/js/jquery.sharrre-1.3.4.min.js', array('jquery'), '1.3.4', false);

	//slickslider
	wp_register_script('slick_slider_js', ''.get_template_directory_uri().'/assets/js/slick.min.js', false, null, true);




    /*
     * JS enquene
     */

    wp_enqueue_script('jquery');
    wp_enqueue_script('crum_foundation');

	wp_enqueue_script('imagesloaded');

    wp_enqueue_script('flexslider');

    wp_enqueue_script('crum_animation_js');


    if ($options['scroll_animation'] != 'off') {
        wp_enqueue_script('smooth-scroll');
    }

    if (is_page_template('page-contacts.php')){
        wp_enqueue_script('qr_code');
        wp_enqueue_script('gmap3');
    }

        $slug = 'my-product';

    if ( is_singular( array( $slug ) ) ) {
        wp_enqueue_script('custom-share');
    }

    $typography_custom_fonts = polo_custom_google_fonts_list();
    foreach ( $typography_custom_fonts as $tag => $single_font ) {
        if ( isset( $single_font['font-family'] ) && ! ( 'crum_default' === $single_font['font-family'] ) ) {
            $typography_selected_styles = 'latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
            $enqueue_fonts              = $single_font['font-family'] . '&subset=' . $typography_selected_styles;
            wp_enqueue_style( 'crum-typo-google-fonts-' . $tag, esc_url( add_query_arg( 'family', ( $enqueue_fonts ), 'https://fonts.googleapis.com/css' ) ), array(), null );
        }
    }

    wp_enqueue_script('crum_main');
    //wp_enqueue_script('jquery-color');
    wp_enqueue_script('prettyphoto');


}


function crum_admin_css()
{
    wp_register_style( 'crum-admin-style', get_template_directory_uri() . '/assets/css/admin-panel.css' );
    wp_enqueue_style( 'crum-admin-style' );
}


function polo_custom_google_fonts_list() {
    $google_fonts = array();
    $options = get_option('second-touch');
    $tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );

	$google_fonts['body'] = isset( $options['body-typography'] ) ? $options['body-typography'] : '';
	foreach ( $tags as $single_tag ) {
		$google_fonts[ $single_tag ] = isset( $options[ $single_tag . '-typography' ] ) ? $options[ $single_tag . '-typography' ] : '';
	}

    if ( isset( $page_meta['body-typography'] ) && ! empty( $page_meta['body-typography'] ) && ! ( 'crum_default' === $page_meta['body-typography']['family'] ) ) {
        $google_fonts['body'] = $page_meta['body-typography'];
    }

    foreach ( $tags as $single_tag ) {
        if ( isset( $page_meta[ $single_tag . '-typography' ] ) && ! empty( $page_meta[ $single_tag . '-typography' ] ) && ! ( 'crum_default' === $page_meta[ $single_tag . '-typography' ]['family'] ) ) {
            $google_fonts[ $single_tag ] = $page_meta[ $single_tag . '-typography' ];
        }
    }

    return $google_fonts;
}


add_action('wp_enqueue_scripts', 'curum_scripts', 50);

add_action( 'admin_head', 'crum_admin_css' );


