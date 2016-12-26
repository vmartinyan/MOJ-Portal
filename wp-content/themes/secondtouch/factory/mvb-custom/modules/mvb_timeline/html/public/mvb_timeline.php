<?php if ($effects) {
    $cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
    $cr_effect = '';
} ?>

<div class="module timeline_module">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>

    <div class="timelime">

        <?php

        $post_order = (isset($post_order) && $post_order == 'DESC') ? $post_order : 'ASC';

        $limit_number = (isset($limit_number)) ? $limit_number : '-1';

        $args = array(
            'posts_per_page' => $limit_number,
            'post_type' => 'timeline',
            'orderby' => 'menu_order',
            'order' => $post_order
        );


        $the_query = new WP_Query($args);

        $i = '1';

        while ($the_query->have_posts()) :  $the_query->the_post();

            if ($i % 2 == 0) {
                $item_class = 'even';
            } else {
                $item_class = 'odd';
            }

            ?>


            <div class="timeline-item <?php echo $item_class; ?> <?php echo $cr_effect; ?>">

                <div class="timeline-title"><?php the_title(); ?></div>

                <?php

                $enable_composer = get_post_meta( $the_query->post->ID, '_bshaper_activate_metro_builder', true );

                if($enable_composer){
                    $meta_value = get_post_meta( $the_query->post->ID, '_bshaper_artist_content', true );
                    if ( ! empty( $meta_value ) ) {
                        echo do_shortcode( $meta_value[0]['columns'][0]['shortcodes'] );
                    }
                }else{
                    the_content();
                }

                ?>

            </div>



            <?php
            $i++;

        endwhile;

        wp_reset_postdata();    ?>

    </div>


</div>
