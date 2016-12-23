<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="module module-last-x-posts <?php echo $css ?>">

    <?php if ($main_title != ''): ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php endif; ?>

    <?php

    $sticky = get_option( 'sticky_posts' );

	$offset = (isset($offset)) ? $offset :-1;
    	if ($categories){
        $args = array(
            'category__in' => array($categories),
            'offset' => $offset,
            'posts_per_page' => 1,
            'ignore_sticky_posts' => 1,
            'post__not_in' => $sticky,
			'order' => $sort_order,
			'orderby' => $sort_orderby,
        );
    } else {
        $args = array(
            'posts_per_page' => 1,
            'offset' => $offset,
            'ignore_sticky_posts' => 1,
            'post__not_in' => $sticky,
			'order' => $sort_order,
			'orderby' => $sort_orderby,
        );
    }

    echo '<div class="row block-news-feature ">';
        $the_query = null;


        $the_query = new WP_Query( $args );
        while ( $the_query->have_posts() ) :
        $the_query->the_post();

        ?>

        <div class="twelve columns featured-news <?php echo $cr_effect; ?>">

            <article class="hnews hentry small-news vertical">

                <?php
                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'medium'); //get img URL
                    $article_image = aq_resize($img_url, 380, 270, false);
                    ?>


                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>
                        <?php if (comments_open()) : ?>
                            <span class="comments-link"> <?php comments_popup_link(__('No Comments', 'crum'), __('1 Comment', 'crum'), __('% Comments', 'crum')); ?></span>
                        <?php endif; ?>
                    </div>

                <?php } ?>

                <?php get_template_part('templates/entry-meta', 'date'); ?>

                <div class="entry-summary">

                    <p><?php content(16) ?></p>

                </div>

            </article>

        </div>

        <?php endwhile; wp_reset_postdata();?>

        <div class="twelve columns other-news">

            <?php
            $the_query = null;
            $sticky = get_option( 'sticky_posts' );

            if ($categories){
                $args = array(
                    'cat' => $categories,
                    'posts_per_page' => 3,
                    'offset' => ($offset + 1),
                    'ignore_sticky_posts' => 1,
                    'post__not_in' => $sticky,
					'order' => $sort_order,
					'orderby' => $sort_orderby,
                );

            } else {
                $args = array(
                    'posts_per_page' => 3,
                    'offset' => ($offset + 1),
                    'ignore_sticky_posts' => 1,
                    'post__not_in' => $sticky,
					'order' => $sort_order,
					'orderby' => $sort_orderby,
                );
            }


            $the_query = new WP_Query( $args );

            while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

            <article class="mini-news clearfix <?php echo $cr_effect; ?>">


                <?php if( has_post_thumbnail() ){
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL
                    $article_image = aq_resize($img_url, 80, 80, true);
                    ?>

                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>
                    </div>

                <?php  }  ?>

                <div class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                <?php get_template_part('templates/entry-meta', 'mini'); ?>

                <a href="<?php echo get_comments_link(get_the_ID()); ?>" class="mini-comm-count">
                    <?php comments_number('0', '1', '%'); ?>
                </a>

            </article>

<?php  endwhile; wp_reset_postdata();

echo '</div></div>'; ?>

</div>