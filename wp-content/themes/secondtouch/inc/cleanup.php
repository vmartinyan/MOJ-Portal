<?php

define('THEME_UPDATES_URL', 'http://dev.crumina.net/verifier.php');

/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */
function crum_head_cleanup()
{
    // Originally from http://wpengineer.com/1438/wordpress-header/
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


    add_filter('use_default_gallery_style', '__return_null');


}

function crum_rel_canonical()
{
    global $wp_the_query;

    if (!is_singular()) {
        return;
    }

    if (!$id = $wp_the_query->get_queried_object_id()) {
        return;
    }

    $link = get_permalink($id);
    echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

add_action('init', 'crum_head_cleanup');

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');

/**
 * Clean up output of stylesheet <link> tags
 */
function crum_clean_style_tag($input)
{
    preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
    // Only display media if it's print
    $media = $matches[3][0] === 'print' ? ' media="print"' : '';
    return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

add_filter('style_loader_tag', 'crum_clean_style_tag');

/**
 * Add and remove body_class() classes
 */
function crum_body_class($classes)
{

    // Add post/page slug

    if (is_single() || is_page() && !is_front_page()) {
        $classes[] = basename(get_permalink());
    }

    // Remove unnecessary classes
    $home_id_class = 'page-id-' . get_option('page_on_front');
    $remove_classes = array(
        'page-template-default',
        $home_id_class
    );
    $classes = array_diff($classes, $remove_classes);

    return $classes;
}

add_filter('body_class', 'crum_body_class');

/**
 * Relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function crum_root_relative_url($input)
{
    $output = preg_replace_callback(
        '!(https?://[^/|"]+)([^"]+)?!',
        create_function(
            '$matches',
            // If full URL is home_url("/") and this isn't a subdir install, return a slash for relative root
            'if (isset($matches[0]) && $matches[0] === home_url("/") && str_replace("http://", "", home_url("/", "http"))==$_SERVER["HTTP_HOST"]) { return "/";' .
                // If domain is equal to home_url("/"), then make URL relative
                '} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
                // If domain is not equal to home_url("/"), do not make external link relative
                '} else { return $matches[0]; };'
        ),
        $input
    );

    return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function crum_fix_duplicate_subfolder_urls($input)
{
    $output = crum_root_relative_url($input);
    preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

    if (isset($matches[1][0]) && isset($matches[2][0])) {
        if ($matches[1][0] === $matches[2][0]) {
            $output = substr($output, strlen($matches[1][0]) + 1);
        }
    }

    return $output;
}

function crum_enable_root_relative_urls()
{
    return !(is_admin() && in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) && current_theme_supports('root-relative-urls');
}

if (crum_enable_root_relative_urls()) {
    $root_rel_filters = array(
        'bloginfo_url',
        'theme_root_uri',
        'stylesheet_directory_uri',
        'template_directory_uri',
        'plugins_url',
        'the_permalink',
        'wp_list_pages',
        'wp_list_categories',
        'wp_nav_menu',
        'the_content_more_link',
        'the_tags',
        'get_pagenum_link',
        'get_comment_link',
        'month_link',
        'day_link',
        'year_link',
        'tag_link',
        'the_author_posts_link'
    );

    add_filters($root_rel_filters, 'roots_root_relative_url');

    add_filter('script_loader_src', 'crum_fix_duplicate_subfolder_urls');
    add_filter('style_loader_src', 'crum_fix_duplicate_subfolder_urls');
}

/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 *//*
function crum_embed_wrap($cache, $url, $attr = '', $post_ID = '')
{
    return '<div class="entry-content-asset">' . $cache . '</div>';
}

add_filter('embed_oembed_html', 'crum_embed_wrap', 10, 4);
add_filter('embed_googlevideo', 'crum_embed_wrap', 10, 2);

/**
 * Add class="thumbnail" to attachment items
 */
function crum_attachment_link_class($html)
{
    $postid = get_the_ID();
    $html = str_replace('<a', '<a class="thumbnail"', $html);
    return $html;
}

add_filter('wp_get_attachment_link', 'crum_attachment_link_class', 10, 1);

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function crum_caption($output, $attr, $content)
{
    if (is_feed()) {
        return $output;
    }

    $defaults = array(
        'id' => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => ''
    );

    $attr = shortcode_atts($defaults, $attr);

    // If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
    if ($attr['width'] < 1 || empty($attr['caption'])) {
        return $content;
    }

    // Set up the attributes for the caption <figure>
    $attributes = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '');
    $attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
    $attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';

    $output = '<figure' . $attributes . '>';
    $output .= do_shortcode($content);
    $output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
    $output .= '</figure>';

    return $output;
}

add_filter('img_caption_shortcode', 'crum_caption', 10, 3);

/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function roots_remove_dashboard_widgets()
{
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}

add_action('admin_init', 'roots_remove_dashboard_widgets');

/**
 * Clean up the_excerpt()
 */


function crum_excerpt_more($more)
{

    return '';
}

add_filter('excerpt_more', 'crum_excerpt_more');

/**
 * Allow more tags in TinyMCE including <iframe> and <script>
 */
function crum_change_mce_options($options)
{
    $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

    if (isset($initArray['extended_valid_elements'])) {
        $options['extended_valid_elements'] .= ',' . $ext;
    } else {
        $options['extended_valid_elements'] = $ext;
    }

    return $options;
}

add_filter('tiny_mce_before_init', 'crum_change_mce_options');


/**
 * Fix for get_search_query() returning +'s between search terms
 */
function crum_search_query($escaped = true)
{
    $query = apply_filters('crum_search_query', get_query_var('s'));

    if ($escaped) {
        $query = esc_attr($query);
    }

    return urldecode($query);
}

add_filter('get_search_query', 'crum_search_query');

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function crum_request_filter($query_vars)
{
    if (isset($_GET['s']) && empty($_GET['s'])) {
        $query_vars['s'] = 'Empty';
    }

    return $query_vars;
}

add_filter('request', 'crum_request_filter');