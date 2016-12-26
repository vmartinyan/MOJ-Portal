<?php
/*
 * Pages layout select function
 */


function set_layout($page, $open = true, $custom = 'no')
{
	if ( 'no' === $custom ) {
		$options = get_option( 'second-touch' );
		if ( isset( $options[ $page . "_layout" ] ) && ! empty( $options[ $page . "_layout" ] ) ) {
			$page = $options[ $page . "_layout" ];
		} else {
			$page = "1col-fixed";
		}
	}

    if ($page == "1col-fixed") {
        $cr_layout = '';
        $cr_width = 'twelve';
    }
	elseif ($page == "3c-l-fixed") {
        $cr_layout = 'sidebar-left2';
        $cr_width = 'six';
    }
	elseif ($page == "3c-r-fixed") {
        $cr_layout = 'sidebar-right2';
        $cr_width = 'six';
    }
	elseif ($page == "2c-l-fixed") {
        $cr_layout = 'sidebar-left';
        $cr_width = 'nine';
    }
	elseif ($page == "2c-r-fixed") {
        $cr_layout = 'sidebar-right';
        $cr_width = 'nine';
    }
	elseif ($page == "3c-fixed") {
        $cr_layout = 'sidebar-both';
        $cr_width = 'six';
    } else {
		$cr_layout = '';
		$cr_width = 'twelve';
	}


    if ($open) {

        // Open content wrapper


        echo '<div class="blog-section ' . $cr_layout . '">';
        echo '<section id="main-content" role="main" class="' . $cr_width . ' columns">';


    } else {

        // Close content wrapper

        echo ' </section>';

        if (($page == "2c-l-fixed") || ($page == "3c-fixed")) {
            get_template_part('templates/sidebar', 'left');
            echo ' </div>';
        }
        if (($page == "3c-l-fixed")){
            get_template_part('templates/sidebar', 'right');
            echo ' </div>';
            get_template_part('templates/sidebar', 'left');
        }
        if ($page == "3c-r-fixed"){
            get_template_part('templates/sidebar', 'left');
            echo ' </div>';
        }
        if (($page == "2c-r-fixed") || ($page == "3c-fixed") || ($page == "3c-r-fixed") ) {
            get_template_part('templates/sidebar', 'right');
        }
    }
}


/**
 * Add the RSS feed link in the <head> if there's posts
 */
function crum_feed_link() {
  $count = wp_count_posts('post'); if ($count->publish > 0) {
    echo "\n\t<link rel=\"alternate\" type=\"application/rss+xml\" title=\"". get_bloginfo('name') ." Feed\" href=\"". home_url() ."/feed/\">\n";
  }
}

add_action('wp_head', 'crum_feed_link', -2);


/**
 * Customization of login page
 */

function crum_custom_login_logo() {

    $options = get_option('second-touch');

    if (isset($options["custom_logo_image"]) &&  ! array($options["custom_logo_image"])){
        $options["custom_logo_image"] = array('url' => $options["custom_logo_image"]);
    }
    if( isset($options["custom_logo_image"]['url']) && $options["custom_logo_image"]['url'] !=''){
        $custom_logo = $options["custom_logo_image"]['url'];
    } else {
        $custom_logo = get_template_directory_uri() .'/assets/img/logo.png';
    }

    echo '<style type="text/css">

    .login h1 a {
 	width:300px !important;
	background-image:url('. $custom_logo .') !important;
	background-size: contain !important;
}
    </style>';
}

add_action('login_head', 'crum_custom_login_logo');

function crum_home_link() {
    return site_url();
}
add_filter('login_headerurl','crum_home_link');

function change_title_on_logo() {
    return get_bloginfo( 'name' );
}
add_filter('login_headertitle', 'change_title_on_logo');


