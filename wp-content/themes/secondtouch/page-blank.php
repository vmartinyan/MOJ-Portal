<?php
/*
Template Name: Page without header and footer
*/
?>

<?php $options = get_option( 'second-touch' );?>

<?php get_header();?>

<body <?php body_class( '' ); ?> >


<div id="change_wrap_div" class="  <?php if ( $options["site_boxed"] ) {
	echo ' boxed_lay';
} ?>">

	<section id="layout" class="no-title">

		<div class="row">

			<?php get_template_part( 'templates/content', 'page' ); ?>

			<?php
			if ( $options['page_comments_display'] == '1' ) {

				comments_template();
			}
			?>
		</div>

	</section>
</div>

<?php wp_footer(); ?>

</body>
</html>
