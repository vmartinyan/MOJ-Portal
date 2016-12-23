<?php if ($effects) {
    $cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
    $cr_effect = '';
} ?>

<div class="module module_posts <?php echo $css ?>">

    <?php if ($main_title != ''): ?>

        <h3 class="widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

    <div class="blog-posts">

        <?php $options = get_option('second-touch');
        $image_crop = $options['thumb_image_crop'];
        if ($image_crop == "") {
            $image_crop = true;
        }
        ?>

        <?php if ($categories) {
            $args = array(
                'category__in' => array($categories),
                'posts_per_page' => $no_of_posts,
                'ignore_sticky_posts' => 'true'
            );
        } else {
            $args = array(
                'posts_per_page' => $no_of_posts,
                'ignore_sticky_posts' => 'true'
            );
        }

        $the_query = new WP_Query($args);

        while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <article <?php post_class(); ?>>

                <div class="post-media">
                    <?php

                    if (has_post_format('video')) {
                        get_template_part('templates/post', 'video');
                    } elseif (has_post_format('audio')) {
                        get_template_part('templates/post', 'audio');
                    } elseif (has_post_format('gallery')) {
                        get_template_part('templates/post', 'gallery');
                    } else {

                        if ($thumbnail && (has_post_thumbnail())) {
                            $thumb = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                            if ($options['post_thumbnails_width'] != '' && $options['post_thumbnails_height'] != '') {
                                $article_image = aq_resize($img_url, $options['post_thumbnails_width'], $options['post_thumbnails_height'], $image_crop);
                            } else {
                                $article_image = aq_resize($img_url, 1200, 500, $image_crop);
                            }
                            ?>

                            <div class="entry-thumb">
                                <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">

                                <?php if (comments_open()) : ?>
                                    <span class="comments-link"> <?php comments_popup_link(__('No Comments', 'crum'), __('1 Comment', 'crum'), __('% Comments', 'crum')); ?></span>
                                <?php endif; ?>

                            </div>

                        <?php
                        }
                    } ?>

                </div>

                <header>

                    <?php if ($show_data): ?>
					<?php if ($info_box_type == 'avatar'){
		            $date = get_avatar(get_the_author_meta('ID'), apply_filters('reactor_status_avatar', '70'));
		            echo $date;
	                }else{
	                ?>
                    <time class="date">
                        <span class="day"><?php echo get_the_date('d'); ?></span>
                        <span class="month"><?php echo get_the_date('F Y'); ?></span>
                    </time>
                    <?php }endif; ?>

                    <div class="ovh">

                        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                        <?php if ($show_meta): ?>

                            <div class="entry-meta dopinfo">

                                <span class="byline author vcard"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></span>

                                <?php
                                $post_tags = wp_get_post_tags($post->ID);
                                if (!empty($post_tags)) {
                                    ?>

                                    <span class="delim"> </span>
                                    <div class="post-tags"> <?php echo __('Post tags: ', 'crum') . ' ';
                                        the_tags('', ', ', ''); ?></div>

                                <?php } ?>

                            </div>

                        <?php endif; ?>

                    </div>

                </header>

                <div class="entry-content">
                    <?php if ($show_data): ?>

                        <div class="post-format">

                            <?php if (has_post_format('video')) {
                                echo '<i class="linecon-videocam"></i>';
                            } elseif (has_post_format('audio')) {
                                echo '<i class="linecon-sound"></i>';
                            } elseif (has_post_format('gallery')) {
                                echo '<i class="linecon-camera"></i>';
                            } else {
                                echo '<i class="linecon-pencil"></i>';
                            } ?>

                        </div>
                    <?php endif; ?>
                    <div class="ovh">
                        <?php if ($excerpt): ?>
                            <p>
	                            <?php
	                            $excerpt_length = $excerpt_length ? $excerpt_length : '20';
	                            if ( $display_readmore == '0' ) {
		                            echo mvb_wordwrap( get_the_excerpt(), $excerpt_length );
	                            } else {
		                            content($excerpt_length);
	                            }
	                            ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>


            </article>

        <?php endwhile; ?>

    </div>

    <?php wp_reset_query() ?>

</div>