// Add/Remove Contact Methods
function add_remove_contactmethods( $contactmethods ) {

    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['googleplus'] = 'Google Plus';
    $contactmethods['linkedin'] = 'Linked In';
    $contactmethods['vimeo'] = 'Vimeo';
    $contactmethods['lastfm'] = 'LastFM';
    $contactmethods['tumblr'] = 'Tumblr';
    $contactmethods['skype'] = 'Skype';
    $contactmethods['cr_facebook'] = 'Facebook';
    $contactmethods['deviantart'] = 'Deviantart';
    $contactmethods['vkontakte'] = 'Vkontakte';
    $contactmethods['picasa'] = 'Picasa';
    $contactmethods['linkedin'] = 'Linkedin';
    $contactmethods['wordpress'] = 'Wordpress';
    $contactmethods['instagram'] = 'Instagram';

    // Remove Contact Methods
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);

    return $contactmethods;
}
add_filter('user_contactmethods','add_remove_contactmethods',10,1);


/**
 * Create pagination
 */

function crumin_pagination() {

    global $wp_query;

    $big = 999999999;

    $links = paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'prev_next' => true,
            'prev_text' =>  __('Prev', 'crum'), //text of the "Previous page" link
            'next_text' =>  __('Next', 'crum'), //text of the "Next page" link

            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'type' => 'list'
        )
    );

    $pagination = str_replace('page-numbers','pagination',$links);

    echo $pagination;

}
/*
 *
 *
 */

function crumina_breadcrumbs() {

	/* === OPTIONS === */
	$text['home']     = __( 'Home', 'crum' ); // text for the 'Home' link
	$text['category'] = __( 'Archive by Category "%s"', 'crum' ); // text for a category page
	$text['search']   = __( 'Search Results for "%s" Query', 'crum' ); // text for a search results page
	$text['tag']      = __( 'Posts Tagged "%s"', 'crum' ); // text for a tag page
	$text['author']   = __( 'Articles Posted by %s', 'crum' ); // text for an author page
	$text['404']      = __( 'Error 404', 'crum' ); // text for the 404 page

	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = ' <span class="del">-</span> '; // delimiter between crumbs
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$homeLink   = home_url() . '/';
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter  = '</span>';
	$linkAttr   = ' rel="v:url" property="v:title"';
	$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

	if ( is_home() || is_front_page() ) {

		if ( $showOnHome == 1 )
			echo '<nav id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></nav>';

		} else {


        echo '<nav id="crumbs">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

        if ( is_category() ) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif ( function_exists('tribe_is_event') && tribe_is_event() && ! is_single() ) {
	        echo $before . 'Events' . $after;
        } elseif ( function_exists('tribe_is_event') && tribe_is_event() ) {
	        printf($link, tribe_get_events_link(), 'Events');
	        echo $delimiter;
	        echo $before . the_title() . $after;
        }elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;


        }
        elseif (is_singular('topic') ){
            $post_type = get_post_type_object(get_post_type());
            printf($link, $homeLink . '/forums/', $post_type->labels->singular_name);
        }
        /* in forum, add link to support forum page template */
        elseif (is_singular('forum')){
            $post_type = get_post_type_object(get_post_type());
            printf($link, $homeLink . '/forums/', $post_type->labels->singular_name);
        }
        elseif (is_tax('topic-tag')){
            $post_type = get_post_type_object(get_post_type());
            printf($link, $homeLink . '/forums/', $post_type->labels->singular_name);
        }



        elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {
            /*$parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;*/

        } elseif ( is_page() && !$post->post_parent ) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo $delimiter;
            }
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page','crum') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</nav>';

    }
}


/*
 * Seo additions
 */

/**
 * Add Google+ meta tags to header
 *
 * @uses	get_the_ID()  Get post ID
 * @uses	setup_postdata()  setup postdata to get the excerpt
 * @uses	wp_get_attachment_image_src()  Get thumbnail src
 * @uses	get_post_thumbnail_id  Get thumbnail ID
 * @uses	the_title()  Display the post title
 *
 * @author c.bavota
 */
add_action( 'wp_head', 'add_google_plus_meta' );

