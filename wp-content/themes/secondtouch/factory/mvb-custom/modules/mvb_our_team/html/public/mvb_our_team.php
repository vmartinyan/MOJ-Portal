<div class="team_module module row <?php echo $css . $cr_effect ?>">

    <?php if ($main_title != ''): ?>

        <h3 class="twelve columns widget-title">

            <?php echo $main_title ?>

        </h3>


    <?php endif; ?>


    <?php if (count($r_items) > 0): ?>

        <?php foreach ($r_items as $panel): ?>

            <?php if (isset($panel['effects']) && $panel['effects'] ) {
                $cr_effect = ' cr-animate-gen"  data-gen="' . $panel['effects'] . '" data-gen-offset="bottom-in-view';
            } else {
                $cr_effect = '';
            } ?>

            <?php
            $panel_image = (isset($panel['image'])) ? $panel['image'] : '';
            $panel_image_clip = (isset($panel['image_flip'])) ? $panel['image_flip'] : '';

            if ($panel_image){
                $url = wp_get_attachment_url($panel['image']);
                $article_image = aq_resize($url, 180, 180, true);
            }

            if ($panel_image_clip){
                $url_flip = wp_get_attachment_url($panel_image_clip);
                $flip_image = aq_resize($url_flip, 180, 180, true);
            }

            $social_networks = array(
                "sk" => "Skype",
                "wa" => "Whatsapp",
                "vb" => "Viber",
                "tw" => "Twitter",
                "fb" => "Facebook",
                "li" => "LinkedIN",
                "gp" => "Google +",
                "in" => "Instagram",
                "vi" => "Vimeo",
                "lf" => "Last FM",
                "vk" => "Vkontakte",
                "yt" => "YouTube",
                "de" => "Devianart",
                "pi" => "Picasa",
                "pt" => "Pinterest",
                "wp" => "Wordpress",
                "db" => "Dropbox",
            );
            $social_icons = array(
                "sk" => "socicon-skype",
                "wa" => "socicon-whatsapp",
                "vb" => "socicon-viber",
                "fb" => "soc_icon-facebook",
                "gp" => "soc_icon-googleplus",
                "tw" => "soc_icon-twitter",
                "in" => "soc_icon-instagram",
                "vi" => "soc_icon-vimeo",
                "lf" => "soc_icon-last_fm",
                "vk" => "soc_icon-rus-vk-01",
                "yt" => "soc_icon-youtube",
                "de" => "soc_icon-deviantart",
                "li" => "soc_icon-linkedin",
                "pi" => "soc_icon-picasa",
                "pt" => "soc_icon-pinterest",
                "wp" => "soc_icon-wordpress",
                "db" => "soc_icon-dropbox",
                "rss" => "soc_icon-rss",
            );

            $icons = '';

            foreach ($social_networks as $short => $original) {

                if ( isset ($panel[$short . "_link"]) && $panel[$short . "_link"] ) {
                    $link = $panel[$short . "_link"];
                    $icon = $social_icons[$short];
                    if (isset($link) && $link != '') {
                        $icons .= '<a href="' . $link . '" class="' . $icon . '" title="' . $original . '"></a>';
                    }
                }

            }
            ?>

            <div class="<?php echo $column_number ?> columns  <?php echo $cr_effect; ?>">

                <div class="team_member_box">

                    <?php if ( $panel_image && $panel_image_clip ) { ?>


                        <div class="avatar flipbox">

                            <div class="front"><img src="<?php echo $article_image; ?>" alt="<?php echo $panel['main_title'] ?>"/></div>

                            <?php if ( ( isset( $panel['page_id'] ) && is_numeric( $panel['page_id'] ) && $panel['page_id'] > 0 ) || ( isset( $panel['full_page_link'] ) && ! ( $panel['full_page_link'] == '' ) ) ) { ?>

                                <?php $_link = $panel['full_page_link'] != '' ? $panel['full_page_link'] : get_page_link( $panel['page_id'] ); ?>

                                <?php if ( $panel['new_window'] == 1 ) {
                                    $_target = 'target="blank"';
                                } else {
                                    $_target = '';
                                } ?>

                                <div class="back"><a href="<?php echo $_link ?>" <?php echo $_target; ?>><img src="<?php echo $flip_image; ?>" alt="<?php echo $panel['main_title'] ?>"/></a></div>

                            <?php } elseif ( $panel_image_clip ) { ?>

                                <div class="back"><img src="<?php echo $flip_image; ?>" alt="<?php echo $panel['main_title'] ?>"/></div>

                            <?php } ?>

                        </div>
                    <?php } elseif ( $panel_image ) { ?>

                        <div class="avatar">
                            <img src="<?php echo $article_image; ?>" alt="<?php echo $panel['main_title'] ?>"/>
                        </div>


                    <?php } ?>


                    <div class="block-title"><?php echo $panel['main_title'] ?></div>
                    <span class="dopinfo"><?php echo $panel['sub_title'] ?></span>

                    <?php if ($panel['content'] != ''): ?>

                        <div class="text">

                            <?php echo mvb_parse_content($panel['content'], TRUE);

                            if (isset($icons) && $icons) {
                                echo '<div class="soc-icons">';
                                echo $icons;
                                echo '</div>';

                                $icons ='';
                            }

                            ?>

                        </div>

                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>









