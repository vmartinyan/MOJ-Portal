<?php $options = get_option( 'second-touch' );

global $post;
$custom_head_img      = get_post_meta( $post->ID, 'crum_headers_bg_img', true );
$custom_head_color    = get_post_meta( $post->ID, 'crum_headers_bg_color', true );
$custom_head_subtitle = get_post_meta( $post->ID, 'crum_headers_subtitle', true );
$stun_header_show     = get_post_meta( $post->ID, 'crum_headers_hide', true );

if ( isset( $options['stan_header_show_hide'] ) && ! ( $options['stan_header_show_hide'] == '1' ) && ! ( $stun_header_show == 'on' ) ) {
	if (isset($options["stan_header_image"]) &&  ! array($options["stan_header_image"])){
		$options["stan_header_image"] = array('url' => $options["stan_header_image"]);
	}
	if ( $options['stan_header'] ) {
		echo '<div id="stuning-header" style="';
		if ( $custom_head_color && ( $custom_head_color != '#ffffff' ) && ( $custom_head_color != '#' ) ) {
			echo ' background-color: ' . $custom_head_color . '; ';
		} elseif
		( $options['stan_header_color']
		) {
			echo ' background-color: ' . $options['stan_header_color'] . '; ';
		}
		if ( $custom_head_img ) {
			echo 'background-image: url(' . $custom_head_img . ');  background-position: center;';
		} elseif
		( $options['stan_header_image']['url'] && ! ( $custom_head_color && ( $custom_head_color != '#ffffff' ) && ( $custom_head_color != '#' ) )
		) {
			echo 'background-image: url(' . $options['stan_header_image']['url'] . ');  background-position: center;';
		}

		if ( $options['stan_header_fixed'] ) {
			echo 'background-attachment: fixed; background-position:  center -10%;';
		}

		echo '">';

		if ( $options['stan_header_font_color'] ) {
			echo '<style type="text/css">';

			echo '.page-title-inner h1.page-title {color: ' . $options['stan_header_font_color'] . '}';
			echo '.page-title-inner .subtitle {color: ' . $options['stan_header_font_color'] . '}';

			echo '</style>';
		}

		$events_args = get_query_var( 'eventDisplay' );

	} ?>

	<div class="row">
		<div class="twelve columns">
			<div id="page-title">
				<div class="page-title-inner">
					<h2 class="page-title first-ico"><i class="moon-phone6"></i></h2>
					<h1 class="page-title">
						<?php if ( $custom_head_subtitle ) {
							echo $custom_head_subtitle;
						} else {
							bloginfo( 'description' );
						} ?>
					</h1>
					<?php if ( is_single() ) { ?>
						<?php echo '<div class="page-title">'; ?>
					<?php } else { ?>
						<?php echo '<h2 class="page-title">'; ?>
					<?php } ?>
					<?php
					if ( is_home() ) {
						if ( get_option( 'page_for_posts', true ) ) {
							echo get_the_title( get_option( 'page_for_posts', true ) );
						} else {
							_e( 'Latest Posts', 'crum' );
						}

					} elseif ( is_archive() ) {
						$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						if ( $term ) {
							echo $term->name;
						} elseif ( is_post_type_archive() ) {
							echo get_queried_object()->labels->name;
						} elseif ( is_day() ) {
							printf( __( 'Daily Archives: %s', 'crum' ), get_the_date() );
						} elseif ( is_month() ) {
							printf( __( 'Monthly Archives: %s', 'crum' ), get_the_date( 'F Y' ) );
						} elseif ( is_year() ) {
							printf( __( 'Yearly Archives: %s', 'crum' ), get_the_date( 'Y' ) );
						} elseif ( is_author() ) {
							global $post;
							$author_id = $post->post_author;

							$curauth        = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
							$google_profile = get_the_author_meta( 'google_profile', $curauth->ID );
							if ( $google_profile ) {
								printf( __( 'Author Archives:', 'crum' ) );
								echo '<a href="' . esc_url( $google_profile ) . '" rel="me">' . $curauth->display_name . '</a>'; ?>
							<?php
							} else {
								printf( __( 'Author Archives: %s', 'crum' ), get_the_author_meta( 'display_name', $author_id ) );
							}

						} else {
							single_cat_title();
						}
					} elseif ( is_search() ) {
						printf( __( 'Search Results for %s', 'crum' ), get_search_query() );
					} elseif ( is_404() ) {
						_e( 'File Not Found', 'crum' );
					} elseif ( function_exists( 'tribe_is_upcoming' ) && tribe_is_upcoming() ) {
						echo 'Upcoming Events';
					} elseif ( function_exists( 'tribe_is_event' ) && tribe_is_event() ) {
						the_title();
					} elseif ( is_single() && function_exists( 'tribe_is_event' ) && ! ( tribe_is_event() ) ) {
						global $post;
						$category = get_the_category( $post->ID );
						echo $category[0]->name; // first category name
					} elseif ( is_single() ) {
						global $post;
						$category = get_the_category( $post->ID );
						echo $category[0]->name; // first category name
					} else {
						the_title();
					}
					?>
					<?php if ( is_single() ) { ?>
						<?php echo '</div>'; ?>
					<?php } else { ?>
						<?php echo '</h2>'; ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php if ( $options['stan_header'] ) {
		echo '</div>';
	} else {
		?>


	<?php } ?>
	<?php do_action( 'crum_after_stan_header' ); ?>
<?php } else { ?>

	<?php if ( isset( $options['show_page_title'] ) && ! ( $options['show_page_title'] == '1' ) ) { ?>
		<div class="row">
			<div class="twelve columns">

				<?php if ( is_single() ) { ?>
					<?php echo '<div class="page-title">'; ?>
				<?php } else { ?>
					<?php echo '<h1 class="page-title">'; ?>
				<?php } ?>
				<?php
				if ( is_home() ) {
					if ( get_option( 'page_for_posts', true ) ) {
						echo get_the_title( get_option( 'page_for_posts', true ) );
					} else {
						_e( 'Latest Posts', 'crum' );
					}

				} elseif ( is_archive() ) {
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					if ( $term ) {
						echo $term->name;
					} elseif ( is_post_type_archive() ) {
						echo get_queried_object()->labels->name;
					} elseif ( is_day() ) {
						printf( __( 'Daily Archives: %s', 'crum' ), get_the_date() );
					} elseif ( is_month() ) {
						printf( __( 'Monthly Archives: %s', 'crum' ), get_the_date( 'F Y' ) );
					} elseif ( is_year() ) {
						printf( __( 'Yearly Archives: %s', 'crum' ), get_the_date( 'Y' ) );
					} elseif ( is_author() ) {
						global $post;
						$author_id = $post->post_author;

						$curauth        = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
						$google_profile = get_the_author_meta( 'google_profile', $curauth->ID );
						if ( $google_profile ) {
							printf( __( 'Author Archives:', 'crum' ) );
							echo '<a href="' . esc_url( $google_profile ) . '" rel="me">' . $curauth->display_name . '</a>'; ?>
						<?php
						} else {
							printf( __( 'Author Archives: %s', 'crum' ), get_the_author_meta( 'display_name', $author_id ) );
						}

					} else {
						single_cat_title();
					}
				} elseif ( is_search() ) {
					printf( __( 'Search Results for %s', 'crum' ), get_search_query() );
				} elseif ( is_404() ) {
					_e( 'File Not Found', 'crum' );
				} elseif ( function_exists( 'tribe_is_upcoming' ) && tribe_is_upcoming() ) {
					echo 'Upcoming Events';
				} elseif ( function_exists( 'tribe_is_event' ) && tribe_is_event() ) {
					the_title();
				} elseif ( is_single() && function_exists( 'tribe_is_event' ) && ! ( tribe_is_event() ) ) {
					global $post;
					$category = get_the_category( $post->ID );
					echo $category[0]->name; // first category name
				} elseif ( is_single() ) {
					global $post;
					$category = get_the_category( $post->ID );
					echo $category[0]->name; // first category name
				} else {
					the_title();
				}
				?>
				<?php if ( is_single() ) { ?>
					<?php echo '</div>'; ?>
				<?php } else { ?>
					<?php echo '</h1>'; ?>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
<?php } ?>