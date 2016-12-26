<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="promo_row_module module <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>

    <div class="row">
        <div class="ten columns centered">

            <?php echo '<img src="' . mvb_get_image_url($image) . '" alt= "' . $main_title . '" />'; ?>

            <?php echo mvb_parse_content($content, true) ?>

        </div>


    </div>

</div>