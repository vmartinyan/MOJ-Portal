<?php
/**
 * Plugin Name.
 *
 * @package   Crumina page slider
 * @author    Liondekam <liondekam@gmail.com>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2013 Crumina Team
 */

/**
 * Plugin class.
 *
 *
 * @package   Crumina page slider
 * @author    Liondekam <liondekam@gmail.com>
 */
class Crum_Page_Slider
{

    /**
     * Plugin version, used for cache-busting of style and script file references.
     *
     * @since   1.0.0
     *
     * @var     string
     */
    protected $version = '1.0.0';

    /**
     * Unique identifier for your plugin.
     *
     * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
     * match the Text Domain file header in the main plugin file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_slug = 'crumina-page-slider';

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * Initialize the plugin by setting localization, filters, and administration functions.
     *
     * @since     1.0.0
     */
    private function __construct()
    {

        // Load plugin text domain
        add_action('init', array($this, 'load_plugin_textdomain'));


        // Add the options page and menu item.
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

        // Load admin style sheet and JavaScript.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

        // Load public-facing style sheet and JavaScript.
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        //add_action('wp_enqueue_scripts', 'wpse104657_custom_color');
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        add_shortcode('cruminaslider', array($this, 'crumina_slider_init'));


    }


    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    /********************************************************/
    /*            Crumina slider new site activation        */
    /********************************************************/


    /**
     * Fired when the plugin is activated.
     *
     * @since    1.0.0
     *
     * @param    boolean $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
     */
    public function activate($network_wide)
    {
        // Multi-site
        if (is_multisite()) {

            // Get WPDB Object
            global $wpdb;

            // Get current site
            $old_site = $wpdb->blogid;

            // Get all sites
            $sites = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

            // Iterate over the sites
            foreach ($sites as $site) {
                switch_to_blog($site);
                global $wpdb;
                $table_name = $wpdb->prefix . 'crum_page_slider';
                $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `data` text NOT NULL,
			  `date_c` int(10) NOT NULL,
			  `date_m` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                dbDelta($sql);
            }

            // Switch back the old site
            switch_to_blog($old_site);

            // Single-site
        } else {
            global $wpdb;
            $table_name = $wpdb->prefix . 'crum_page_slider';
            $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `data` text NOT NULL,
			  `date_c` int(10) NOT NULL,
			  `date_m` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta($sql);
        }
    }


    function  cruminaslider_create_db_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'crum_page_slider';
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			  `id` int(10) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `data` text NOT NULL,
			  `date_c` int(10) NOT NULL,
			  `date_m` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        $domain = $this->plugin_slug;
        $locale = apply_filters('plugin_locale', get_locale(), $domain);

