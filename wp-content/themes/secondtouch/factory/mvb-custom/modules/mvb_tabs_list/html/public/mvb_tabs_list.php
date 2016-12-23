<div class="vertical_tabs_module module <?php echo $css ?>">


    <?php if ($main_title != ''): ?>

        <h3 class="widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

    <div class="row">
        <div class="five columns">
            <dl class="vertical tabs">

                <?php $i = 1; ?>
                <?php foreach ($r_items as $item): ?>

                    <dd <?php if ($i == '1'): ?> class="active"<?php endif; ?>>
                        <a href="#<?php echo $unique_id . '-' . $i ?>">
                            <span class="icon"><i class="<?php echo $item['icon']; ?>"></i></span>
                            <span class="tab-title"><?php echo esc_attr($item['tab_title']); ?></span>
                        </a>
                    </dd>

                    <?php $i++; ?>
                <?php endforeach; ?>

            </dl>
        </div>

        <div class="seven columns">
            <ul class="tabs-content">

                <?php $i = 1; ?>
                <?php foreach ($r_items as $item): ?>

                    <li <?php if ($i == '1'): ?> class="active"<?php endif; ?> id="<?php echo $unique_id . '-' . $i; ?>Tab">
                        <?php echo mvb_parse_content_html($item['content'], TRUE) ?>
                    </li>

                    <?php $i++; ?>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>