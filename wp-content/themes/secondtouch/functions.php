<?php
/**
 * Crumina themes functions
 */

/*Including other theme components*/

require_once locate_template('/inc/includes.php');

require get_template_directory() . '/css/styles.php';
/**
 * Theme Wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */

// returns WordPress subdirectory if applicable

function wp_base_dir()
{
	preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
	if (count($matches) === 3) {
		return end($matches);
	} else {
		return '';
	}
}

// opposite of built in WP functions for trailing slashes

function leadingslashit($string)
{
	return '/' . unleadingslashit($string);
}

function unleadingslashit($string)
{
	return ltrim($string, '/');
}

function add_filters($tags, $function)
{
	foreach ($tags as $tag) {
		add_filter($tag, $function);
	}
}

function is_element_empty($element)
{
	$element = trim($element);
	return empty($element) ? false : true;
}

// Limit content function
if(!function_exists('content')) {
	function content( $num, $no_more = false ) {
		global $post;
		$options = get_option( 'second-touch' );


		if ( $options['read_more_style'] == '0' ) {
			$read_more_link = '<a href="' . get_permalink( $post->ID ) . '" class="link-read-more"> </a>';
		} else {
			$read_more_link = '<a href="' . get_permalink( $post->ID ) . '"> ' . __( 'Read more', 'crum' ) . '</a>';
		}
		if ( $no_more == true ) {
			$read_more_link = '';
		}

		$post_excerpt = get_post_field( 'post_excerpt', get_the_ID() );
		if ( isset( $post_excerpt ) && ! ( empty( $post_excerpt ) ) ) {
			$post_content = $post_excerpt;
		} else {
			$post_content = strip_tags( get_post_field( 'post_content', get_the_ID() ) );
		}

		$post_content = strip_shortcodes( $post_content );

		$post_text = wp_trim_words( $post_content, $num );

		$content = wpautop( $post_text ) . $read_more_link;

		echo $content;
	}
}
/* Theme setup options*/


// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
register_nav_menus(array(
'primary_navigation' => __('Primary Navigation', 'crum'),
'footer_menu' => __('Footer navigation', 'crum'),
));



// Tell the TinyMCE editor to use a custom stylesheet
add_editor_style('assets/css/editor-style.css');


function mytheme_setup() {
	add_theme_support( 'title-tag' );

	// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
	add_theme_support( 'post-thumbnails' );

// Add post formats (http://codex.wordpress.org/Post_Formats)
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'link' ) );

	load_theme_textdomain( 'crum', get_template_directory() . '/lang' );

//WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );


}

add_action( 'after_setup_theme', 'mytheme_setup' );



add_filter('widget_text', 'do_shortcode');

add_post_type_support('page', 'excerpt');


/*
 * Woocommerce support
 */

// Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {
    woocommerce_related_products(3,3); // Display 4 products in rows of 4
}

// star rating for proucts in loop
add_action( 'woocommerce_after_shop_loop_item', 'wc_product_rating_overview', 15 );
if ( ! function_exists( 'wc_product_rating_overview' ) ) {
    function wc_product_rating_overview() {
        global $product;
        echo '<div class="show">' . $product->get_rating_html() . '</div>';
    }
}


/**
 * Hook in on activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'yourtheme_woocommerce_image_dimensions', 1 );

/**
 * Define image sizes
 */
function yourtheme_woocommerce_image_dimensions() {
    $catalog = array(
        'width' 	=> '280',	// px
        'height'	=> '280',	// px
        'crop'		=> 1 		// true
    );

    $single = array(
        'width' 	=> '430',	// px
        'height'	=> '600',	// px
        'crop'		=> 0 		// true
    );

    $thumbnail = array(
        'width' 	=> '120',	// px
        'height'	=> '120',	// px
        'crop'		=> 1 		// false
    );

    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
    update_option( 'shop_single_image_size', $single ); 		// Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * Enqueue the Souce sans font.
 */
function crumina_enq_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'glider_source_sans', "$protocol://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic,700italic&subset=latin,latin-ext");
}