function add_google_plus_meta() {

    if( is_single() ) {

        global $post;

        $post_id = get_the_ID();
        setup_postdata( $post );

        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
        $thumbnail = empty( $thumbnail ) ? '' : '<meta itemprop="image" content="' . esc_url( $thumbnail[0] ) . '">';
        ?>

    <!-- Google+ meta tags -->
    <meta itemprop="name" content="<?php esc_attr( the_title() ); ?>">
    <meta itemprop="description" content="<?php echo esc_attr( get_the_excerpt() ); ?>">
    <?php echo $thumbnail . "\n"; ?>

    <!-- eof Google+ meta tags -->
    <?php

    }

}



/*-----------------------------------------------------------------------------------*/
# Get Social Counter
/*-----------------------------------------------------------------------------------*/
function tie_curl_subscribers_text_counter( $xml_url ) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $xml_url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


if ( ! ( function_exists( 'crum_get_remote' ) ) ) {
	function crum_get_remote( $url ) {
		$request = wp_remote_retrieve_body( wp_remote_get( $url, array( 'timeout' => 18, 'sslverify' => false ) ) );

		return $request;
	}
}
function tie_rss_count( $fb_id ) {
    $feedburner['rss_count'] = get_option( 'rss_count');
    return $feedburner;
}

function tie_followers_count() {

    $options = get_option('second-touch');

    require_once locate_template('/inc/lib/twitteroauth.php');
    try {
        $twitter_username 		= $options["username"];
        $consumer_key 			= $options["twiiter_consumer"];
        $consumer_secret		= $options["twiiter_con_s"];
        $access_token 			= $options["twiiter_acc_t"];
        $access_token_secret 	= $options["twiiter_acc_t_s"];

        $twitterConnection = new TwitterOAuth( $consumer_key , $consumer_secret , $access_token , $access_token_secret	);
        $twitterData = $twitterConnection->get('users/show', array('screen_name' => $twitter_username));
        $twitter['page_url'] = 'http://www.twitter.com/'.$twitter_username;
        $twitter['followers_count'] = $twitterData->followers_count;;
    } catch (Exception $e) {
        $twitter['page_url'] = 'http://www.twitter.com/'.$twitter_username;
        $twitter['followers_count'] = 0;
    }
    if( !empty( $twitter['followers_count'] ) &&  get_option( 'followers_count') != $twitter['followers_count'] )
        update_option( 'followers_count' , $twitter['followers_count'] );

    if( $twitter['followers_count'] == 0 && get_option( 'followers_count') )
        $twitter['followers_count'] = get_option( 'followers_count');

    elseif( $twitter['followers_count'] == 0 && !get_option( 'followers_count') )
        $twitter['followers_count'] = 0;

    return $twitter;
}

function tie_facebook_fans( $page_link ) {
	$face_link = @parse_url( $page_link );

	$access_token = '728127280632413|XwF_4BC6G8JVlKo9htssFY6AuZw';

	if ( $face_link['host'] == 'www.facebook.com' || $face_link['host'] == 'facebook.com' ) {
		$fans = get_transient( 'facebook_counter' );
		if ( empty( $fans ) ) {
			try {
				$data = @json_decode( crum_get_remote( "https://graph.facebook.com/" . $page_link . "?access_token=" . $access_token . "" ) );
				if ( is_object( $data ) ) {
					$fans = $data->likes;
				} else {
					$fans = 0;
				}
			} catch ( Exception $e ) {
				$fans = 0;
			}

			if ( ! empty( $fans ) ) {
				set_transient( 'facebook_counter', $fans );
				if ( get_option( 'facebook_counter' ) != $fans ) {
					update_option( 'facebook_counter', $fans );
				}
			}

			if ( $fans == 0 && get_option( 'facebook_counter' ) ) {
				$fans = delete_option( 'facebook_counter' );
			} elseif ( $fans == 0 && ! get_option( 'facebook_counter' ) ) {
				$fans = 0;
			}
		}

		return $fans;
	}
}


