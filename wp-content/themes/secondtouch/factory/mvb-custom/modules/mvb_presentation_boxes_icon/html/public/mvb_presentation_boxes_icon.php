<div class="features_module module <?php echo $css ?>">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>
    <div class="row">
        <?php if (count($r_items) > 0): ?>

            <?php foreach ($r_items as $panel): ?>

                <?php if ($panel['effects']) {
                    $cr_effect = ' cr-animate-gen"  data-gen="' . $panel['effects'] . '" data-gen-offset="bottom-in-view';
                } else {
                    $cr_effect = '';
                } ?>

                <?php

                if (isset($panel['link_url']) &&($panel['link_url']!= '') ) {

                    $_link = $panel['link_url'];

                } elseif (isset($panel['page_id']) && $panel['page_id'] && is_numeric($panel['page_id']) AND $panel['page_id'] > 0) {

                    $_link = get_page_link($panel['page_id']);

                }

                if ($panel['icon_size']) {
                    $size = 'font-size:' . $panel['icon_size'] . 'px; ';
                }

                if ($panel['icon']) {
                    $icon = '<i class = "' . $panel['icon'] . '"> </i>';
                } else {
                    $icon = '';
                }  ?>


                <div class="<?php echo $column_number ?> columns <?php echo $cr_effect; ?>">

                    <div class="feature-box">
                        <?php  if (isset($_link) && $_link) {
                            echo '<a href="' . $_link . '">';
                        } ?>

                        <i class="single-icon <?php echo $panel['icon']; ?>" style="<?php if ($panel['icon_size']) { echo $size; } ?> <?php if ($panel['icon_color']) { echo 'color:#' . $panel['icon_color'] . ';'; } ?>"
                            <?php if ($panel['icon_hover_color']) { ?> onmouseover="this.style.color='#<?php echo $panel['icon_hover_color']; ?>'" <?php } ?>
                            <?php if ($panel['icon_color']) { ?> onmouseout="this.style.color='#<?php echo $panel['icon_color']; ?>'" <?php } ?>></i>
                        <?php
                        if (isset($_link) && $_link) {
                            echo '</a>';
                        } ?>
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

                        <?php if (isset($panel['read_more']) && $panel['read_more'] && $_link) { ?>

                            <a href="<?php echo $_link; ?>" class="read-more"><?php echo $panel['read_more_text'] ?></a>

                        <?php } ?>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>