add_action( 'wp_enqueue_scripts', 'crumina_enq_fonts' );

function custom_excerpt_length( $length ) {
    return 500;
}

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


add_filter('next_posts_link_attributes', 'posts_link_attributes_1');

add_filter('previous_posts_link_attributes', 'posts_link_attributes_2');


function posts_link_attributes_1() {
    return 'class="older"';
}
function posts_link_attributes_2() {
    return 'class="newer"';
}

function performance( $visible = false ) {
    $stat = sprintf(  '%d queries in %.3f seconds, using %.2fMB memory',
        get_num_queries(),
        timer_stop( 0, 3 ),
        memory_get_peak_usage() / 1024 / 1024
    );
    echo $visible ? $stat : "<!-- {$stat} -->" ;
}
add_action( 'wp_footer', 'performance', 20 );



/*---------------------------------------------------------
 *   For theme validator
 ---------------------------------------------------------*/

if ( ! isset( $content_width ) ) $content_width = 900;

/*---------------------------------------------------------
 * Paginate Archive Index Page Links
 ---------------------------------------------------------*/
function crumina_pagination() {
    global $wp_query;

    $big = 999999999; // This needs to be an unlikely integer

    // For more options and info view the docs for paginate_links()
    // http://codex.wordpress.org/Function_Reference/paginate_links
    $paginate_links = paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'mid_size' => 5,
        'prev_next' => True,
        'prev_text' => __('Previous','crum'),
        'next_text' => __('Next','crum'),
        'type' => 'list'
    ) );

    // Display the pagination if more than one page is found
    if ( $paginate_links ) {
        echo '<div class="pagination">';
        echo $paginate_links;
        echo '</div><!--// end .pagination -->';
    }
}

add_theme_support( 'automatic-feed-links' );

//add_theme_support( 'buddypress' );

////////////////////////////////////////////////////////////////////////

update_option('layerslider-validated', '1');

update_option( 'crum_settings','1' );


add_filter( 'add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'crum' ); ?>"><?php echo sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'crum' ), $woocommerce->cart->cart_contents_count ); ?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php

	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;

}

function true_plugins_deactivate() {
	if ( $active_plugins = get_option('active_plugins') ) {
		$deactivate_this = array( // в массиве перечисляем плагины которые хотим деактивировать
			'instagram-plugin/crum-instagram.php',
			'crum-page-slider/crum-page-slider.php',
		);
		$active_plugins = array_diff( $active_plugins, $deactivate_this );
		update_option( 'active_plugins', $active_plugins );
	}
}

add_action( 'admin_init', 'true_plugins_deactivate', 20 );

function crum_z_index(){
	if (is_admin()){
		echo '<style type="text/css">';
		echo '.wp-dialog{z-index:99999 !important;}';
		echo '</style>';
	}
}


add_action ('admin_head', 'crum_z_index', 99);

function crum_vc_add_admin_fonts()
{
	$paths = wp_upload_dir();
	$paths['fonts'] = 'secondtouch_fonts';
	$paths['fonturl'] = trailingslashit($paths['baseurl']) . $paths['fonts'];

	$fonts = get_option('secondtouch_fonts');
	if (is_array($fonts)) {
		foreach ($fonts as $font => $info) {
			$style_url = $info['style'];
			if (strpos($style_url, 'http://') !== false) {
				wp_enqueue_style('crumina-font-' . $font, $info['style']);
			} else {
				wp_enqueue_style('crumina-font-' . $font, trailingslashit($paths['fonturl']) . $info['style']);
			}
		}
	}
}

add_action('admin_enqueue_scripts', 'crum_vc_add_admin_fonts');

function crum_vc_add_front_fonts()
{
	$paths = wp_upload_dir();
	$paths['fonts'] = 'secondtouch_fonts';
	$paths['fonturl'] = trailingslashit($paths['baseurl']) . $paths['fonts'];

	$fonts = get_option('secondtouch_fonts');
	if (is_array($fonts)) {
		foreach ($fonts as $font => $info) {
			$style_url = $info['style'];
			if (strpos($style_url, 'http://') !== false) {
				wp_enqueue_style('crumina-font-' . $font, $info['style']);
			} else {
				wp_enqueue_style('crumina-font-' . $font, trailingslashit($paths['fonturl']) . $info['style']);
			}
		}
	}
}

