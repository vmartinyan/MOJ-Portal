<?php if ($effects) {
    $cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
    $cr_effect = '';
} ?>

<div class="to-action-block <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if ($link_url != '' AND $button_text != ''): ?>

	    <?php if ($button_color){
		    $btn_color = 'background:#'.$button_color.';';
	    }else{
		    $btn_color = '';
	    }

	    if ($button_color_text){
		    $txt_color = 'color:#'.$button_color_text;
	    }else{
		    $txt_color = '';
	    }

	    $alignment = '';
	    if ($button_alignment == 'left') {
		    $alignment = '-left';
	    }

	    ?>
        <div class="button-holder-<?php echo $button_alignment;?>">
            <a href="<?php echo $link_url ?>" class="button button-icon"
               style="<?php echo $btn_color; echo $txt_color;?>"
                <?php if ($new_tab): ?> target="_blank"<?php endif; ?>>

                <?php if ($icon): ?><span class="icon <?php echo $icon; ?>"></span><?php endif; ?>
                <?php echo $button_text ?>

            </a>
        </div>
    <?php endif; ?>

    <div class="text-holder-<?php echo $button_alignment;?>">

        <?php if ($content): ?>
            <div class="block-title">
                <?php echo mvb_parse_content($content, TRUE) ?>
            </div>
        <?php endif; ?>
    </div>

</div>