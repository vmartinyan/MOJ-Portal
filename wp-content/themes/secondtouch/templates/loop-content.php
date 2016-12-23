<?php $options = get_option('second-touch');
$image_crop = $options['thumb_image_crop'];
$sharrre_blog_post = isset($options['sharrre_blog_post']) ? $options['sharrre_blog_post'] : false;
if ($image_crop == "") {
    $image_crop = true;
}
?>
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

            if (has_post_thumbnail()) {
                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                if ($options['post_thumbnails_width'] != '' && $options['post_thumbnails_height'] != '') {
                    $article_image = aq_resize($img_url, $options['post_thumbnails_width'], $options['post_thumbnails_height'], $image_crop);
                } else {
                    $article_image = aq_resize($img_url, 900, 400, $image_crop);
                }
                ?>

                <div class="entry-thumb">
                    <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                    <a href="<?php the_permalink(); ?>" class="link"></a>

                    <?php if (comments_open()) : ?>
                        <span class="comments-link"> <?php comments_popup_link(__('No Comments', 'crum'), __('1 Comment', 'crum'), __('% Comments', 'crum')); ?></span>
                    <?php endif; ?>

                    <?php if ($sharrre_blog_post) : ?>
                        <div class="post-sharrre" data-url="<?php the_permalink(); ?>" data-media="<?php echo $img_url; ?>"  data-text="<?php content('20', true); ?>"></div>
                    <?php endif; ?>

                </div>


            <?php
            }
        } ?>

    </div>

    <header>
        <?php if ($options['post_header']) : ?>
            <?php get_template_part('templates/entry-meta', 'date'); ?>
        <?php else : ?>
            <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php endif; ?>
    </header>

    <?php if ($options['post_header']) : ?>
        <div class="post-format">

            <?php if (has_post_format('video')) {
                echo '<i class="linecon-video"></i>';
            } elseif (has_post_format('audio')) {
                echo '<i class="linecon-sound"></i>';
            } elseif (has_post_format('gallery')) {
                echo '<i class="linecon-camera"></i>';
            } else {
                echo '<i class="linecon-pen"></i>';
            } ?>

        </div>
    <?php endif; ?>
    <div class="entry-content">
        <?php content($options['excerpt_length']); ?>
    </div>


</article>