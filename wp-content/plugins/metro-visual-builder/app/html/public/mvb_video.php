<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
}
?>

<div class="video_module module <?php echo $css ?>">

    <?php if ($main_title != ''): ?>

        <h3 class="twelve columns widget-title">

            <?php echo $main_title ?>

        </h3>


    <?php endif; ?>

    <?php if ($content){

		if ($content_width > 0){
			$block_width = $content_width;
		}else{
			$block_width = 1200;
		}

	    if ($content_height > 0){
		    $block_height = $content_height;
	    }else{
		    $block_height = false;
	    }

        $embed_code = wp_oembed_get($content, array('width'=>$block_width));

        echo '<div class="video-box" style="width: '.$block_width.'px; height: '.$block_height.'px ">'.$embed_code.'</div>';
    }elseif(!($self_hosted_mp4 == '')){?>

	    <div class="flex-video widescreen vimeo"<?php echo 'style="width: '.$block_width.'px; height: '.$block_height.'px "';?>>
		    <?php
		    echo do_shortcode('[video src="'.$self_hosted_mp4.'"]')
		    ?>
	    </div>

    <?php }elseif($self_hosted_webM){?>
	    <div class="flex-video widescreen vimeo"<?php echo 'style="width: '.$block_width.'px; height: '.$block_height.'px "';?>>
		    <?php
		    echo do_shortcode('[video src="'.$self_hosted_webM.'"]')
		    ?>
	    </div>
<?php } ?>


</div>
