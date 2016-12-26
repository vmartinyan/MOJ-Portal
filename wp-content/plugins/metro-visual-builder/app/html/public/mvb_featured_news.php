<?php if (isset($effects) && $effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>


<div class="module module-sticky-news mob-ile-twelve <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if ($main_title != ''): ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php endif; ?>

    <div class="crum_stiky_news">

        <div class="row">

            <?php

            while (have_posts()) :    the_post(); ?>

                <div class="twelve columns">
                    <div class="blocks-label">
                        <?php
                        if ($link_url) {

                            echo '<a href="' . $link_url . '">' . $link_label . '</a>';

                        } else {
                            echo $link_label;
                        }  ?>

                    </div>

                    <div class="blocks-text">
                        <p>
                            <a href="<?php the_permalink(); ?>"><?php echo mvb_wordwrap(get_the_excerpt(), $excerpt_length); ?></a>
                        </p>
                    </div>

                </div>

            <?php endwhile;

            wp_reset_query(); ?>

        </div>
    </div>
</div>