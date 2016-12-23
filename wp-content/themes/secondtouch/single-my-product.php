<?php crum_header();?>
<?php $options = get_option('second-touch'); ?>

<?php global $data;
$is_full = ($options["portfolio_single_style"] == 'full');
$show_featured = isset($options["portfolio_single_featured"]) ? $options["portfolio_single_featured"] :true;

get_template_part('templates/top', 'folio'); ?>

    <section id="layout" class="single-folio">

        <div class="row project">

            <h1 class="portfolio-item-title twelve columns"><?php the_title(); ?></h1>

            <div class="<?php echo ($is_full) ? 'twelve' : 'eight'; ?> columns">

                <?php

                if (!post_password_required(get_the_id())) {


                $embed_url = get_post_meta($post->ID, 'folio_embed', true);

                if ($embed_url):

                    $embed_code = wp_oembed_get($embed_url);

                    echo '<div class="single-folio-video">' . $embed_code . '</div>';

                endif;

                if ((get_post_meta($post->ID, 'folio_self_hosted_mp4', true) != '') || (get_post_meta($post->ID, 'folio_self_hosted_webm', true) != '')) {

                    if (has_post_thumbnail()) {
                        $thumb = get_post_thumbnail_id();
                        $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                        $article_image = aq_resize($img_url, 800, 600, true); ?>

                    <?php } ?>

                    <link href="https://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
                    <script src="https://vjs.zencdn.net/c/video.js"></script>


                    <video id="video-post<?php the_ID(); ?>" class="video-js vjs-default-skin" controls
                           preload="auto"
                           width="800"
                           height="600"
                           poster="<?php echo $article_image ?>"
                           data-setup="{}">


                        <?php if (get_post_meta($post->ID, 'folio_self_hosted_mp4', true)): ?>
                            <source src="<?php echo get_post_meta($post->ID, 'folio_self_hosted_mp4', true) ?>" type='video/mp4'>
                        <?php endif; ?>
                        <?php if (get_post_meta($post->ID, 'folio_self_hosted_webm"', true)): ?>
                            <source src="<?php echo get_post_meta($post->ID, 'folio_self_hosted_webm"', true) ?>" type='video/webm'>
                        <?php endif; ?>
                    </video>


                <?php
                } ?>

                <?php
                if (metadata_exists('post', $post->ID, '_my_product_image_gallery')) {
                    $my_product_image_gallery = get_post_meta($post->ID, '_my_product_image_gallery', true);
                } else {
                    // Backwards compat
                    $attachment_ids = get_posts('post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids');
                    $attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
                    $my_product_image_gallery = implode(',', $attachment_ids);
                }

                $attachments = array_filter(explode(',', $my_product_image_gallery));
                $thumb = get_post_thumbnail_id();
                if ($attachments) {


                    echo '<div id="my-work-slider" class="loading"><ul class="slides">';

                    foreach ($attachments as $attachment_id) {

                        $image_attributes = wp_get_attachment_image_src($attachment_id); // returns an array

                        $thumb_image = aq_resize($image_attributes[0], 63, 63, true);

                        echo '<li data-thumb="' . $thumb_image . '">';

                        echo wp_get_attachment_image($attachment_id, 'full');

                        echo '</li>';
                    }
                    echo '  </ul></div>';
                } elseif (has_post_thumbnail() && (!$embed_url) && $show_featured) {
                    echo wp_get_attachment_image($thumb, 'full');
                }

                if (isset($options['portfolio_single_category']) && $options['portfolio_single_category'] == '1'){

	                $limit_category = true;
                }else{
	                $limit_category = false;
                }

                ?>

                <div class="pages-nav twelve columns ">

                    <?php previous_post_link('<div class="prev-link"><span class="text">'.__('Prev','crum').'.</span> %link </div>', '%title', $limit_category, ' ', 'my-product_category'); ?>

                    <?php $page = $options['portfolio_page_select']; $slug = get_permalink($page); if($page) {echo '<a class="to-folio" href="'.$slug.'"></a>';} ?>

                    <?php next_post_link('<div class="next-link"><span class="text">'.__('Next','crum').'</span> %link </div>', '%title', $limit_category, ' ', 'my-product_category'); ?>

                </div>

            </div>

            <div class="folio-info <?php echo $is_full ? 'twelve' : 'four'; ?> columns">

                    <?php
                    if (function_exists('get_field_objects')) {
                        $fields = get_field_objects();
                    } else {
                        $fields = false;
                    }
                    if ($fields) { ?>

                <dl class="tabs contained horisontal clearfix">

                    <dd class="active"><a href="#folio-desc-1"><?php _e('Description', 'crum') ?></a></dd>

                        <?php $i = 2;
                        foreach ($fields as $field_name => $field) {
                            if ($field['label']) {
                                echo '<dd><a href="#folio-desc-' . $i . '">';
                                echo $field['label'];
                                echo '</a></dd>';

                                $i++;
                            }
                        }
                   ?>

                </dl>
                <ul class="tabs-content contained">
                    <li id="folio-desc-1Tab" class="active">

                        <?php while (have_posts()) : the_post(); ?>
                            <?php the_content(); ?>
                        <?php endwhile; ?>

                    </li>
                    <?php } else { while (have_posts()) : the_post(); the_content(); endwhile; } ?>
                    <?php if ($fields) {
                        $i = 2;
                        foreach ($fields as $field_name => $field) {
                            if ($field['label']) {
                                echo '<li id="folio-desc-' . $i . 'Tab">';
                                echo do_shortcode($field['value']);
                                echo '</li>';

                                $i++;
                            }
                        }
                    ?>

                </ul>

                <?php } ?>

                <?php get_template_part('templates/folio', 'single-terms'); ?>

                <?php if ($options["post_share_button"]) {

                    global $post;
                    $url = get_permalink($post->ID);

                    ?>

                    <div id="social-share" data-directory="<?php echo get_template_directory_uri(); ?>">

                        <?php echo getPostLikeLink(get_the_ID()); ?>

                        <span id="cr-facebook-share" data-url="<?php echo $url ?>" data-text="<?php the_title(); ?>" data-title="share"></span>
                        <span id="cr-twitter-share" data-url="<?php echo $url ?>" data-text="<?php the_title(); ?>" data-title="share"></span>
                        <span id="cr-googlep-share" data-url="<?php echo $url ?>" data-text="<?php the_title(); ?>" data-title="share"></span>
                        <span id="cr-pinterest-share" data-url="<?php echo $url ?>"  data-media="<?php echo wp_get_attachment_url($thumb); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-text="<?php the_title(); ?>" data-title="share"></span>
                    </div>

                <?php } ?>

            </div>


            <?php echo '</div>'; ?>

            <?php
            } else the_content();


            if ($options["recent_items_disp"]) {
                ?>

                <div class="row">
                    <div class="twelve columns">

                        <?php echo do_shortcode($options['block_single_folio_item']); ?>

                    </div>
                </div>

            <?php } ?>


    </section>
<?php if ($options['portfolio_single_slider'] == 'slider') { ?>
    <script type="text/javascript">
        jQuery(window).load(function () {
            var target_flexslider = jQuery('#my-work-slider');
            target_flexslider.flexslider({
                namespace: "my-work-",
                animation: "slide",
                controlNav: "thumbnails",
                smoothHeight: true,
                directionNav: false,

                start: function (slider) {
                    slider.removeClass('loading');
                }

            });
        });

    </script>
<?php } ?>
<?php crum_footer();?>