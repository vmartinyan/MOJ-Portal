<?php
/*
 * Instagram widget by Crumina
 */

if ( ! ( class_exists( 'Crumina_Instagram_Widget' ) ) ) {

	class Crumina_Instagram_Widget extends WP_Widget {
		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$widget_ops = array(
				'classname'   => 'widget_instagram shadow white-bg widget-radius',
				'description' => __( "Instagram feed", 'crum' )
			);
			parent::__construct( 'crumina-instagramm-widget', __( 'Crumina: Instagram Feed', 'crum' ), $widget_ops );
			$this->alt_option_name = 'widget_crum_instagram';
		}


		//widget output
		public function widget( $args, $instance ) {
			extract( $args );

			echo $args['before_widget'];


			$title = '';

			if ( isset( $instance['title'] ) ) {
				$title = $instance['title'];

			}

			if ( $title ) {

				echo $args['before_title'];
				echo $title;
				echo $args['after_title'];

			}


			//check settings and die if not set
			if ( empty( $instance['cache_time'] ) || empty( $instance['user_name'] ) ) {
				_e( 'Please fill all widget settings!', 'crum' );

				echo $args['after_widget'];

				return;
			}

			$username = empty( $instance['user_name'] ) ? '' : $instance['user_name'];
			$limit    = 5;
			$cache    = empty( $instance['cache_time'] ) ? 1 : $instance['cache_time'];

			if ( $username != '' ) {

				$media_array = $this->scrape_instagram( $username, $cache );

				if ( is_wp_error( $media_array ) ) {

					echo $media_array->get_error_message();

				} else {
					$user = $media_array['user'];

					?>

					<div class="intagram-gallery">

						<?php
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );

						$i = 0;

						foreach ( $media_array as $item ) {
							if ( $i < $limit ) {
								if ($i == 0) {
									echo '<span class="big-item"><a class="zoom-link" href="' . esc_url( $item['link'] ) . '" ><img src="' . esc_url( $item['link'] ) . '" alt="" /></a></span>';
								 } else {
									echo '<span class="normal-item"><a class="zoom-link" href="' . esc_url( $item['link'] ) . '" ><img src="' . esc_url( $item['link'] ) . '" alt="" /></a></span>';
								}
								$i ++;
							}
						}

						$follow_url = 'https://instagram.com/' . $username;

						?>

					</div>
					<div class="instagram-autor">

					<div class="instagram-stat">
						<div class="inst-photos">
							<span class="numb"><?php echo crum_thousands_convert($user['media']['count']); ?></span>
							<div class="diopinfo"><?php _e( 'items', 'crum' ); ?></div>
						</div>
						<div class="inst-follower">
							<span class="numb"><?php echo crum_thousands_convert($user['followed_by']['count']); ?></span>
							<div class="diopinfo"><?php _e( 'followers', 'crum' ); ?></div>
						</div>
						<div class="inst-follow">
							<span class="numb"><?php echo crum_thousands_convert($user['follows']['count']); ?></span>
							<div class="diopinfo"><?php _e( 'follow', 'crum' ); ?></div>
						</div>
					</div>
					<img class="avatar" src="<?php echo esc_url($user['profile_pic_url']); ?>" alt="avatar">

					<div class="box-name entry-title"><?php echo ($user['full_name']); ?></div>
					<div class="diopinfo"><?php echo '<a class=""  href="'.esc_url($follow_url).'" >@' . __( 'follow', 'crum' ) . ' ' . $username . '</a>'; ?></div>

				<?php
				}
			}


			echo $args['after_widget'];
		}


		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']             = $new_instance['title'];
			$instance['user_name']         = $new_instance['user_name'];
			$instance['cache_time']        = ! absint( $new_instance['cache_time'] ) ? 1 : $new_instance['cache_time'];

			delete_transient( 'instagram-media-' . sanitize_title_with_dashes( $new_instance['user_name'] ) );

			return $instance;
		}

		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
				'title'    => __( 'Instagram', 'crum' ),
				'user_name' => '',
				'cache_time'     => 1,
			) );

			$title             = $instance['title'];
			$user_name         = $instance['user_name'];
			$cache_time        = $instance['cache_time'];

			$widget_output = '';

			//Widget title
			$widget_output .= '<p>';
			$widget_output .= '<label for="' . esc_attr($this->get_field_id( 'title' )) . '">' . __( 'Title:', 'crum' ) . '</label>';
			$widget_output .= '<input class="widefat" id="' . esc_attr($this->get_field_id( 'title' )) . '" name="' . esc_attr($this->get_field_name( 'title' )) . '" type="text" value="' . esc_attr($title) . '">';
			$widget_output .= '</p>';

			//Client name
			$widget_output .= '<p>';
			$widget_output .= '<label for="' . esc_attr($this->get_field_id( 'user_name' )) . '">' . __( 'Username:', 'crum' ) . '</label>';
			$widget_output .= '<input class="widefat" id="' . esc_attr($this->get_field_id( 'user_name' ) ). '" name="' . esc_attr($this->get_field_name( 'user_name' )) . '" type="text" value="' . esc_attr($user_name) . '">';
			$widget_output .= '</p>';
						//Cache time
			$widget_output .= '<p>';
			$widget_output .= '<label for="' . esc_attr($this->get_field_id( 'cache_time' )) . '">' . __( 'Cache time (hours)', 'crum' ) . '</label>';
			$widget_output .= '<input class="widefat" id="' . esc_attr($this->get_field_id( 'cache_time' )) . '" name="' . esc_attr($this->get_field_name( 'cache_time' )) . '" type="text" value="' . esc_attr($cache_time) . '">';
			$widget_output .= '</p>';


			echo $widget_output;
		}


		// based on https://gist.github.com/cosmocatalano/4544576
		function scrape_instagram( $username, $cache ) {

			$username = strtolower( $username );

			if ( false === ( $instagram = get_transient( 'instagram-media-' . sanitize_title_with_dashes( $username ) ) ) ) {

				$remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'crum' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'crum' ) );
				}

				$shards      = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json  = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], true );

				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'crum' ) );
				}

				$instagram = array();

				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];

				if ( is_array( $images ) ) {
					foreach ( $images as $image ) {

						$instagram_link = array(
							'link' => $image['display_src'],
						);
						if ( $image['is_video'] == false ) {
							$instagram_type = array(
								'type' => 'image'
							);
						} else {
							$instagram_type = array(
								'type' => 'video'
							);
						}
						$instagram[] = array_merge( $instagram_link, $instagram_type );

					}
				}

				$user = $insta_array['entry_data']['ProfilePage'][0]['user'];

				$instagram['user'] = $user;

				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'instagram-media-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', ( $cache * 3600 ) * 2 ) );
			}

			$instagram = unserialize( base64_decode( $instagram ) );

			return $instagram;
		}

		function images_only( $media_item ) {

			if ( isset($media_item['type']) && ($media_item['type'] == 'image') ) {
				return true;
			}

			return false;
		}
	}
}

if ( class_exists( 'Crumina_Instagram_Widget' ) ) {

	function crum_register_instagram_widget() {
		register_widget( 'Crumina_Instagram_Widget' );
	}

	add_action( 'widgets_init', 'crum_register_instagram_widget' );

}