add_action('wp_enqueue_scripts', 'crum_vc_add_front_fonts');


require_once locate_template('/inc/theme-update/theme-update-checker.php');
$second_update_checker = new ThemeUpdateChecker(
	'secondtouch',
	'http://up.crumina.net/updates.server/wp-update-server/?action=get_metadata&slug=secondtouch'
);

//Disable Visul Composer Update Notification

if ( function_exists( 'vc_set_as_theme' ) ) {
    vc_set_as_theme( $disable_updater = true );
}

if ( is_admin() && class_exists('Metro_Factory') ) { // check to make sure we aren't on the front end
	add_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast');

	function add_custom_to_yoast( $content ) {
		global $post, $mvb_metro_factory;
		$pid = $post->ID;

		$composer_content = get_post_meta($pid,'_bshaper_artist_content', true);

		$custom_content = $mvb_metro_factory->parse_mvb_array($composer_content);

		$content = $content . ' ' . $custom_content;
		return $content;

		remove_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast'); // don't let WP execute this twice
	}
}

add_action( 'wp_enqueue_scripts', 'wcqi_enqueue_polyfill' );
function wcqi_enqueue_polyfill() {
    wp_enqueue_script( 'wcqi-number-polyfill' );
}

function cr_deactivate_plugin_instagramm() {
	if ( is_plugin_active('crum-instagram/crum-instagram.php') ) {
		deactivate_plugins('crum-instagram/crum-instagram.php');
	}
}
add_action( 'admin_init', 'cr_deactivate_plugin_instagramm' );

if(!(function_exists('aq_resize'))){
	function aq_resize($url, $width, $height, $crop = false){
		if ( extension_loaded('gd') ) {
			return mr_image_resize( $url, $width, $height, $crop, 'c', false );
		} else {
			return $url;
		}
	}
}

if(!function_exists('crum_redux_font')){
	function crum_redux_font(){
		wp_enqueue_style('custom-redux', get_template_directory_uri() . '/assets/css/redux-fonts.css', array(), false, 'all');
	}
}

add_action('admin_enqueue_scripts','crum_redux_font');

function second_typography_customization( $tag ) {
	$options = get_option('second-touch');

	$custom_typography = $options[$tag . '_typography' ];

	$custom_css = '';

	if ( 'body' === $tag ) {
		$print_tag = 'body, p, #footer, .page-title-inner .subtitle';
	} else {
		$print_tag = $tag;
	}

	if ( isset( $custom_typography ) && ! ( $custom_typography == '' ) ) {

		if(isset($custom_typography['font-weight']) && !empty($custom_typography['font-weight'])){
			$custom_css .= $print_tag . '{font-weight:' . $custom_typography['font-weight'] . 'px}';
		}

		if(isset($custom_typography['font-style']) && !empty($custom_typography['font-style'])){
			$custom_css .= $print_tag . '{font-style:' . $custom_typography['font-style'] . '}';
		}

		if ( isset( $custom_typography['font-size'] ) && ! ( $custom_typography['font-size'] == '' ) ) {
			$custom_css .= $print_tag . '{font-size:' . $custom_typography['font-size'] . '}';
		}

		if ( isset( $custom_typography['line-height'] ) && ! ( $custom_typography['line-height'] == '' ) ) {
			$custom_css .= $print_tag . '{line-height:' . $custom_typography['line-height'] . '}';
		}

		if ( isset( $custom_typography['color'] ) && ! ( $custom_typography['color'] == '' ) ) {
			$custom_css .= $print_tag . '{color:' . $custom_typography['color'] . '}';
		}

		if ( ! empty( $custom_typography['font-family'] ) && ! ( $custom_typography['font-family'] == 'crum_default' ) ) {
			$custom_css .= $print_tag . '{font-family:' . $custom_typography['font-family'] . ' !important}';
		}
	}

	return $custom_css;

}

