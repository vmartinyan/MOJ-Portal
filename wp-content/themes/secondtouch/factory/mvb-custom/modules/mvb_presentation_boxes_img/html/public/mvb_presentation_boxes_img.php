<div class="features_module_img module <?php echo $css ?>">

    <?php if ($main_title != ''): ?>

        <h3 class="widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

    <?php if (count($r_items) > 0): ?>
        <div class="row">
            <?php foreach ($r_items as $panel): ?>

                <?php if ($panel['effects']) {
                    $cr_effect = ' cr-animate-gen"  data-gen="' . $panel['effects'] . '" data-gen-offset="bottom-in-view';
                } else {
                    $cr_effect = '';
                } ?>

                <?php if (isset($panel['link_url']) && ($panel['link_url'] != '')) {

                    $_link = $panel['link_url'];

                } elseif (isset ($panel['page_id']) && $panel['page_id'] && is_numeric($panel['page_id']) AND $panel['page_id'] > 0) {

                    $_link = get_page_link($panel['page_id']);

                }

                ?>

                <div class="<?php echo $column_number ?> columns feature-block-image <?php echo $cr_effect; ?>">

                    <?php

                    $img = mvb_aq_resize($panel['image'], 1180);

                    $style = 'color: #' . $panel['color'] . ' ';

                    ?>

                    <div class="picture" style=" <?php echo $style; ?>">
                        <?php if ($panel['image']) {
                            echo '<img src="' . $img . '" alt="' . $panel['main_title'] . '" class="blurImage" >';
                        } ?>

                        <?php if ($_link) {

                            echo '<a class="" href="' . $_link . '"> </a>';

                        }; ?>

                        <?php if (($panel['main_title']) || ($panel['sub_title'])) {
                            echo '<div class="feature-title">' . $panel['main_title'] . '';

                            if ($panel['sub_title']) {
                                echo '<div class="subtitle">' . $panel['sub_title'] . '</div>';
                            }
                            echo '</div>';
                        }
                        ?>

                    </div>

                    <?php if ($panel['content'] != ''): ?>
                        <div class="content">

                            <?php echo mvb_parse_content($panel['content'], TRUE); ?>
                        </div>
                    <?php endif; ?>


                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>