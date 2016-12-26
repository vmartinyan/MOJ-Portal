<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="image_module module <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if ($main_title != ''): ?>

        <h3 class="widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

	<?php
	if ( $image ) {
		$img_url = mvb_get_image_url( $image );

		if ( ! ( $image_width == '' ) ) {
			$width = $image_width;
		} else {
			$width = 9999;
		}

		if ( ! ( $image_height == '' ) ) {
			$height = $image_height;
		} else {
			$height = 9999;
		}
		$article_image = aq_resize( $img_url, $width, $height );

		if ( $image_height == '' && $image_width == '' ) {
			$article_image = mvb_get_image_url( $image);
		}

	}?>

	<?php
	if ($link_url != '') {

		$_link = $link_url;

	} elseif (is_numeric($page_id) AND $page_id > 0) {

		$_link = get_page_link($page_id);

	}?>

	<?php if ($new_window == '1'){
		$blank = 'target="_blank"';
	}?>

	<?php if ($_link) {
		echo '<a href="' . $_link . '" '.$blank.'>';
	} ?>

	<?php echo '<img src="'.$article_image.'" alt= "'.$main_title.'" />';   ?>

	<?php if ($_link) {
		echo '</a>';
	} ?>



</div>