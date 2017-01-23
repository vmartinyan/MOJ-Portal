
<?php
/*
Template Name: Page without sidebars
 */
crum_header();
get_template_part('templates/top','page'); ?>
<?php $options = get_option('second-touch');?>
<section id="layout">
    <div class="row">

            <section id="main-content" role="main" class="twelve columns">

                <?php get_template_part('templates/content', 'page'); ?>
			<div class="twelve columns"><?php
				if ($options['page_comments_display'] == '1'){
				comments_template();
				}
				?>
			</div>
            </section>


    </div>
</section>
<?php crum_footer();?>