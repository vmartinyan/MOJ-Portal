
<time datetime="<?php echo get_the_time('c'); ?>" class="date updated">
    <span class="day"><?php echo get_the_date('d'); ?></span>
    <span class="month"><?php echo get_the_date('M Y'); ?></span>
</time>

<div class="ovh">

    <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

    <div class="entry-meta dopinfo">

        <span class="byline author vcard"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></span>

        <?php
        $post_tags = wp_get_post_tags($post->ID);
		$post_categories = wp_get_post_terms($post->ID,'category',array("fields" => "names"));
        if (!empty($post_tags)) { ?>

            <span class="delim"> </span>
            <span class="post-tags"> <?php echo __(' ', 'crum') . ' ';
                the_tags('', ', ', ''); ?></span>

        <?php }
		if (!empty($post_categories)){ ?>

			<span class="delim"> </span>
			<span class="post-tags"> <?php echo __(' ', 'crum') . ' ';
				the_category('', ', ', ''); ?></span>

		<?php }	?>


    </div>
</div>
