<?php if (isset($effects) && $effects) {
    $cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
    $cr_effect = '';
}

$options = get_option('second-touch');

    $slug = 'my-product';

?>

<div class="module recent-block <?php echo $cr_effect; ?>">

    <?php if ($main_title != ''): ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php endif; ?>


    <div class="row">
        <div class="twelve columns">
            <dl class="tabs contained horisontal no-styling">

                <?php if (isset($categories) && $categories) {
                    $selected_category = true;
                } else {
                    $selected_category = false;
                    ?>

                    <dd class="active"><a href="#recent-all"><?php echo __('All', 'crum') ?></a></dd>

                <?php
                }

				$categories = (isset($categories)) ? $categories : '';

                $taxonomy = 'my-product_category';
                $args = array(
                    'include' => $categories
                );
                $categories = get_terms($taxonomy, $args);

                foreach ($categories as $category) {

                    echo '<dd><a href="#' . str_replace('-', '', $category->slug) . '">' . $category->name . '</a></dd>';
                }

                ?>

            </dl>


            <ul class="tabs-content contained folio-wrap clearfix cl">

                <?php if (!$selected_category): ?>
                    <li id="recent-allTab" class="active">

                        <?php



                        $args = array(
                            'post_type' => $slug,
                            'posts_per_page' => '4'
                        );
                        $the_query = new WP_Query($args);
                        while ($the_query->have_posts()) : $the_query->the_post();

                            if (has_post_thumbnail()) {
                                $thumb = get_post_thumbnail_id();
                                $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                            } else {
                                $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
                            }

                            $article_image = aq_resize($img_url, 293, 204, true);

                            ?>

                            <div class="folio-item">
                                <div class="entry-thumb">
                                    <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                                    <span class="hover-box">
                                        <a href="<?php the_permalink(); ?>" class="more-link"> </a>
                                        <a href="<?php echo $img_url; ?>" class="zoom-link"> </a>

                                        <?php echo getPostLikeLink(get_the_ID()); ?>

                                    </span>
                                </div>

                                <div class="box-name">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </div>

                                <?php if ($show_meta): ?>
                                    <span class="dopinfo">
                                <?php
                                $id = get_the_ID();

                                $product_terms = wp_get_object_terms($id, 'my-product_category');
                                $count = count($product_terms);
                                $i = 0;
                                if (!empty($product_terms)) {
                                    if (!is_wp_error($product_terms)) {
                                        foreach ($product_terms as $term) {
                                            $i++;
                                            echo ' <a href="' . get_term_link($term->slug, 'my-product_category') . '">' . $term->name . '</a>';
                                            if ($count != $i) echo ',&nbsp;'; else echo '';
                                        }
                                    }
                                }
                                ?>
                            </span>
                                <?php endif ?>

                            </div>



                        <?php endwhile; // END the Wordpress Loop ?>

                    </li>

                <?php
					$first = true;
                endif;


                // List the Portfolio Categories
                foreach ($categories as $category) {


                    if ( !$first && ($category == $categories[0]) ) {
						echo '<li id="' . str_replace('-', '', $category->slug) . 'Tab" class = "active">';
					} else {
						echo '<li id="' . str_replace('-', '', $category->slug) . 'Tab" >';
					}

                    $args = array(
                        'tax_query' => array(

                            array(
                                'taxonomy' => 'my-product_category',
                                'field' => 'slug',
                                'terms' => $category->slug
                            )
                        ),
                        'post_type' => $slug,
                        'posts_per_page' => '4'
                    );
                    $the_query = new WP_Query($args);
                    while ($the_query->have_posts()) : $the_query->the_post();

                        if (has_post_thumbnail()) {
                            $thumb = get_post_thumbnail_id();
                            $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                        } else {
                            $img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
                        }

                        $article_image = aq_resize($img_url, 293, 204, true);

                        ?>

                        <div class="folio-item">
                            <div class="entry-thumb">
                                <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                                    <span class="hover-box">
                                        <a href="<?php the_permalink(); ?>" class="more-link"> </a>
                                        <a href="<?php echo $img_url; ?>" class="zoom-link"> </a>

                                        <?php echo getPostLikeLink(get_the_ID()); ?>

                                    </span>
                            </div>

                            <div class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>
                            <?php if ($show_meta): ?>
                                <span class="dopinfo">

                                <?php
                                $id = get_the_ID();

                                $product_terms = wp_get_object_terms($id, 'my-product_category');
                                $count = count($product_terms);
                                $i = 0;
                                if (!empty($product_terms)) {
                                    if (!is_wp_error($product_terms)) {
                                        foreach ($product_terms as $term) {
                                            $i++;
                                            echo ' <a href="' . get_term_link($term->slug, 'my-product_category') . '">' . $term->name . '</a>';
                                            if ($count != $i) echo ',&nbsp;'; else echo '';
                                        }
                                    }
                                }
                                ?>

                            </span>
                            <?php endif ?>
                        </div>

                    <?php endwhile;

                    echo '</li>';

                    wp_reset_query();
                } ?>

            </ul>
        </div>
    </div>
</div>