<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="module module-text <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if( !empty($main_title) ): ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php endif; ?>

	<div class="textwidget">
		<?php

		$array = array(
			'<p>['    => '[',
			']</p>'   => ']',
			']<br />' => ']'
		);
		echo strtr( mvb_parse_content($content), $array );

		?>
	</div>

</div>