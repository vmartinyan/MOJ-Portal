<?php $options = get_option('second-touch'); ?>

<?php
$sticky = $options['fixed_menu_show'] == '1';

$meta_sticky = get_post_meta( get_the_ID(), 'crum_sticky_menu', true );

if ( isset( $meta_sticky ) && ! empty( $meta_sticky ) && ! ( 'default' === $meta_sticky ) ) {
	if ( 'yes' === $meta_sticky ) {
		$sticky = '1';
	} elseif ( 'no' === $meta_sticky ) {
		$sticky = '0';
	}
}

if($sticky){
	$fixed = 'fixed';
}else{
	$fixed = '';
}
$mobile_menu_style = '';
$mobile_hide = '';
if(isset($options['mobile_menu_show']) && ('1' === $options['mobile_menu_show'])){
	$mobile_menu_style = 'style="display: none"';
	$mobile_hide = 'mobile-hide';
}



?>

<section id="header" class="horizontal" data-not-fixed="<?php echo $fixed;?>">

    <div class="header-wrap">
        <div class="row">

            <div class="twelve columns">

                <?php

                if (isset($options["custom_logo_image"]) &&  ! array($options["custom_logo_image"])){
                    $options["custom_logo_image"] = array('url' => $options["custom_logo_image"]);
                }

                if (isset($options['custom_logo_image']['url']) && !empty($options['custom_logo_image']['url'])) {  ?>

                    <div id="logo">

                        <!--<a href="<?php echo home_url(); ?>/"><img src="<?php echo $options['custom_logo_image']['url']; ?>" alt="<?php bloginfo('name'); ?>"></a>-->
						<!--<a href="<?php echo home_url(); ?>/"><img src="<?php echo site_url(); ?>/wp-content/uploads/2013/02/<?php echo __('[:hy]moj-logo-ex-big.png[:en]moj-logo-ex-big-en.png[:ru]moj-logo-ex-big-ru.png');?>" width="359" alt="<?php bloginfo('name'); ?>"></a> -->
						<a href="<?php echo home_url(); ?>/"><img src="<?php echo site_url(); ?>/wp-content/uploads/2013/02/<?php echo __('[:hy]logo-baner.png[:en]logo-baner-en.png[:ru]logo-baner-ru.png[:]');?>" width="359" alt="<?php bloginfo('name'); ?>"></a>
                        <a href="<?php echo home_url(); ?>/"><img class="for-panel" src="<?php echo site_url(); ?>/wp-content/uploads/2013/02/<?php echo __('[:hy]logo-baner.png[:en]logo-baner-en.png[:ru]logo-baner-ru.png[:]');?>" alt="<?php bloginfo('name'); ?>"></a>

                    </div>

					<a href="#" class="top-menu-button " <?php echo $mobile_menu_style;?>></a>

                    <?php
                }

                $custom_menu = get_post_meta(get_the_ID(),'crum_custom_menu',true);

                if(isset($custom_menu) && !empty($custom_menu) && !('default' === $custom_menu)){
	                wp_nav_menu(array('menu' => $custom_menu, 'theme_location' => 'primary_navigation', 'menu_class' => 'tiled-menu '.$mobile_hide.'', 'fallback_cb' => 'top_menu_fallback'));
                }else{
	                wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'tiled-menu '.$mobile_hide.'', 'fallback_cb' => 'top_menu_fallback'));
                }

                 ?>

            </div>
        </div>
    </div>
</section>
<section id="before-content-block">

	<?php crum_shortcode_before();?>

</section>
