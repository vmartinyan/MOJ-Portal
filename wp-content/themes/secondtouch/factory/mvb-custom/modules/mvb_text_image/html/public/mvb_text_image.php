<div class="module module-text">

	<?php if ( ! empty( $main_title ) ) { ?>
		<h3 class="widget-title">
			<?php echo $main_title ?>
		</h3>
	<?php } ?>

	<?php if ( $image ) {
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
		$article_image = aq_resize( $img_url, $width, $height, false);
	}
	?>

	<div class="textwidget-with-image">
		<?php if ( $image ) {
			echo '<img src="' . $article_image . '" alt= "' . $main_title . '" class= "align' . $box_align . '"/>';
		}   ?>
		<?php echo mvb_parse_content($content, true) ?>
	</div>


</div>
