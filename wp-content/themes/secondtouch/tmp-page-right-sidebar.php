
<?php
/*
Template Name: Page with right sidebar
 */
crum_header();
get_template_part('templates/top','page'); ?>
<?php $options = get_option('second-touch');?>
<section id="layout">
    <div class="row">

        <div class="blog-section sidebar-right">
            <section id="main-content" role="main" class="nine columns">

                <?php get_template_part('templates/content', 'page'); ?>
				<div class="twelve columns"><?php
				if ($options['page_comments_display'] == '1'){
				comments_template();
				}
				?>
			    </div>
            </section>
		
            <?php get_template_part('templates/sidebar', 'right'); ?>
        </div>

    </div>
</section>
<?php crum_footer();?>