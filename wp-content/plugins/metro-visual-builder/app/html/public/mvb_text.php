<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="module module-text <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if( $main_title != '' ): ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php endif; ?>

    <div class="textwidget">
        <?php echo mvb_parse_content($content, true) ?>
    </div>


</div>