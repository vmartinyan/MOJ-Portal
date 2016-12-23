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

</head>

