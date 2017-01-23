<?php if ( $effects ) {
    $cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
    $cr_effect = '';
} ?>

<div class="accodion_module module <?php echo $css . $cr_effect ?>">


    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>

    <ul class="accordion">

        <?php $i = 1; ?>

        <?php foreach ( $r_items as $item ): ?>
            <li <?php if ( ( $i == '1' ) && $collapse != '1' ) {
                echo 'class="active"';
            } ?>>
                <div class="title">
                    <span class="tab-title">
                        <?php echo $item['panel_title'] ?>
                    </span>
                    <?php if ( isset( $item['icon_2'] ) && ! empty( $item['icon_2'] ) && isset( $item['icon'] ) && ! empty( $item['icon'] ) ) { ?>
                        <span class="icon icon_active"><i class="<?php echo $item['icon_2']; ?>"></i></span>
                        <span class="icon icon_no_active"><i class="<?php echo $item['icon']; ?>"></i></span>
                    <?php } elseif ( isset( $item['icon'] ) && ! empty( $item['icon'] ) ) { ?>
                        <span class="icon"><i class="<?php echo $item['icon']; ?>"></i></span>
                    <?php } ?>

                </div>
                <div class="content">
                    <?php echo mvb_parse_content_html( $item['content'], true ) ?>
                </div>
            </li>

            <?php $i ++; ?>
        <?php endforeach; ?>

    </ul>

</div>
