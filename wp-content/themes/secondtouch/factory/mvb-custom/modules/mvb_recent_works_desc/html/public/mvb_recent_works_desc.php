<?php if ($effects) {
    $cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
    $cr_effect = '';
}

    $slug = 'my-product';



?>
<div class="module module-recent-block-desc <?php echo $css ?> <?php echo $cr_effect; ?>">
    <div class="row">
        <div class="three columns widget">

            <?php if ($main_title != ''): ?>

                <h3 class="widget-title">

                    <?php echo $main_title ?>

                </h3>


            <?php endif; ?>

            <?php if ($link_url != '') {

                $_link = $link_url;

            } elseif (is_numeric($page_id) AND $page_id > 0) {

                $_link = get_page_link($page_id);

            }         ?>

            <div class="desc-text">
            <?php echo mvb_parse_content($content, true) ?>

                <?php if ($read_more && $_link) { ?>

                    <a href="<?php echo $_link; ?>" class="read-more"><?php _e($read_more_text, "crum"); ?></a>

                <?php } ?>
        </div>

        </div>

        <div class="nine columns">
            <div class="recent-wrap">

                <?php

                $args = array(
                    'post_type' => $slug,
                    'posts_per_page' => '5'

                );
                $count = 1;
                $the_query = new WP_Query($args);

                while ($the_query->have_posts()) :
                    $the_query->the_post();

                    $thumb = get_post_thumbnail_id();

                    if ($thumb) {
                        $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
                    } else {
                        $img_url = 'no-image.jpg'; // place no-mage picture here
                    }

                    if ($count % 5 == 1) {
                        echo '<div class="big-element item"><div class="entry-thumb">';
                        echo '<img src="' . aq_resize($img_url, 437, 290, true) . '" alt="">';


                    } else {
                        echo '<div class="small-element item"><div class="entry-thumb">';
                        echo '<img src="' . aq_resize($img_url, 217, 143, true) . '" alt="">';
                    }
                    ?>
                    <span class="hover-box">
                            <a href="<?php the_permalink(); ?>" class="more-link"> </a>
                            <a href="<?php echo $img_url; ?>" class="zoom-link"> </a>

                        <?php echo getPostLikeLink(get_the_ID()); ?>

                        </span>
                    <?php

                    echo '</div></div>';

                    $count++;

                endwhile;
                wp_reset_query();   ?>

            </div>
        </div>
    </div>
</div>
