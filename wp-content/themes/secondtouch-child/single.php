<?php
crum_header();
$options = get_option('second-touch');

get_template_part('templates/top', 'page'); ?>

<section id="layout">
    <div class="row">

        <?php

        set_layout('single', true);


        while (have_posts()) : the_post(); ?>

            <article <?php post_class(); ?>>

                <?php
                //if (($options["post_share_button"]) || ($options["custom_share_code"])) {

                //    get_template_part('templates/single', 'social');

                //} 
                ?>

                <div class="ovh">
					<!--<?php if(is_single()){ ?>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
					<?php }
                    else{?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php }?>-->
                    <?php if( get_post_type( get_the_ID() ) == 'ufaq' ){ ?>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
					<?php }
                    else{?>
					
					<?php }?>
                    <?php
                    if ($options['thumb_inner_disp'] == '1' && !(has_post_format('video')) && !(has_post_format('gallery')) && !(has_post_format('audio'))) {
                        if (has_post_thumbnail()) {
                            $thumb = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL

                                $article_image = aq_resize($img_url, 1200, 500, true);

                            ?>
                            <div class="post-media clearfix">
                                <div class="entry-thumb">
                                    <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    ?>

                    <div class="entry-content">

                        <?php  if (has_post_format('video')) {

                            get_template_part('templates/post', 'video');

                        } elseif (has_post_format('gallery')) {
                            get_template_part('templates/post', 'gallery');
                        }
                        if (has_post_format('audio')) {
                            get_template_part('templates/post', 'audio');

                        }
                        the_content(); ?>

                    </div>

                    <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'crum'), 'after' => '</p></nav>')); ?>

                </div>

	            <!--<span class="byline author vcard"> <?php echo __('By', 'crum'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>,</span>-->

            </article>

        <?php endwhile; ?>

        <?php   
        // if ($options["autor_box_disp"] == '1') {

       //     get_template_part('templates/author-box');
        //}
        if ( get_post_type( get_the_ID() ) == 'ufaq' ) {
        comments_template();
}

        set_layout('single', false);

        ?>

    </div>
</section>
<?php crum_footer();?>
