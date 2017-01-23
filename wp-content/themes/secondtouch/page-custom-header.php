<?php
/*
Template Name: For page builder with header
*/
?>
<?php
crum_header();

get_template_part('templates/top', 'page'); ?>
<?php $options = get_option('second-touch');?>
<section id="layout" class="no-title">


        <?php get_template_part('templates/content', 'page'); ?>
			

</section>

<?php crum_footer();?>