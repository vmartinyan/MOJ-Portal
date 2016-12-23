<?php

class crum_search_widget extends WP_Widget {

	public function __construct() {

		parent::__construct(

			'crum_search_widget', // Base ID

			'Widget: Search widget', // Name

			array( 'description' => __( 'Search widget', 'crum' ), 'classname' => 'search-widget') // Args

		);
	}

	function widget( $args, $instance ) {

		//get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        }

        if ( isset( $instance[ 'text' ] ) ) {

            $text = $instance[ 'text' ];
        }

		extract( $args );


		/* show the widget content without any headers or wrappers */

        echo $before_widget;

        if ($title) {

            echo $before_title;
            echo $title;
            echo $after_title;


        } ?>

    <form role="search" method="get" class="searchform form-search" action="<?php echo home_url('/'); ?>">
        <label class="hide" for="s"><?php _e('Search for:', 'crum'); ?></label>
        <input type="text" value="" name="s" id="s1" class="s-field" placeholder="<?php echo $text; ?>">
        <input type="submit" value=" " class="s-submit searchsubmit">
    </form>

    <?php echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

		/* Strip tags (if needed) and update the widget settings. */

		$instance['text'] = strip_tags( $new_instance['text'] );


		return $instance;

	}

	function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $text = $instance['text'];

		/* Set up some default widget settings. */

		$defaults = array( 'text' => 'Enter request...' );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Placeholder', 'crum'); ?></label><br/>
      <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>"/>
    </p>

        <?php

	}

}