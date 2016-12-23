<?php $options = get_option('second-touch'); ?>

<section id="footer">

    <div class="row">
        <div class="four columns">
            <?php dynamic_sidebar('sidebar-footer-col1');?>
        </div>
        <div class="four columns">
            <?php dynamic_sidebar('sidebar-footer-col2');?>
        </div>
        <div class="four columns">

            <?php dynamic_sidebar('sidebar-footer-col3');?>

            <div class="soc-icons">

                <?php if (($options["footer_soc_networks"] != '') || ($options["footer_soc_networks"] != '0')): crum_social_networks(false); endif;?>

            </div>

        </div>
    </div>

</section>

<section id="sub-footer">
    <div class="row">
        <div class="six mobile-two columns copyr">
<?php if (isset($options["logo_footer"]) &&  ! array($options["logo_footer"])){
    $options["logo_footer"] = array('url' => $options["logo_footer"]);
} ?>
            <?php if (isset($options["logo_footer"]['url']) && ($options["logo_footer"]['url'])) { ?> <img src = "<?php echo $options["logo_footer"]['url']; ?>" alt="logo" class="foot-logo" /> <?php } ?>

            <?php echo do_shortcode($options["copyright_footer"]); ?>

        </div>
        <div class="six mobile-two columns">

            <?php wp_nav_menu(array('theme_location' => 'footer_menu', 'container' => 'nav', 'fallback_cb' => 'false', 'menu_class' => 'footer-menu', 'walker' => new crum_clean_walker())); ?>

        </div>
    </div>
</section>

<?php
if( isset($options["custom_js"])) {
echo $options["custom_js"];
}

if( ($_SERVER['SERVER_NAME'] ==  "theme.crumina.net")){
require_once locate_template('inc/custom_style/custom_style.php'); //Custom style Panel
}

wp_footer();?>
</body>
</html>