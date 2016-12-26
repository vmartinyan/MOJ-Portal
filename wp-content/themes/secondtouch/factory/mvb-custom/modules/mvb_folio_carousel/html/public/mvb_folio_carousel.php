<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
}


$options = get_option('second-touch');


    $slug = 'my-product';


?>

<div class="module recent-block  <?php echo $cr_effect; ?>">
	<?php if ( ! empty( $main_title ) ) { ?>
		<h3 class="widget-title">
			<?php echo $main_title ?>
		</h3>
	<?php } ?>


	<?php

    echo '<div class="block-news-feature">';
    $the_query = null;
    $sticky = get_option('sticky_posts');


    if ($categories){
        $args = array(
            'tax_query' => array(

                array(
                    'taxonomy' => 'my-product_category',
                    'field' => 'id',
                    'terms' => $categories
                )
            ),
            'post_type' => $slug,
            'posts_per_page' => $no_of_posts,
        );
    } else {
        $args = array(
            'post_type' => $slug,
            'posts_per_page' => $no_of_posts,
        );
    }

    $the_query = new WP_Query($args);
    echo '<div id="'. $unique_id .'" class="post-carousel-wrap">';

    while ($the_query->have_posts()) : $the_query->the_post();

        $format = get_post_format();
        if (false === $format) {
            $format = 'standard';
        }

        $thumb = get_post_thumbnail_id();

        if (has_post_thumbnail()) {
            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
            $article_image = aq_resize($img_url, 390, 245, true);
        } else {
            $article_image = $no_image;
        } ?>

        <div class="post-carousel-item">

            <div class="item" style="background: url(<?php echo $article_image; ?>) center;">

                <span class="icon-format <?php echo $format ?>"><i class="linecon-"></i></span>

                <div class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                <div class="text"><?php content(13); ?></div>

            </div>

        </div>

    <?php

    endwhile;
    wp_reset_postdata();

    echo '</div>';

    wp_enqueue_style('slick_slider_css');
    wp_enqueue_script('slick_slider_js');

    ?>

    <script type="text/javascript">
        jQuery(document).ready(function () {


            var news_row = jQuery('#<?php echo $unique_id ?>');
            var item_width = news_row.width() / 2;

            jQuery('#<?php echo $unique_id ?>').slick({

	            dots: false,
	            infinite: true,
	            speed: 300,
	            slidesToShow: 2,
	            slidesToScroll: 1,
	            responsive: [
		            {
			            breakpoint: 480,
			            settings: {
				            slidesToShow: 1,
				            slidesToScroll: 1
			            }
		            }
	            ]
            });

        });
    </script>

</div>