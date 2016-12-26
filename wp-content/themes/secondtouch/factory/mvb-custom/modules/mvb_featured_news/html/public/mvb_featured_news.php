<?php if ( isset( $effects ) && $effects ) {
	$cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
	$cr_effect = '';
}

if(isset($no_of_posts) && !($no_of_posts == '')){
	$post_count = $no_of_posts;
}else{
	$post_count = 1;
}

$args = array(
	'posts_per_page'      => $post_count,
	'ignore_sticky_posts' => 1,
	'post__not_in'        => $sticky,
);

if ( isset( $categories ) && ! ( $categories == '' ) ) {
	$args['category__in'] = explode( ',', $categories );
}

$featured_posts_query = new WP_Query( $args );

$unique_id = uniqid('sticky-news-');

?>


<div class="module module-sticky-news <?php echo $css ?> <?php echo $cr_effect; ?>">

	<?php if ( ! empty( $main_title ) ) { ?>
		<h3 class="widget-title">
			<?php echo $main_title ?>
		</h3>
	<?php } ?>


	<div class="crum_stiky_news">

		<div class="row">

			<div class="twelve columns blocks-label-wrap">
				<div class="blocks-label one columns ">
					<?php
					if ( $link_url ) {

						echo '<a href="' . $link_url . '">' . $link_label . '</a>';

					} else {
						echo $link_label;
					}  ?>

				</div>

				<?php
				if ( $featured_posts_query->have_posts() ) {
					?>
					<div id="<?php echo $unique_id ?>" class="eleven columns blocks-text-wrap">
						<div class="feat-news-slider">
							<?php while ( $featured_posts_query->have_posts() ) :    $featured_posts_query->the_post(); ?>

								<div class="blocks-text">
									<p>
										<a href="<?php the_permalink(); ?>"><?php echo mvb_wordwrap( get_the_excerpt(), $excerpt_length ); ?></a>
									</p>
								</div>

							<?php endwhile; ?>

						</div>
						<!--feat-news-slider-->

					</div><!--<?php echo $unique_id ?>-->

				<?php if (isset( $no_of_posts ) && ! ( $no_of_posts == '' ) && !( $no_of_posts == 1 )){ ?>

					<script type="text/javascript">

						jQuery(document).ready(function () {
							jQuery('#<?php echo $unique_id ?>').flexslider({
								selector    : ".feat-news-slider > .blocks-text",
								namespace   : "feat-news-",
								animation   : "slide",
								slideshow   : true,
								direction   : "horizontal",
								controlNav  : false,
								directionNav: false,
								itemWidth: 800,
								maxItems:1
							});
						});

					</script>

				<?php
				}

					wp_reset_query();
				}
				?>

			</div>
			<!--twelve columns-->

		</div>
	</div>
</div>