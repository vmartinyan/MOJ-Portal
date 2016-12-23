
<?php
/*
Template Name: For page builder
*/
?>
<?php crum_header();?>
<?php $options = get_option('second-touch');?>
<section id="layout" class="no-title">


        <?php get_template_part('templates/content', 'page'); ?>

		<?php
		if ($options['page_comments_display'] == '1'){

			comments_template();
		}
		?>


</section>
<?php crum_footer();?>