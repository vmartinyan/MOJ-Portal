<div class="dopinfo">

    <time class="updated" datetime="<?php echo get_the_time('c'); ?>">
        <?php echo get_the_date(); ?>
    </time>

    <span class="byline author vcard"> <?php echo __('By', 'crum'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>,</span>

     <?php comments_popup_link(__('Comments', 'crum'), __('Comments', 'crum'), __('% Comments', 'crum')); ?>


</div>