function tie_youtube_subs( $channel_link ) {
	$youtube_name   = substr( @parse_url( $channel_link, PHP_URL_PATH ), 6 );
	$google_api_key = 'AIzaSyAA7Qvw3Q83wLcW-MAEu8wrEGyI8QN-lKM';
	$count          = - 1;
	$youtubeUrl     = "https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=" . $youtube_name . "&key=" . $google_api_key;

	$response = file_get_contents( $youtubeUrl );

	$fb = json_decode( $response );
	if ( isset( $fb->items[0] ) ) {
		$count = intval( $fb->items[0]->statistics->subscriberCount );
	}

	if ( ! empty( $count ) && get_option( 'youtube_count' ) != $count ) {
		update_option( 'youtube_count', $count );
	}

	if ( $count == 0 && get_option( 'youtube_count' ) ) {
		$count = get_option( 'youtube_count' );
	} elseif ( $count == 0 && ! get_option( 'youtube_count' ) ) {
		$count = 0;
	}

	return $count;

}


function tie_vimeo_count( $page_link ) {
    $face_link = @parse_url($page_link);

    if( $face_link['host'] == 'www.vimeo.com' || $face_link['host']  == 'vimeo.com' ){
        try {
            $page_name = substr(@parse_url($page_link, PHP_URL_PATH), 10);
            @$data = @json_decode(tie_curl_subscribers_text_counter( 'http://vimeo.com/api/v2/channel/' . $page_name  .'/info.json'));

            $vimeo = $data->total_subscribers;
        } catch (Exception $e) {
            $vimeo = 0;
        }

        if( !empty($vimeo) && get_option( 'vimeo_count') != $vimeo )
            update_option( 'vimeo_count' , $vimeo );

        if( $vimeo == 0 && get_option( 'vimeo_count') )
            $vimeo = get_option( 'vimeo_count');

        elseif( $vimeo == 0 && !get_option( 'vimeo_count') )
            $vimeo = 0;

        return $vimeo;
    }

}

function tie_dribbble_count( $page_link ) {
    $face_link = @parse_url($page_link);

    if( $face_link['host'] == 'www.dribbble.com' || $face_link['host']  == 'dribbble.com' ){
        try {
            $page_name = substr(@parse_url($page_link, PHP_URL_PATH), 1);
            @$data = @json_decode(tie_curl_subscribers_text_counter( 'http://api.dribbble.com/' . $page_name));

            $dribbble = $data->followers_count;
        } catch (Exception $e) {
            $dribbble = 0;
        }

        if( !empty($dribbble) && get_option( 'dribbble_count') != $dribbble )
            update_option( 'dribbble_count' , $dribbble );

        if( $dribbble == 0 && get_option( 'dribbble_count') )
            $dribbble = get_option( 'dribbble_count');

        elseif( $dribbble == 0 && !get_option( 'dribbble_count') )
            $dribbble = 0;

        return $dribbble;
    }
}

