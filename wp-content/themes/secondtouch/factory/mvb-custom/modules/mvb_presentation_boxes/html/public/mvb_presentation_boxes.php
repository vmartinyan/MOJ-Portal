<div class="features_module module <?php echo $css ?>">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>
    <div class="row">
        <?php if (count($r_items) > 0): ?>

            <?php foreach ($r_items as $panel): ?>

                <?php if (isset($panel['effects']) && $panel['effects'] ) {
                    $cr_effect = ' cr-animate-gen"  data-gen="' . $panel['effects'] . '" data-gen-offset="bottom-in-view';
                } else {
                    $cr_effect = '';
                } ?>

                <?php
                if (isset($panel['alignment']) && $panel['alignment']) {
                    $text_align = 'al-left';
                } else {
                    $text_align = 'al-top';
                }

                if (isset($panel['image']) && $panel['image']) {

                    $img = wp_get_attachment_url($panel['image']);

                    $tile_image = aq_resize($img, 134, 134, false);
                }
                if (isset($panel['flip_image']) && $panel['flip_image']) {

                    $img = wp_get_attachment_url($panel['flip_image']);

                    $flip_image = aq_resize($img, 134, 134, false);
                }

                if (isset($panel['link_url']) && $panel['link_url'] != '') {

                    $_link = $panel['link_url'];

                } elseif (isset($panel['page_id']) && is_numeric($panel['page_id']) AND $panel['page_id'] > 0) {

                    $_link = get_page_link($panel['page_id']);

                }
				$style ='';
                if (isset($tile_image) && ($tile_image)) {
                    $style .= 'background-image:url(' . $tile_image . '); ';
                    $style .= 'background-position: center; ';
                    $style .= 'background-repeat:  no-repeat; ';
                }


                if (isset($panel['flip_image']) && $panel['flip_image']) {
                    $style_back = 'background-image:url(' . $flip_image . '); ';
                    $style_back .= 'background-position: center; ';
                    $style_back .= 'background-repeat:  no-repeat; ';
                } else {
                    $style_back = '';
                }

                if (isset($panel['color']) && $panel['color']) {
                    $style .= 'background-color:#' . $panel['color'] . '; ';
                }

                if (isset($panel['icon']) && $panel['icon'] ) {
                    $icon = '<i class = "' . $panel['icon'] . '"> </i>';
                } else {
                    $icon = '';
                }  ?>


                <div class="<?php echo $column_number ?> columns <?php echo $cr_effect; ?>">

                    <div class="feature-box <?php echo $text_align; ?>">

                        <?php if (isset($panel['disable_flip'])) {

	                        ?> <div class="icon"> <?php

	                        if (isset($_link) && $_link) {
		                        $item_link = '<a class="link" href="' . $_link . '"> </a>';
	                        } else {
		                        $item_link = '';
	                        }

	                        echo '
                                <div class="front" style="' . $style . '"> ' . $icon . $item_link . '</div>';

	                        ?></div><?php

                        } else {
                            ?>

                            <div class="icon flipbox">

                                <?php

                                if (isset($_link) && $_link) {
                                    $item_link = '<a class="link" href="' . $_link . '"> </a>';
                                } else {
                                    $item_link = '';
                                }


                                echo '
                            <div class="front" style="' . $style . '"> ' . $icon . $item_link . '</div>
                            <div class="back" style="' . $style_back . '"> ' . $icon . $item_link . ' </div>';
                                ?>

                            </div>

                        <?php } ?>



                        <div class="block-title">
                            <?php  if (isset($_link) && $_link) {
                                echo '<a href="' . $_link . '">';
                            }
                            echo $panel['main_title'];

                            if (isset($_link) && $_link) {
                                echo '</a>';
                            } ?>
                        </div>

                        <div class="subtitle"><?php echo $panel['sub_title'] ?></div>

                        <?php if ($panel['content'] != ''): ?>
                            <div class="feat-block-content">
                                <?php echo mvb_parse_content($panel['content'], TRUE); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($panel['read_more']) && $_link) { ?>

                            <a href="<?php echo $_link; ?>" class="read-more"><?php echo $panel['read_more_text'] ?></a>

                        <?php } ?>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>