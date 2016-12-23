<div class="bshaper_vimeo_module <?php echo $css ?>">
   <?php if( $main_title != '' ): ?>
   <<?php echo $heading ?> class="modTitle"<?php if( $heading_color != '' ): ?> style="color: #<?php echo $heading_color ?>"<?php endif; ?>>
              <?php echo $main_title ?>
   </<?php echo $heading ?>>
   <?php endif; ?>
   <?php echo mvb_parse_content_html($content, true) ?>
</div>