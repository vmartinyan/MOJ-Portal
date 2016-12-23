<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
}

$module_style = isset( $module_style ) ? $module_style : 0;
?>

<div class="testimonials_module <?php echo $css ?> <?php echo $cr_effect; ?>">

    <h3 class="widget-title">

        <?php echo $main_title ?>

    </h3>

    <div id="<?php echo $unique_id ?>">

        <div class="testimonials-slide">

	        <?php
            if ( '1' === $module_style ) {
		        $item_style = 'style="display:block"';
	        }else{
		        $item_style = '';
	        }
	        ?>

            <?php foreach ($r_items as $item): ?>

                <div class="testimonials_item" <?php echo $item_style;?>>

                    <div class="avatar">
                        <?php
                        if ($item['image']) {

                            $img_url = wp_get_attachment_url($item['image']);

                            $article_image = aq_resize($img_url, 80, 80, true);
                            ?>

	                        <?php
	                        if (isset($item['link_url']) && !($item['link_url'] == '') ) {

		                        $_link = $item['link_url'];

	                        } elseif (isset($item['page_id']) && is_numeric($item['page_id']) AND $item['page_id'] > 0) {

		                        $_link = get_page_link($item['page_id']);

	                        }?>
	                        <?php if (isset($item['new_window']) && ($item['new_window']) == '1'){
		                        $blank = 'target="_blank"';
	                        }else{
		                        $blank = '';
	                        }?>
	                        <?php if (isset($_link) && !($_link == '')) {
		                        echo '<a href="' . $_link . '" '.$blank.'>';
	                        } ?>

                            <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>">

	                        <?php if (isset($_link) && !($_link == '')) {
		                        echo '</a>';
	                        } ?>

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

    <?php if (count($r_items) > 1 && !('1' === $module_style)): ?>

        <script type="text/javascript">

            var $rtl = false;

            if (jQuery("body").hasClass("rtl")) {
                $rtl = true;
            }

            jQuery(document).ready(function () {
                jQuery('#<?php echo $unique_id ?>').flexslider({
                    selector: ".testimonials-slide > .testimonials_item",
                    namespace: "testimonials-",
                    animation: "slide",
                    rtl: $rtl,
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
