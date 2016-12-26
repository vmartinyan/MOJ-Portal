<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="testimonials_module <?php echo $css ?> <?php echo $cr_effect; ?>">

    <h3 class="widget-title">

        <?php echo $main_title ?>

    </h3>

    <div id="<?php echo $unique_id ?>">

        <div class="testimonials-slide">
            <?php foreach ($r_items as $item): ?>

                <div class="testimonials_item">

                    <div class="avatar">
                        <?php
                        if ($item['image']) {

                            $img_url = wp_get_attachment_url($item['image']);

                            $article_image = aq_resize($img_url, 80, 80, true);
                            ?>

                            <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>">

                        <?php } ?>
                    </div>
                    <blockquote>
                        <?php echo mvb_parse_content($item['content']) ?>
                    </blockquote>

                    <div class="cite">

                        <?php if ($item['main_title']): ?>

                            <span class="quote-author box-name"><?php echo $item['main_title']; ?></span>

                        <?php endif;

                        if ($item['client_job']): ?>

                            <span class="quote-sub dopinfo"><?php echo $item['client_job']; ?></span>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <?php if (count($r_items) > 1): ?>

        <script type="text/javascript">

            jQuery(document).ready(function () {
                jQuery('#<?php echo $unique_id ?>').flexslider({
                    selector: ".testimonials-slide > .testimonials_item",
                    namespace: "testimonials-",
                    animation: "slide",
                    itemMargin: 3,
                    <?php if ($autoslideshow == '1' ){?>
					slideshow: true,
					<?php } else {?>
					slideshow: false,
					<?php }?>
                    direction: "horisontal",
                    controlNav: true,
                    directionNav: false
                });
            });

        </script>
    <?php endif; ?>

</div>