add_filter('wp_get_attachment_link', 'crum_addlightboxrel');
function crum_addlightboxrel($content) {
	global $post;
	$pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto[pp_gal'.$post->ID.']" title="'.$post->post_title.'"$6>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

add_action('admin_init','crum_remove_woopages');

function crum_remove_woopages(){

	$remove_pages = array(
		'01' => 'single-product/title.php',
		'02' => 'loop-shop.php',
		'03' => 'single-product-reviews.php',
		'04' => 'taxonomy-product_cat.php',
		'05' => 'taxonomy-product_tag.php',
		'06' => 'shop/wrapper-start.php',
		'07' => 'cart/cross-sells.php',
		'08' => 'cart/mini-cart.php',
		'09' => 'cart/mini-cart.php',
		'10' => 'cart/shipping-calculator.php',
		'11' => 'cart/shipping-methods.php',
		'12' => 'cart/totals.php',
		'13' => 'checkout/form-billing.php',
		'14' => 'checkout/form-checkout.php',
		'15' => 'checkout/form-shipping.php',
		'16' => 'checkout/thankyou.php',
		'17' => 'loop/loop-end.php',
		'18' => 'shop/breadcrumb.php',
		'19' => 'shop/messages.php',
		'20' => 'shop/wrapper-end.php',
		'21' => 'shop/wrapper-start.php',
		'22' => 'single-product/tabs/additional-information.php',
		'23' => 'single-product/product-image.php',
		'24' => 'single-product/related.php',
	);

	$delete_check = get_option('woo_files_deleted');

	if ( ($delete_check == false) ) {
		foreach ( $remove_pages as $remove_page ) {

			$file = ( get_template_directory() . '/woocommerce/' . $remove_page );

			if ( file_exists( $file ) && is_readable( $file ) ) {
				unlink( $file );
			}

		}
		update_option('woo_files_deleted','files_deleted');
	}

}

//Add Functionality to VC
		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {

			function crumina_css_classes_for_vc_row_and_vc_column( $class_string, $tag = '' ) {

				if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
					$class_string = str_replace( 'vc_row-fluid', 'row', $class_string );
					$class_string = str_replace( 'wpb_row', '', $class_string );
				}

				return $class_string;
			}

			// Filter to Replace default css class for vc_row shortcode and vc_column
			add_filter( 'vc_shortcodes_css_class', 'crumina_css_classes_for_vc_row_and_vc_column', 10, 2 );
		}

if ( ! ( function_exists( 'crum_thousands_convert' ) ) ) {
	function crum_thousands_convert( $amount ) {

		$k_meter    = 1000;
		$k100_meter = 100000;

		if ( ( $amount > $k_meter ) && ( $amount < $k100_meter ) ) {
			$amount = round( $amount / $k_meter, 1 ) . 'k';
		} elseif ( $amount > $k100_meter ) {
			$amount = round( $amount / $k_meter, 0 ) . 'k';

		} else {
			return $amount;
		}

		return $amount;
	}
}

if(!(function_exists('crum_portfolio_list'))){
	/**
	 * @return array
	 */
	function crum_portfolio_list(){

		$portfolio_list = array();

		$args = array(
			'post_type' => 'my-product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		);
		$portfolios = new WP_Query($args);
		while ($portfolios->have_posts()): $portfolios->the_post();

			$portfolio_list[get_the_ID()] = get_the_title(get_the_ID());

		endwhile;

		wp_reset_query();

		return $portfolio_list;

	}
}
if (! function_exists('crum_twitter_convert_links')){
/**
 * @param           $status
 * @param bool|true $targetBlank
 * @param int       $linkMaxLen
 *
 * @return mixed
 */
function crum_twitter_convert_links( $status, $targetBlank = true, $linkMaxLen = 250 ) {


    // the target
    $target = $targetBlank ? "  " : "";
    // convert link to url

    $status = preg_replace_callback("/((http:\/\/|https:\/\/)[^ )]+)/", function ($matches) {return '<a href="'.$matches[1].'" title="'.$matches[1].'" target="_blank" >'. ((strlen($matches[1])>=250 ? substr($matches[1],0,250).'...':$matches[1])).'</a>';}, $status);

    // convert @ to follow
    $status = preg_replace( "/(@([_a-z0-9\-]+))/i", "<a href=\"http://twitter.com/$2\" class=\"twitter__email\" title=\"Follow $2\" $target >$1</a>", $status );
    // convert # to search
    $status = preg_replace( "/(#([_a-z0-9\-]+))/i", "<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>", $status );

    // return the status
    return $status;
}
}

add_action( 'wp_login_failed', 'second_login_failed' );
function second_login_failed( $username )
{
    $referrer = wp_get_referer();

    if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') )
    {
        wp_redirect( add_query_arg('login', 'failed', wp_login_url()) );
        exit;
    }
}