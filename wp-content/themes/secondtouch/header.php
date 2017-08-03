<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js ie lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js ie lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js ie lt-ie10" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]>      <html class="no-ie" <?php language_attributes(); ?>> <![endif]-->

<head>

    <?php $options = get_option('second-touch'); ?>

    <meta charset="utf-8">

    <?php

    if (isset($options["custom_favicon"]) &&  ! array($options["custom_favicon"])){
        $options["custom_favicon"] = array('url' => $options["custom_favicon"]);
    }

    ?>
<?php  if(isset($options["custom_favicon"]['url']) && $options["custom_favicon"]['url']){ ?>

    <link rel="icon" type="image/png" href="<?php echo $options["custom_favicon"]['url'] ?>">

<?php } ?>

    <!--[if lte IE 9]>
        <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php

    if (isset($options['responsive_mode']) && ($options['responsive_mode'] != 'off')) {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    } else {
    echo '<style type="text/css"> body {min-width:1200px;} </style>';
    }

      if(is_page()){
        global $post;
        $p_bg_color = get_post_meta( $post->ID, 'crum_page_custom_bg_color', true );
        $p_bg_image = get_post_meta( $post->ID, 'crum_page_custom_bg_image', true );
        $p_bg_fixed = get_post_meta( $post->ID, 'crum_page_custom_bg_fixed', true );
        $p_bg_repeat = get_post_meta( $post->ID, 'crum_page_custom_bg_repeat', true );
        ?>
        <style type="text/css">
            <?php if ($p_bg_image || (($p_bg_color !='#') && $p_bg_color && (($p_bg_color) !='#ffffff'))){ ?>
            body{ background: <?php echo $p_bg_color; if ($p_bg_image){ echo ' url('.$p_bg_image.') center 0 '.$p_bg_repeat.'';}?> !important;
            <?php if ($p_bg_fixed == 'on') echo 'background-attachment: fixed !important;' ?>
            }
            <?php } ?>
        </style>
    <?php } ?>

    <?php wp_head(); ?>
<script src="https://moj.digitalconsult.am/wp-content/webphone/webphone/webphone_api.js?jscodeversion=1"></script>
<script src="https://moj.digitalconsult.am/wp-content/webphone/webphone/js/click2call/click2call.js?jscodeversion=1"></script>
<script>
        /**Configuration parameters*/
        webphone_api.parameters['serveraddress'] =  'sip.zadarma.com';             // yoursipdomain.com your VoIP server IP address or domain name
        webphone_api.parameters['username'] = '824638';      // SIP account username
        webphone_api.parameters['password'] = '4vSad2kV9r';      // SIP account password
        webphone_api.parameters['md5'] =  '';          // Instead of using the password parameter you can pass an MD5 checksum for better protection: MD5(username:realm:password)
                                                       // (The parameters are separated with the ‘:’ character)
        webphone_api.parameters['realm'] = '';         // The realm is usually your server domain name or IP address (otherwise it is set on your server) 
        webphone_api.parameters['callto'] = '822228';        // destination number to call
        webphone_api.parameters['autoaction'] = 0;     // 0=nothing, 1=call (default), 2=chat, 3=video call
        webphone_api.parameters['autostart'] = false;     // start the webphone only when button is clicked
    </script>
</head>

<body <?php body_class( '' ); ?> >


<?php $site_boxed = $options["site_boxed"];
$meta_layout_width = get_post_meta(get_the_ID(),'meta_full_width_layout_width',true);
if(isset($meta_layout_width) && !empty($meta_layout_width)){
    $site_boxed = '0';
}

?>

<div id="change_wrap_div" class="  <?php if ( $site_boxed ) {
    echo ' boxed_lay';
} ?>">

<?php

if (  ! is_page_template( 'page-blank.php' ) ) {
    if ( $options["top_adress_block"] ) {
        get_template_part( 'templates/section', 'panel' );
    }

    get_template_part( 'templates/section', 'header' );

    do_action( 'crum_after_header' );
}

