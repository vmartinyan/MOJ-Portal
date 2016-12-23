<?php $options = get_option('second-touch');

$archive_style = isset($options['archive_style']) ? $options['archive_style'] : '';
$sharrre_blog_post = isset($options['sharrre_blog_post']) ? $options['sharrre_blog_post'] : false;

?>

<?php  if (!have_posts()) : ?>

    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1><?php _e( 'Nothing Found', 'crum' ); ?></h1>
        </header>

        <div class="entry-content">
            <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'crum' ); ?></p>
            <?php get_search_form(); ?>
        </div>


        <header class="entry-header">
            <h2><?php _e('Tags also can be used', 'crum'); ?></h2>
        </header>

        <div class="tags-widget">
            <?php wp_tag_cloud('smallest=10&largest=10&number=30'); ?>
        </div>

    </article><!-- #post-0 -->
    <?php endif;

if ($archive_style == 'grid-2-columns') { ?>

    <div id="grid-posts" class="col-2">

        <?php while (have_posts()) : the_post();

            get_template_part('templates/loop', 'grid');

        endwhile; ?>

    </div>

     <?php wp_enqueue_script('js-masonry'); ?>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var container = document.querySelector('#grid-posts');
            var msnry = new Masonry(container, {
                itemSelector: 'article.small-news',
                columnWidth : container.querySelector('article.small-news')
            });
            imagesLoaded(container, function () {
                msnry.layout();
            });
        });
    </script>

<?php } elseif ($archive_style == 'grid-3-columns') { ?>

    <div id="grid-posts">

        <?php while (have_posts()) : the_post();

            get_template_part('templates/loop', 'grid');

        endwhile; ?>

    </div>

    <?php wp_enqueue_script('js-masonry'); ?>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var container = document.querySelector('#grid-posts');
            var msnry = new Masonry(container, {
                itemSelector: 'article.small-news',
                columnWidth : container.querySelector('article.small-news')
            });
            imagesLoaded(container, function () {
                msnry.layout();
            });
        });
    </script>

<?php }elseif ($archive_style == 'right-image') { ?>

    <?php while (have_posts()) : the_post(); ?>

        <article <?php post_class(); ?>>

            <div class="row some-aligned-post right-thumbed">

                <div class="six columns">

                    <header>
                        <?php get_template_part('templates/entry-meta', 'date'); ?>
                    </header>

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
                    <div class="entry-content">
                        <?php content($options['excerpt_length']); ?>
                    </div>

                </div>

                <div class="post-media six columns">
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
                            $image_crop = $options['thumb_image_crop'];

                            if ( $image_crop == '1' ) {
                                $thumb_width  = $options['post_thumbnails_width'];
                                $thumb_height = $options['post_thumbnails_height'];
                            } else {
                                $thumb_width  = 430;
                                $thumb_height = 220;
                            }
                            $article_image = aq_resize($img_url, $thumb_width, $thumb_height, true);
                        } ?>

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

                    <?php } ?>

                </div>

            </div>

        </article>

    <?php endwhile; ?>

<?php } elseif ($archive_style == 'left-image') { ?>

    <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

        <article <?php post_class(); ?>>

            <div class="row some-aligned-post left-thumbed">
                <div class="post-media six columns">
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
                            $image_crop = $options['thumb_image_crop'];

                            if ( $image_crop == '1' ) {
                                $thumb_width  = $options['post_thumbnails_width'];
                                $thumb_height = $options['post_thumbnails_height'];
                            } else {
                                $thumb_width  = 430;
                                $thumb_height = 220;
                            }
                            $article_image = aq_resize($img_url, $thumb_width, $thumb_height, true);
                        } ?>

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

                    <?php } ?>

                </div>
                <div class="six columns">

                    <header>
                        <?php get_template_part('templates/entry-meta', 'date'); ?>
                    </header>

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
                    <div class="entry-content">
                        <?php content($options['excerpt_length']); ?>
                    </div>

                </div>
            </div>
        </article>

    <?php endwhile; ?>

<?php } else {

    while (have_posts()) : the_post();



        if (has_post_format('link')) {
            get_template_part('templates/post', 'link');
        } else {
            get_template_part('templates/loop-content');
        }

    endwhile;

} ?>

<?php if ($wp_query->max_num_pages > 1) : ?>

<nav class="page-nav">

    <?php echo crumina_pagination(); ?>

</nav>

<?php endif; ?>
