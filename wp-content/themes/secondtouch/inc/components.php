<?php

/* ----------------------------------------------------------
 *  Search form
 ----------------------------------------------------------*/

function crum_search_form($form)
{
    $form = '<form role="search" method="get" class="form-search searchform" action="' . home_url('/') . '">
    <label class="hide" for="s">' . __('Search for:', 'crum') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" class="search-query" placeholder="' . __('Search', 'crum') . '">
    <input type="submit" value="' . esc_attr__('Search', 'crum') . '" class="btn searchsubmit">
    </form>';

    return $form;
}

add_filter('get_search_form', 'crum_search_form');

/* ----------------------------------------------------------
 *  Login form
 ----------------------------------------------------------*/

function crum_login_form($redirect)
{
    $args = array(
        'redirect' => $redirect, //Your url here
        'form_id' => 'loginform-custom',
    );
    wp_login_form($args);
}
/*---------------------------------------------------------
*Shop card
---------------------------------------------------------*/

function reactor_minicart() {

	if ( class_exists( 'Woocommerce' ) ) {

		global $woocommerce;

		echo '<span class="minicart-wrap "><i class="moon  moon-cart-7"></i><a class="cart-contents" href="' . $woocommerce->cart->get_cart_url() . '" title="' . __( 'View your shopping cart', 'crum' ) . '">' . sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, 'crum' ), $woocommerce->cart->cart_contents_count ) . ' - ' . $woocommerce->cart->get_cart_total() . '</a></span>';


	}
}

/* ----------------------------------------------------------
 *  Social networks icons for header and footer
 ----------------------------------------------------------*/

function crum_social_networks ($show){

    $options = get_option('second-touch');

    $social_networks = array(
	    "sk" => "Skype",
	    "wa" => "Whatsapp",
	    "vb" => "Viber",
        "fb"=>"Facebook",
        "gp"=>"Google +",
        "tw"=>"Twitter",
        "in"=>"Instagram",
        "vi"=>"Vimeo",
        "lf"=>"Last FM",
        "vk"=>"Vkontakte",
        "yt"=>"YouTube",
        "de"=>"Devianart",
        "li"=>"LinkedIN",
        "pi"=>"Picasa",
        "pt"=>"Pinterest",
        "wp"=>"Wordpress",
        "db"=>"Dropbox",
        "fli"=>"Flickr",
		"tbr"=>"Tumblr",
        "xi"=>"Xing",
        "rss"=>"RSS",
    );
    $social_icons = array(
	    "sk" => "soc_icon-skype",
	    "wa" => "soc_icon-whatsapp",
	    "vb" => "soc_icon-viber",
        "fb" => "soc_icon-facebook",
        "gp" => "soc_icon-googleplus",
        "tw" => "soc_icon-twitter",
        "in" => "soc_icon-instagram",
        "vi" => "soc_icon-vimeo",
        "lf" => "soc_icon-last_fm",
        "vk" => "soc_icon-vkontakte",
        "yt" => "soc_icon-youtube",
        "de" => "soc_icon-deviantart",
        "li" => "soc_icon-linkedin",
        "pi" => "soc_icon-picasa",
        "pt" => "soc_icon-pinterest",
        "wp" => "soc_icon-wordpress",
        "db" => "soc_icon-dropbox",
        "fli" => "soc_icon-flickr",
		"tbr" => "soc_icon-tumblr",
        "xi" => "soc_icon-xing",
        "rss" => "soc_icon-rss",
    );

    if ($show){
        foreach($social_networks as $short=>$original){

            $icon = $social_icons[$short];
            if (isset($options[$short."_link"]) && $options[$short."_link"]){
                $link = $options[$short."_link"];
            } else {$link = false;}
            if (isset($options[$short."_show"]) && $options[$short."_show"]){
                $show = $options[$short."_show"];
            } else {$show = false;}
            if( $link && $link  !='http://' && $show )
                echo '<a href="'.$link .'" class="'.$short . ' ' . $icon . '" title="'.$original.'"></a>';
        }

    } else {
        foreach($social_networks as $short=>$original){
            $link = $options[$short."_link"];
            $icon = $social_icons[$short];
            if( $link  !='' && $link  !='http://' )
                echo '<a href="'.$link .'" class="'.$icon.'" title="'.$original.'"></a>';
        }
    }
}

/* ----------------------------------------------------------
 *  Post vote counter for portfolio items
 ----------------------------------------------------------*/

add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');


function post_like_scripts(){
    wp_register_script('like_post', get_template_directory_uri().'/assets/js/post-like.js', array('jquery'), '1.0', true );
    wp_enqueue_script('like_post');
    wp_localize_script('like_post', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ));
}

add_action( 'init', 'post_like_scripts' );



function post_like()
{
    // Check for nonce security
    $nonce = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');

    if(isset($_POST['post_like']))
    {
        // Retrieve user IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        $post_id = $_POST['post_id'];

        // Get voters'IPs for the current post
        $meta_IP = get_post_meta($post_id, "_voted_IP");
        $voted_IP = $meta_IP[0];

        if(!is_array($voted_IP))
            $voted_IP = array();

        // Get votes count for the current post
        $meta_count = get_post_meta($post_id, "_votes_count", true);

        // Use has already voted ?
        if(!hasAlreadyVoted($post_id))
        {
            $voted_IP[$ip] = time();

            // Save IP and increase votes count
            update_post_meta($post_id, "_voted_IP", $voted_IP);
            update_post_meta($post_id, "_votes_count", ++$meta_count);

            // Display count (ie jQuery return value)
            echo $meta_count;
        }
        else
            echo "already";
    }
    exit;
}

function hasAlreadyVoted($post_id)
{
    $timebeforerevote = 60*60;

    // Retrieve post votes IPs
    $meta_IP = get_post_meta($post_id, "_voted_IP");
    $voted_IP = $meta_IP[0];

    if(!is_array($voted_IP))
        $voted_IP = array();

    // Retrieve current user IP
    $ip = $_SERVER['REMOTE_ADDR'];

    // If user has already voted
    if(in_array($ip, array_keys($voted_IP)))
    {
        $time = $voted_IP[$ip];
        $now = time();

        // Compare between current time and vote time
        if(round(($now - $time) / 60) > $timebeforerevote)
            return false;

        return true;
    }

    return false;
}


function getPostLikeLink($post_id)
{
    $vote_count = get_post_meta($post_id, "_votes_count", true);

    $output = '<span class="post-like">';

    if(hasAlreadyVoted($post_id))
        $output .= ' <span title="'.__('I like this article', 'crum').'" class="like alreadyvoted"></span>';
    else
        $output .= '<a href="#" data-post_id="'.$post_id.'">
                    <span  title="'.__('I like this article', 'crum').'" class="qtip like"></span>
                </a>';
    $output .= '<span class="count">'.$vote_count.'</span></span>';

    return $output;
}


function crumina_get_header() {
	get_header();
}

add_action( 'crum_header', 'crumina_get_header', 1 );

function crumina_get_footer() {
	do_action('crum_after_content'); ?>

	</div>

	<?php

	do_action('crum_above_twitter');
	get_template_part('templates/section','twitter-panel');
	do_action('crum_below_twitter');

	get_footer();

}

add_action('crum_footer', 'crumina_get_footer', 2);

function before_content_shortcode() {

	if(get_post_meta(get_the_ID(), '_top_page_text', true)) {
		echo do_shortcode(get_post_meta(get_the_ID(), '_top_page_text', true));
	}
}
add_action('crum_shortcode_before', 'before_content_shortcode');