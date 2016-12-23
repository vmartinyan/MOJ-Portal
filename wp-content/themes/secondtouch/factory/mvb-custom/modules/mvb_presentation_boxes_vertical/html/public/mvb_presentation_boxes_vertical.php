<?php if ($effects) {
    $cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
    $cr_effect = '';
} ?>

<div class="features_module_vertical module <?php echo $css ?>">

    <?php if ($main_title != ''): ?>

        <h3 class="widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

    <?php if (count($r_items) > 0): ?>
        <div class="row">

            <?php foreach ($r_items as $panel): ?>

                <?php

                if (isset($panel['image']) && $panel['image']) {

                    $img = wp_get_attachment_url($panel['image']);

                    $tile_image = aq_resize($img, 134, 134, true);
                } else {
                    $tile_image = false;
                }

                if (isset($panel['link_url']) && ($panel['link_url'] != '')) {

                    $_link = $panel['link_url'];

                } elseif (isset($panel['page_id']) && is_numeric($panel['page_id']) AND $panel['page_id'] > 0) {

                    $_link = get_page_link($panel['page_id']);

                }  ?>

                <div class="feature-box  <?php echo $cr_effect; ?>">

                    <?php if ($tile_image) {
                        echo '<img class="single-image" src = "' . $tile_image . '" alt ="' . $panel['main_title'] . '" />';
                    } elseif ($panel['icon']) {
                        ?>
                        <i class="single-icon <?php echo $panel['icon']; ?>" style="<?php if ($panel['icon_size']) {
                            echo 'font-size:' . $panel['icon_size'] . 'px; ';
                        } ?> <?php if ($panel['icon_color']) {
                            echo 'color:#' . $panel['icon_color'] . '; ';
                        } ?>"
                            <?php if ($panel['icon_hover_color']) { ?> onmouseover="this.style.color='#<?php echo $panel['icon_hover_color']; ?>'" <?php } ?>
                            <?php if ($panel['icon_color']) { ?> onmouseout="this.style.color='#<?php echo $panel['icon_color']; ?>'" <?php } ?>></i>
                    <?php
                    }

                    ?>

                    <div class="feat-block-content">

                        <?php if (isset($_link) && $_link) {
                            echo '<a href="' . $_link . '">';
                        } ?>

                        <h3><?php echo $panel['main_title'] ?></h3>

                        <?php if (isset($_link) && $_link) {
                            echo '</a>';
                        } ?>

                        <h6><?php echo $panel['sub_title'] ?></h6>

                        <?php if ($panel['content'] != ''): ?>
                            <?php echo mvb_parse_content($panel['content'], TRUE); ?>
                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>