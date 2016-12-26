<div class="bshaper_flickr_module <?php echo $css ?>">
   <?php if( $main_title != '' ): ?>
   <<?php echo $heading ?> class="modTitle"<?php if( $heading_color != '' ): ?> style="color: #<?php echo $heading_color ?>"<?php endif; ?>>
              <?php echo $main_title ?>
   </<?php echo $heading ?>>
   <?php endif; ?>

   <div class="flickr_sh">
       <div id="<?php echo $unique_id ?>" class="mvb_row"></div>
       <script type="text/javascript">
          jQuery(function($){
              var the_width = Math.floor(jQuery('#<?php echo $unique_id ?>').width() / 3 );

              $('#<?php echo $unique_id ?>').jflickrfeed({
              	limit: <?php echo $no_of_photos ?>,
              	qstrings: {
              		id: '<?php echo $username ?>'
              	},
              	itemTemplate: '<div class="mvbc-<?php echo $mod_nr_of_columns ?> mvb-col"><div class="imgWrap"><a href="{{image}}" rel="prettyPhoto[flickr_<?php echo $unique_id ?>]"><img src="{{image_s}}" alt="{{title}}" /></a></div></div>'
              }, function(data) {
              	if (!jQuery.browser.msie && typeof('prettyPhoto') == "function")
                  {
            		jQuery("a[rel^='prettyPhoto']").prettyPhoto({
            			theme:'dark_rounded',
            			overlay_gallery: false,
            			show_title: true
            		});
                  }//endif
                  return false;
              });

          });
      </script>
    </div>
    <?php if( $view_profile_text != '' ): ?>
        <div class="clear"><!-- ~ --></div>
        <a href="http://www.flickr.com/photos/<?php echo $username ?>" target="_blank" class="bshaper_button"><?php echo $view_profile_text ?></a>
    <?php endif; ?>
</div>