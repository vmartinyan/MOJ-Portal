<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="tiles-block tiles_module module <?php echo $css ?>">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>

    <?php foreach( $r_items as $item ): ?>

        <?php
        $item['image'] = (isset($item['image'])) ? $item['image'] : '';

		$img = wp_get_attachment_url($item['image']);

        $tile_image = aq_resize($img, 138, 138, true);

        if (isset($item['flip_image']) && $item['flip_image']) {
            $img = wp_get_attachment_url($item['flip_image']);
            $flip_image = aq_resize($img, 134, 134, false);
        }

		$style = '';

		if ($tile_image) {
            $style .= 'background-image:url('.$tile_image.'); ';
            $style .= 'background-position: center; ';
            $style .= 'background-repeat:  no-repeat; ';
        }

        if (isset($item['flip_image']) && $item['flip_image']) {
            $style_back = 'background-image:url(' . $flip_image . '); ';
            $style_back .= 'background-position: center; ';
            $style_back .= 'background-repeat:  no-repeat; ';
        } else {
            $style_back = '';
        }

        if (isset($item['color']) && $item['color']) {
            $style .= 'background-color: #' . $item['color'] . '; ';
        }
        if ($item['color_hover']) {
            $style_hover = 'background-color: #' . $item['color_hover'] . '; ';
        }
        if (isset($item['icon']) && $item['icon']){
            $icon = '<i class = "'.$item['icon'].'"> </i>';
        } else {
            $icon = '';
        }
        if (isset($item['link_url']) && ($item['link_url']!= '') ) {
            $_link =  $item['link_url'];
        } elseif( isset($item['page_id']) && is_numeric($item['page_id']) AND $item['page_id'] > 0 ){
            $_link = get_page_link($item['page_id']);
        }

        if ($_link) {
            $link = '<a class="link" href="'.$_link.'"></a>';
        } else {
            $link ='';
        }

		$item['tile_content'] = (isset($item['tile_content'])) ? $item['tile_content'] : '';

        if (isset($item['disable_flip']) && $item['disable_flip']) {
            $flip_class = 'no-flip';
        } else {
            $flip_class = 'flipbox';
        }

        ?>

        <div class="tile-item <?php echo $flip_class;?> <?php echo $cr_effect; ?>">

                <div class="front" style="<?php echo $style ?>"> <?php echo $icon; ?> <span class="tile-title"> <?php echo $item ['tab_title'] ?>  </span> <?php echo $link; ?></div>
                <div class="back" style="<?php echo $style_hover; ?> <?php echo $style_back; ?>'"> <?php echo $item['tile_content'] ?> <?php echo $link; ?> </div>

        </div>


    <?php endforeach; ?>
</div>


