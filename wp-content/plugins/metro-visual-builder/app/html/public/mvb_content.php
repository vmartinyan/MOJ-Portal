<div class="bshaper_content_module <?php echo $css ?>">
   <?php if( $main_title != '' ): ?>
   <<?php echo $heading ?> class="modTitle"<?php if( $heading_color != '' ): ?> style="color: #<?php echo $heading_color ?>"<?php endif; ?>>
              <?php echo $main_title ?>
   </<?php echo $heading ?>>
   <?php endif; ?>
   <div class="bshaper_text">
        <?php echo wpautop(do_shortcode($post->post_content)); ?>
   </div>
</div>