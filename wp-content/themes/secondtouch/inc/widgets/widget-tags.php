<?php

class crum_tags_widget extends WP_Widget {


    public function __construct() {
        parent::__construct(
            'crum_tags_widget', // Base ID
            'Widget: Tags block', // Name
            array( 'description' => __( 'Displays tags list', 'crum' ), ) // Args
        );
    }

	function widget( $args, $instance ) {

		//get theme options

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Tags', 'roots' );

        }

        if ( isset( $instance[ 'number' ] ) ) {

            $number = $instance[ 'number' ];
        }

		extract( $args );

		/* show the widget content without any headers or wrappers */

        echo $before_widget;

        if ($title) {

            echo $before_title;
            echo $title;
            echo $after_title;

        } ?>
<div class="tags-widget clearfix">
        <?php wp_tag_cloud('smallest=10&largest=20&number='.$number); ?>
</div>

    <?php echo $after_widget;
    }

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;

	}

	function form( $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $number = $instance['number'];
		/* Set up some default widget settings. */

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','crum'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number tags:','crum'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>"/>
    </p>

        <?php

	}

}