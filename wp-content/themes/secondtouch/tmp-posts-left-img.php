<?php
/*
Template Name: Posts with left aligned image
*/
crum_header();
$options           = get_option( 'second-touch' );
$sharrre_blog_post = isset( $options['sharrre_blog_post'] ) ? $options['sharrre_blog_post'] : false;

get_template_part( 'templates/top', 'page' ); ?>

	<section id="layout">

		<div class="row">
			<div class="twelve rows">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div>

		<div class="row">

			<div class="blog-section sidebar-right">
				<section id="main-content" role="main" class="nine columns">

					<?php

					if ( is_front_page() ) {
						$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
					} else {
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					}

					$number_per_page = get_post_meta( $post->ID, 'blog_number_to_display', true );
					$number_per_page = ( $number_per_page ) ? $number_per_page : '12';


					$selected_custom_categories = wp_get_object_terms( $post->ID, 'category' );
					if ( ! empty( $selected_custom_categories ) ) {
						if ( ! is_wp_error( $selected_custom_categories ) ) {
							foreach ( $selected_custom_categories as $term ) {
								$blog_cut_array[] = $term->term_id;
							}
						}
					}

					$blog_custom_categories = ( get_post_meta( get_the_ID(), 'blog_sort_category', true ) ) ? $blog_cut_array : '';

					if ( $blog_custom_categories ) {
						$blog_custom_categories = implode( ",", $blog_custom_categories );
					}

					$new_args = array(
						'post_type'      => 'post',
						'posts_per_page' => $number_per_page,
						'paged'          => $paged,
						'cat'            => $blog_custom_categories
					);

					$wp_query = new WP_Query( $new_args );


					if ( ! $wp_query->have_posts() ) : ?>


						<div class="alert">
							<?php _e( 'Sorry, no results were found.', 'crum' ); ?>
						</div>
						<?php get_search_form(); ?>
					<?php endif; ?>

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

						<article <?php post_class(); ?>>

							<div class="row some-aligned-post left-thumbed">
								<div class="post-media six columns">
									<?php

									if ( has_post_format( 'video' ) ) {
										get_template_part( 'templates/post', 'video' );
									} elseif ( has_post_format( 'audio' ) ) {
										get_template_part( 'templates/post', 'audio' );
									} elseif ( has_post_format( 'gallery' ) ) {
										get_template_part( 'templates/post', 'gallery' );
									} else {

										$image_crop = $options['thumb_image_crop'];

										if ( $image_crop == '1' ) {
											$thumb_width  = $options['post_thumbnails_width'];
											$thumb_height = $options['post_thumbnails_height'];
										} else {
											$thumb_width  = 430;
											$thumb_height = 220;
										}

										if ( has_post_thumbnail() ) {
											$thumb         = get_post_thumbnail_id();
											$img_url       = wp_get_attachment_url( $thumb, 'full' ); //get img URL
											$article_image = aq_resize( $img_url, $thumb_width, $thumb_height, true );
										} else {
											$img_url       = get_template_directory_uri() . '/assets/images/no-image-blog-one.jpg';
											$article_image = aq_resize( $img_url, $thumb_width, $thumb_height, true );
										} ?>

										<div class="entry-thumb">
											<img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" />
											<a href="<?php the_permalink(); ?>" class="link"></a>
											<?php if ( comments_open() ) : ?>
												<span class="comments-link"> <?php comments_popup_link( __( 'No Comments', 'crum' ), __( '1 Comment', 'crum' ), __( '% Comments', 'crum' ) ); ?></span>
											<?php endif; ?>

											<?php if ( $sharrre_blog_post ) : ?>
												<div class="post-sharrre" data-url="<?php the_permalink(); ?>" data-media="<?php echo $img_url; ?>" data-text="<?php content( '20', true ); ?>"></div>
											<?php endif; ?>

										</div>

									<?php } ?>

								</div>
								<div class="six columns">

									<header>
										<?php get_template_part( 'templates/entry-meta', 'date' ); ?>
									</header>

									<div class="post-format">

										<?php if ( has_post_format( 'video' ) ) {
											echo '<i class="linecon-video"></i>';
										} elseif ( has_post_format( 'audio' ) ) {
											echo '<i class="linecon-sound"></i>';
										} elseif ( has_post_format( 'gallery' ) ) {
											echo '<i class="linecon-camera"></i>';
										} else {
											echo '<i class="linecon-pen"></i>';
										} ?>

									</div>
									<div class="entry-content">
										<?php content( $options['excerpt_length'] ); ?>
									</div>

								</div>
							</div>
						</article>

					<?php endwhile; ?>

					<?php if ( $wp_query->max_num_pages > 1 ) : ?>

						<nav class="page-nav">

							<?php echo crumina_pagination(); ?>

						</nav>

					<?php endif; ?>

					<?php wp_reset_query(); ?>

				</section>

				<?php get_template_part( 'templates/sidebar', 'right' ); ?>

			</div>

		</div>
	</section>
<?php crum_footer(); ?>