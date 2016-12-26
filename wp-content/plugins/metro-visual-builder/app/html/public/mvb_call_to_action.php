<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="to-action-block row  <?php echo $css ?> <?php echo $cr_effect; ?>">

	<?php if ($link_url != '' AND $button_text != '' && $button_alignment == 'left'): ?>
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

		?>

		<div class="three columns button-holder-left">
			<a href="<?php echo $link_url ?>" class="button button-icon right"

			   style="<?php echo $btn_color; echo $txt_color;?>"
				<?php if ($new_tab): ?> target="_blank"<?php endif; ?>>

				<?php if ($icon): ?><span class="icon <?php echo $icon; ?>"></span><?php endif; ?>
				<?php echo $button_text ?>

			</a>
		</div>
	<?php endif; ?>

	<?php if ($link_url != '' AND $button_text != ''){
		$alignment = '';
		if ($button_alignment == 'left'): $alignment = '-'.$button_alignment; endif;
        echo '<div class="nine columns text-holder'.$alignment.'">';
    } else {
        echo '<div class="twelve columns text-holder">';
    } ?>

    <?php if ($description): ?>
        <div class="block-description">
            <?php echo mvb_parse_content($description, TRUE) ?>
        </div>
    <?php endif; ?>

    <?php if ($content): ?>
        <div class="block-title">
            <?php echo mvb_parse_content($content, TRUE) ?>
        </div>
    <?php endif; ?>

    <?php echo '</div>'; ?>

    <?php if ($link_url != '' AND $button_text != '' && $button_alignment == 'right'): ?>
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

	    ?>

	    <div class="three columns button-holder">
            <a href="<?php echo $link_url ?>" class="button button-icon right"

	            style="<?php echo $btn_color; echo $txt_color;?>"
	            <?php if ($new_tab): ?> target="_blank"<?php endif; ?>>

                <?php if ($icon): ?><span class="icon <?php echo $icon; ?>"></span><?php endif; ?>
                <?php echo $button_text ?>

            </a>
        </div>
    <?php endif; ?>

</div>