        load_textdomain($domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo');
        load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__)) . '/lang/');
    }

    /**
     * Register and enqueue admin-specific style sheet.
     *
     * @since     1.0.0
     *
     * @return    null    Return early if no settings page is registered.
     */
    public function enqueue_admin_styles()
    {

        if (!isset($this->plugin_screen_hook_suffix)) {
            return;
        }

        $screen = get_current_screen();
        if ($screen->id == $this->plugin_screen_hook_suffix) {
            wp_enqueue_style($this->plugin_slug . '-admin-styles', plugins_url('css/admin.css', __FILE__), array(), $this->version);
            wp_enqueue_style('wp-color-picker');
        }

    }

    /**
     * Register and enqueue admin-specific JavaScript.
     *
     * @since     1.0.0
     *
     * @return    null    Return early if no settings page is registered.
     */
    public function enqueue_admin_scripts()
    {

        if (!isset($this->plugin_screen_hook_suffix)) {
            return;
        }

        $screen = get_current_screen();
        if ($screen->id == $this->plugin_screen_hook_suffix) {
            wp_enqueue_script($this->plugin_slug . '-admin-script', plugins_url('js/admin.js', __FILE__), array('jquery'), $this->version);
            wp_enqueue_script('wp-color-picker');
        }

    }

    /**
     * Register and enqueue public-facing style sheet.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
		wp_enqueue_style(
			$this->plugin_slug . '-plugin-styles',
			plugins_url('css/public.css', __FILE__), array(), $this->version
		);
		wp_enqueue_style(
			$this->plugin_slug . '-plugin-options',
			plugins_url('css/options.css', __FILE__), array(), $this->version
		);
        //wp_enqueue_style
    }

    /**
     * Register and enqueues public-facing JavaScript files.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_slug . '-plugin-script', plugins_url('js/public.js', __FILE__), array('jquery'), $this->version);

    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu()
    {

        $this->plugin_screen_hook_suffix = add_menu_page(
            __('Crumina Page Slider', $this->plugin_slug),
            __('Page Slider', $this->plugin_slug),
            'edit_theme_options',
            $this->plugin_slug,
            array($this, 'display_plugin_admin_page')
        );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page()
    {
        include_once('views/admin.php');
    }


    public function get_post_taxonomies($post)
    {
        // Passing an object
        // Why another var?? $output = 'objects'; // name / objects
        $taxonomies = get_object_taxonomies($post, 'objects');

        /*// Passing a string using get_post_type: return (string) post, page, custom...
        $post_type  = get_post_type($post);
        $taxonomies = get_object_taxonomies($post_type, 'objects');*/

        /*// In the loop with the ID
        $theID      = get_the_ID();
        $post_type  = get_post_type($theID);
        $taxonomies = get_object_taxonomies($post_type, 'objects');*/

        // You can also use the global $post

        // edited to fix previous error $tazonomies
        // edited to force type hinting array
        return (array)$taxonomies; // returning array of taxonomies
    }


    /********************************************************/
    /*            Crumina slider new site activation           */
    /********************************************************/

    private function cruminaslider_new_site($blog_id)
    {

        // Get WPDB Object
        global $wpdb;

        // Get current site
        $old_site = $wpdb->blogid;

        // Switch to new site
        switch_to_blog($blog_id);

        // Run activation scripts
        cruminaslider_create_db_table();

        // Switch back the old site
        switch_to_blog($old_site);

    }

    private function crumSliderById($id = 0)
    {

        // No ID
        if ($id == 0) {
            return false;
        }

        // Get DB stuff
        global $wpdb;
        $table_name = $wpdb->prefix . "crum_page_slider";

        // Get data
        $link = $slider = $wpdb->get_row("SELECT * FROM $table_name WHERE id = " . (int)$id . " ORDER BY date_c DESC LIMIT 1", ARRAY_A);

        // No results
        if ($link == null) {
            return false;
        }

        // Convert data
        $slider['data'] = json_decode($slider['data'], true);

        // Return the slider
        return $slider;
    }



	public function theme_thumb($url, $width, $height=0, $align='') {

		return mr_image_resize( $url, $width, $height, true, $align, false );
	}


	public function crumina_slider_init($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "id" => " "
        ), $atts));


        $slider_id = $id;

		$page_slider_path = plugin_dir_path( __FILE__ );
		$page_slider_folder = plugin_dir_url( __FILE__ );

        $slider = $this->crumSliderById($id);

        $slider = $slider['data'];


        //$slider_width = $slider ['slider_width'];

        $template = $slider['template'];

        $sort = $slider['sort'];
        $order = $slider['sort_order'];

        if ($template == '1b-2s') {
            $number_of_posts = $slider['posts'] * 6;
            $number_of_portfolios = $slider['portfolios'] * 6;
            $number_of_pages = $slider['pages'] * 6;
        /*} elseif ($template == '2b') {
            $number = $slider['posts'] * 3;
        */} else {
            $number_of_posts = $slider['posts'] * 5;
            $number_of_portfolios = $slider['portfolios'] * 5;
            $number_of_pages = $slider['pages'] * 5;
        };

        $cache_time = $slider['cache'];
        $selected_posts = $slider['post_select'];
		if ( isset($slider['pages_select']) && $slider['pages_select'] ) {
			$selected_pages = $slider['pages_select'];
		}

		if(class_exists('Woocommerce')){
			if(isset($slider['products_select']) && $slider['products_select']){
				$selected_products = $slider['products_select'];
			}
		}


        // First, let's see if we have the data in the cache already

        $query = get_transient( 'crum_page_slider_cache_'.$slider_id );
        if ( empty( $query ) ){

            //posts

            if (is_array($selected_posts)) {

                $args_posts = array(
                    'post_type' => 'post',
                    'posts_per_page' => $number_of_posts,
                    'orderby' => $sort,
                    'order' => $order,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => $selected_posts
                        )
                    )
                );


                $result_posts = new WP_Query($args_posts);
            }
            else $result_posts = array();

            //custom categories
            $custom_posts_args = array(
                'public'   => true,
                '_builtin' => false
            );

            $output = 'names'; // names or objects, note names is the default
            $operator = 'and'; // 'and' or 'or'

            $custom_post_types = get_post_types( $custom_posts_args, $output, $operator );


            $custom_post_type_counter = 0;
            $custom_post_counter = 0;

	        $deprecated_post_types = array(
		        "product_variation",
		        "shop_coupon",
		        "pricing-table",
		        "product",
		        "pricetable",
		        "forum",
		        "topic",
		        "reply",
		        "timeline"
	        );

            if (is_array($custom_post_types)) {
                foreach ($custom_post_types as $custom_post_type) {
	                if (!(in_array($custom_post_type,$deprecated_post_types))){
                    //if (!($custom_post_type == "product_variation" or $custom_post_type == "shop_coupon" or $custom_post_type == "pricing-table" or $custom_post_type == "product")) {
                        $selected_custom_categories[$custom_post_type_counter] = (isset($slider ['custom_select_' . $custom_post_type . '']) && !empty($slider ['custom_select_' . $custom_post_type . ''])) ? $slider ['custom_select_' . $custom_post_type . ''] : array();

                        $custom_taxonomy = get_object_taxonomies($custom_post_type);


                        foreach ($custom_taxonomy as $tax) {
                            if (!($tax == 'post_tag')) {

                                $args = array(
                                    'orderby' => 'name',
                                    'show_count' => 0,
                                    'pad_counts' => 0,
                                    'hierarchical' => 1,
                                    'taxonomy' => $tax,
                                    'title_li' => ''
                                );
                                $list_categories = get_categories($args);


                                foreach ($list_categories as $list) {
                                    if (!($list->taxonomy == "product_tag")) {


                                        if (is_array($selected_custom_categories[$custom_post_type_counter])) {
                                            $custom_posts_type_args[$custom_post_type_counter] = array(
                                                'post_type' => $custom_post_type,
                                                'posts_per_page' => $number_of_portfolios,
                                                'orderby' => $sort,
                                                'order' => $order,
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => $tax,
                                                        'field' => 'slug',
                                                        'terms' => $selected_custom_categories[$custom_post_type_counter]
                                                    )
                                                )
                                            );
                                            $query_custom_post_type[$custom_post_type_counter] = new WP_Query ($custom_posts_type_args[$custom_post_type_counter]);
                                        }


                                    }

                                }


                            }
                        }

                        $custom_post_type_counter++;
                        $custom_post_counter++;
                    }

                }
            }

            $counter = 0;
            $resulting_array = array();
            $some_res = array();
            while ($counter < $custom_post_type_counter) {
                array_push($resulting_array,$query_custom_post_type[$counter]);
                $some_res=array_merge($some_res,(array)$resulting_array[$counter]->posts);
                $counter++;
            }

            //woocommerce

			if(is_array($selected_products)){

				$selection = implode(',',$selected_products);

					$args_products = array(
						'post_type'      => 'product',
						'posts_per_page' => $number_of_portfolios,
						'orderby'        => $sort,
						'order'          => $order,
						'product_cat'    => $selection,
					);

				$query_products = null;
				$query_products = new WP_Query($args_products);
			}else{
				$query_products = array();
			}

            //pages

            if (is_array($selected_pages)){

                $args_pages = array(
                    'post_type' => 'page',
                    'posts_per_page' => $number_of_pages,
                    'orderby' => $sort,
                    'order' => $order,
                    'post__in'=> $selected_pages,
                );

                $query_pages = new WP_Query($args_pages);
            }
            else $query_pages= array();


            $query = new WP_Query;

            $query->posts = array_merge( (array)$result_posts->posts, $some_res, (array)$query_products->posts, (array)$query_pages->posts );

            $query->post_count = count( $query->posts );

            set_transient('crum_page_slider_cache_'.$slider_id, $query, $cache_time * 60);

        }

	        $auto_mode = '';
	        if (!($slider['auto_mode'] == '')){
	        $auto_mode = 'data-autoscroll="'.$slider['auto_mode'].'000"';
            }

	        $from_first = '';
	        if (!($slider['from_first'] == '')){
		        $from_first = 'data-from-first="'.$slider['from_first'].'"';
	        }
	    ?>

        <div class="crumina-slider-wrap loading" id="wrap-slider-<?php echo $slider_id; ?>">
            <div class="crum-slider <?php  echo 'tmp-'.$template; ?>" <?php echo $auto_mode;?> <?php echo $from_first;?> >
                <ul class="slidee">

                    <?php
                    if ($template == '1b-2s') {
                        include $page_slider_path.'/templates/template-1b-2s.php';
                    } else {
                        include $page_slider_path.'/templates/template-1b-4s.php';
                    } ?>

                </ul>
            </div>
            <ul class="pages"></ul>
        </div>


        <script>jQuery(document).ready(function(){jQuery( '#wrap-slider-<?php echo $slider_id; ?> .crum-slider').cruminaPageSlider();}); </script>

    <?php

    }
}


