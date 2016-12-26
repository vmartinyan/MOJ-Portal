<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="module_posts-style-3 <?php echo $css ?>">

    <?php if ($main_title != ''): ?>

        <h3 class="widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

    <?php
    if ($categories){
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

    ?>

        <?php

        while ($the_query->have_posts()) : $the_query->the_post(); ?>

            <article class="hnews hentry featured-news clearfix vertical row <?php echo $cr_effect; ?>">

                <?php

                if(($box_align == 'horizontal') && has_post_thumbnail()) {
                    echo '<div class="six columns">';
                } else {
                    echo '<div class="twelve columns">';
                }


                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'medium'); //get img URL
                    $article_image = aq_resize($img_url, 460, 460, true);
                    ?>


                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>
                    </div>

                <?php }

                echo '</div>';

                if(($box_align == 'horizontal') && has_post_thumbnail()) {
                    echo '<div class="six columns horizontal">';
                } else {
                    echo '<div class="twelve columns">';
                } ?>

                <?php if ($show_meta): ?>
                    <?php get_template_part('templates/entry-meta', 'date'); ?>
                <?php endif; ?>

                <div class="entry-summary">

                    <p><?php echo mvb_wordwrap(get_the_excerpt(), $excerpt_length); ?></p>

                </div>

                <?php echo '</div>'; ?>

            </article>

        <?php endwhile; ?>

    <?php wp_reset_postdata(); ?>

</div>