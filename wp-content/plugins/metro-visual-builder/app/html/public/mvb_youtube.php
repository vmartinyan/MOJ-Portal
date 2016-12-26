<div class="bshaper_youtube_module <?php echo $css ?>">
   <?php if( $main_title != '' ): ?>
   <<?php echo $heading ?> class="modTitle"<?php if( $heading_color != '' ): ?> style="color: #<?php echo $heading_color ?>"<?php endif; ?>>
              <?php echo $main_title ?>
   </<?php echo $heading ?>>
   <?php endif; ?>
   <?php if( $width == '100%' AND $height == '100%' ):  ?>
         <div class="iframe_holder_responsive"><img class="ratio" src="<?php echo mvb_placeholder() ?>"/><iframe src="http://www.youtube.com/embed/<?php echo get_youtube_video_id($content) ?>" frameborder="0" allowfullscreen="<?php echo $allowfullscreen ?>"></iframe></div>
   <?php else: ?>
         <iframe src="http://www.youtube.com/embed/<?php echo get_youtube_video_id($content) ?>" frameborder="0" width="<?php echo $width ?>" height="<?php echo $height ?>" allowfullscreen="<?php echo $allowfullscreen ?>"></iframe>
   <?php endif; ?>
</div>