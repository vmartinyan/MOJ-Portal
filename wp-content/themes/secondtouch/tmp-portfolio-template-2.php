
<?php
/*
Template Name: Portfolio 2 columns
*/
crum_header();
$options = get_option('second-touch');

get_template_part('templates/top', 'page'); ?>


    <section id="layout">

        <div class="row">
            <div class="twelve rows">
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            </div>
        </div>

        <?php

        $number_per_page = (get_post_meta($post->ID, 'folio_number_to_display', true)) ? get_post_meta($post->ID, 'folio_number_to_display', true) : '16';

        $selected_custom_categories = wp_get_object_terms($post->ID, 'my-product_category');
        if (!empty($selected_custom_categories)) {
            if (!is_wp_error($selected_custom_categories)) {
                foreach ($selected_custom_categories as $term) {
                    $blog_cut_array[] = $term->term_id;
                }
            }
        }

        $folio_custom_categories = (get_post_meta(get_the_ID(), 'folio_sort_category', true)) ? $blog_cut_array : '';

        if ($folio_custom_categories) {
            $folio_custom_categories = implode(",", $folio_custom_categories);
        }

        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        if ($options["folio_sorting"]) {
            $taxonomy = 'my-product_category';
            if ($folio_custom_categories) {
                $categories = get_terms($taxonomy, array('include' => $folio_custom_categories));
            } else {
                $categories = get_terms($taxonomy);
            }
        }

        if (!isset($options['orderby_folio_posts'])){
	        $folio_orderby = 'title';
        }else{
	        $folio_orderby = $options['orderby_folio_posts'];
        }

        if (!isset($options['orderby_folio_posts'])){
	        $folio_order = 'ASC';
        }else{
	        $folio_order = $options['order_folio_posts'];
        }

        ?>

        <div class="row">

            <div id="portfolio-page">

                <?php if ($options["folio_sorting"]) { ?>

                    <div class="sort-panel twelve columns">
                        <ul class="filter">
                            <li class="active"><a data-filter=".project" href="#"><?php echo __('All', 'crum'); ?></a>
                            </li>
                            <?php
                            foreach ($categories as $category) {
                                echo '<li><a href="#"  data-filter=".project[data-category~=\'' . strtolower(preg_replace('/\s+/', '-', $category->slug)) . '\']">' . $category->name . '</a></li>';
                            } ?>

                        </ul>
                    </div>

                <?php } ?>

                <div class="works-list">

                    <?php

                    $slug = 'my-product';


                    if ($folio_custom_categories) {
                        $args = array(
                            'post_type' => $slug,
                            'order' => $folio_order,
                            'orderby' => $folio_orderby,
                            'posts_per_page' => $number_per_page,
                            'paged' => $paged,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'my-product_category',
                                    'field' => 'id',
                                    'terms' => $blog_cut_array,
                                )
                            )
                        );
                    } else {
                        $args = array(
                            'post_type' => $slug,
                            'order' => $folio_order,
                            'orderby' => $folio_orderby,
                            'posts_per_page' => $number_per_page,
                            'paged' => $paged
                        );
                    }

                    $wp_query = new WP_Query($args);


                    while ($wp_query->have_posts()) : $wp_query->the_post();

                        $terms = get_the_terms(get_the_ID(), 'my-product_category');


                        if (has_post_thumbnail()) {
                            $thumb = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                        } else {
                            $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
                        }

                        $article_image = aq_resize($img_url, 600, 300, true); ?>

						<?php if ( get_post_meta( get_the_ID(), 'folio_embed', true ) ) :
							$img_url = get_post_meta( get_the_ID(), 'folio_embed', true );
						endif; ?>

                        <div class="six columns project" data-category="<?php foreach ($terms as $term) {
                            echo strtolower(preg_replace('/\s+/', '-', $term->slug)) . ' ';
                        } ?>">
                            <div class="entry-thumb">
                                <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                                    <span class="hover-box">
                                        <a href="<?php the_permalink(); ?>" class="more-link"> </a>
                                        <a href="<?php echo $img_url; ?>" class="zoom-link"> </a>
                                    </span>
                            </div>

                            <h4 class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                            <span class="dopinfo"><?php get_template_part('templates/folio', 'terms'); ?></span>

							<?php if($options['portfolio_excerpt'] == 1):?>
								<div class="entry-summary">
									<?php content($options['excerpt_length'])?>
								</div>
							<?php endif;?>
                        </div>




                    <?php endwhile; // END the Wordpress Loop ?>

                </div>

                <?php if ($wp_query->max_num_pages > 1) : ?>

                    <nav class="page-nav">

                        <?php echo crumina_pagination(); ?>

                    </nav>

                <?php endif; ?>

                <?php
                wp_reset_query();
                ?>

            </div>
        </div>
    </section>

<?php
if ($options["folio_sorting"]) {

    wp_enqueue_script('isotope');
    wp_enqueue_script('isotope-run');
}
?>
<?php crum_footer();?>