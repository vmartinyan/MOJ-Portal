
<?php $options = get_option('second-touch');

if (isset($options['top_login_block']) && $options['top_login_block'] == '0'){
	$login_display = 'style="display:none"';
}else{
	$login_display = '';
}

?>


    <div class="row">

        <div id="top-panel">

            <div class="login-header" <?php echo $login_display;?>>
                <?php

                if (!is_user_logged_in()) {

                    echo '<div class="avatar"><i class="linecon-user"></i></div>';

                    echo '<div class="links">';

                    echo '<a href="#" class="drop-login" data-reveal-id="loginModal">' . __('Login site', 'crum') . '</a>';

                    if (get_option('users_can_register')) :

                        echo '<span class="delim"></span><a href="'.wp_registration_url().'">' . __('Register', 'crum') . '</a>';

                    endif;

                    echo '</div>';
                    ?>

                    <div id="loginModal" class="reveal-modal">
                        <?php  crum_login_form(get_bloginfo('url'));  ?>
                        <a class="close-reveal-modal">&#215;</a>
                    </div>

                <?php
                } else {
                    global $user_login;
                    $current_user = wp_get_current_user(); ?>

                    <div class="top-avatar">
                        <?php if (($current_user instanceof WP_User)) {
                            echo get_avatar($current_user->user_email, 31);
                        } ?>
                    </div>

                    <div class="links">
                        <?php wp_loginout(); ?>
                    </div>


                <?php } ?>

            </div>
            <div class="top-info"><?php echo $options["top_adress_field"]; ?></div>

            <?php if (isset($options["top_search_show"]) && !('0' === $options["top_search_show"])) { ?>

                <div class="search"><?php get_search_form(); ?></div>

            <?php } ?>
            <?php if ($options["wpml_lang_show"]) { ?>
				<?php if (function_exists('icl_get_languages')): ?>
                <div class="lang-sel">
                    <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/lang-icon.png" alt="GB"><strong><?php _e('Change language','crum'); ?>:</strong><?php echo ICL_LANGUAGE_NAME; ?></a>
                    <ul>
                        <?php

						function language_selector_flags()
                        {
                            $languages = icl_get_languages('skip_missing=0&orderby=code');
                            if (!empty($languages)) {
                                foreach ($languages as $l) {
                                    echo '<li>';
                                    echo '<a href="' . $l['url'] . '">';
                                    echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                                    echo $l['translated_name'];
                                    echo '</a>';
                                    echo '</li>';
                                }
                            }
                        }

                        language_selector_flags();

                        ?>
                    </ul>
                </div>
			<?php endif;?>
            <?php } elseif (isset($options["lang_shortcode"])) { ?>

                <?php echo do_shortcode($options["lang_shortcode"]); ?>

            <?php }  ?>

				<?php
				if ( $options['top_panel_cart'] == '1' ) {
					reactor_minicart();
				}
				?>

            <div class="head-soc-icons"><span><?php _e('Follow us:', 'crum'); ?></span>

                <div class="soc-icons">
                    <?php crum_social_networks(true); ?>
                </div>
            </div>
        </div>
    </div>
