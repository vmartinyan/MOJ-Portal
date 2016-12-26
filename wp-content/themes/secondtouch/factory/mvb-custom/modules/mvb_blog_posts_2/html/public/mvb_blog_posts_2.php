<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="module_posts-style-2 <?php echo $css ?>">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>


    <?php


    if ($categories){
	    $cat_array = explode(',',$categories);
        $args = array(
            'category__in' => $cat_array,
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

    ?>
    <div class="post-list">

        <?php

        while ($the_query->have_posts()) : $the_query->the_post(); ?>

            <article class="mini-news clearfix <?php echo $cr_effect; ?>">
                <?php

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL

	                if (isset($thumb_width) && !($thumb_width == '') && ($thumb_width > 0)){
						$custom_width = $thumb_width;
	                }else{
						$custom_width = 80;
	                }

	                if (isset($thumb_height) && !($thumb_height == '') && ($thumb_height > 0)){
						$custom_height = $thumb_height;
	                }else{
						$custom_height = 80;
	                }

                 $article_image = aq_resize($img_url, $custom_width, $custom_height, true);

                    ?>
                    <div class="entry-thumb" style="width:<?php echo $custom_width.'px;';?> height:<?php echo $custom_height.'px;';?>">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>
                    </div>

                <?php } ?>

                <div class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                <?php if ($show_meta): ?>
                    <?php get_template_part('templates/entry-meta', 'mini'); ?>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

    </div>

    <?php wp_reset_postdata(); ?>

</div>