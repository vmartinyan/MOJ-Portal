<form role="search" method="get" class="form-search searchform" action="<?php echo home_url('/'); ?>">
  <label class="hide" for="s"><?php _e('Search for:', 'crum'); ?></label>
  <input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="search-query" placeholder="<?php _e('Search', 'crum'); ?> <?php bloginfo('name'); ?>">
  <input type="submit" class="searchsubmit" value="<?php _e('Search', 'crum'); ?>" class="btn">
</form>