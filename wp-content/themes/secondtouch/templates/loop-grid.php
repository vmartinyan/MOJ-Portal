<?php $options = get_option('second-touch');
$image_crop = $options['thumb_image_crop'];
if ($image_crop == "") {
    $image_crop = true;
}

if (has_post_thumbnail()) {
	$thumb = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
	$image_crop = $options['thumb_image_crop'];

	if ( $image_crop == '1' ) {
		$thumb_width  = $options['post_thumbnails_width'];
		$thumb_height = $options['post_thumbnails_height'];
	} else {
		$thumb_width  = 430;
		$thumb_height = 220;
	}
	$article_image = aq_resize($img_url, $thumb_width, $thumb_height, true);
}


$format = get_post_format();
if (false === $format) {
    $format = 'standard';
} ?>

<article class="hnews hentry small-news four columns post post-<?php the_ID(); ?> <?php echo 'format-' . $format ?>">

    <?php

    if (has_post_thumbnail()) {
        $thumb = get_post_thumbnail_id();
        $img_url = wp_get_attachment_url($thumb, 'large'); //get img URL

        if (is_page_template('tmp-posts-masonry-2-side.php')) {

			if ( $image_crop == '1' ) {
				$thumb_width  = $options['post_thumbnails_width'];
				$thumb_height = $options['post_thumbnails_height'];
			} else {
				$thumb_width  = 407;
				$thumb_height = 270;
			}
            $article_image = aq_resize($img_url, $thumb_width, $thumb_height, $image_crop);

        } elseif (is_page_template('tmp-posts-masonry-2.php')) {

			if ( $image_crop == '1' ) {
				$thumb_width  = $options['post_thumbnails_width'];
				$thumb_height = $options['post_thumbnails_height'];
			} else {
				$thumb_width  = 567;
				$thumb_height = 320;
			}
            $article_image = aq_resize($img_url, $thumb_width, $thumb_height, $image_crop);

        } else {

			if ( $image_crop == '1' ) {
				$thumb_width  = $options['post_thumbnails_width'];
				$thumb_height = $options['post_thumbnails_height'];
			} else {
				$thumb_width  = 567;
				$thumb_height = 320;
			}
            $article_image = aq_resize($img_url, $thumb_width, $thumb_height, $image_crop);
        }

        ?>


        <div class="entry-thumb ">
            <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
            <a href="<?php the_permalink(); ?>" class="link"></a>

            <?php if (comments_open()) : ?>
                <span class="comments-link"> <?php comments_popup_link(__('No Comments', 'crum'), __('1 Comment', 'crum'), __('% Comments', 'crum')); ?></span>
            <?php endif; ?>

        </div>

    <?php
    } ?>


    <?php if ($options['post_header']) : ?>

        <div class="ovh">
            <?php get_template_part('templates/entry-meta', 'date'); ?>
        </div>

    <?php else : ?>

        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

    <?php endif; ?>


    <div class="entry-summary">

        <p><?php content($options['excerpt_length']) ?></p>

    </div>


</article>

