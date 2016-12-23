
<?php
/*
Template Name: Page with both sidebars
 */
crum_header();
$options = get_option('second-touch');
get_template_part('templates/top','page'); ?>

<section id="layout">
    <div class="row">

        <div class="blog-section sidebar-both">
            <section id="main-content" role="main" class="six columns">

                <?php get_template_part('templates/content', 'page'); ?>

            </section>

			<?php
			if ($options['page_comments_display'] == '1'){
				comments_template();
			}
			?>

            <?php get_template_part('templates/sidebar', 'left'); ?>
        </div>

        <?php  get_template_part('templates/sidebar', 'right'); ?>

    </div>
</section>
<?php crum_footer();?>