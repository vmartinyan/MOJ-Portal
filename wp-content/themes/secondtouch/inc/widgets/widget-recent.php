<?php

class crum_recent_posts extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'crum_recent_posts', // Base ID
            'Widget: Recent Posts', // Name
            array( 'description' => __( 'Advanced recent posts widget.', 'crum' ), ) // Args
        );
    }


    /**
     * Display widget
     */
    function widget( $args, $instance ) {
        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        $limit = $instance['limit'];
        $excerpt = $instance['excerpt'];
        $length = (int)( $instance['length'] );
        $thumb = $instance['thumb'];
        $cat = $instance['cat'];
        $date = $instance['date'];


        echo $before_widget;

        if ( ! empty( $title ) )
            echo $before_title . $title . $after_title;

        global $post;

        if ( false === (( $crumwidget = get_transient( 'crumwidget_' . $widget_id ) ) && ( $crumwidget_sticky = get_transient( 'crumwidget_sticky' . $widget_id ) )) ) {

            $args = array(
                'numberposts' => $limit,
                'cat' => $cat,
                'suppress_filters' => false,
                'offset' => '1',
                'post__not_in' => get_option( 'sticky_posts' )
            );
            $args2 = array(
                'numberposts' => 1,
                'suppress_filters' => false,
                'cat' => $cat,
                'post__in' => get_option( 'sticky_posts' )
            );

            $crumwidget = get_posts( $args );
            $crumwidget_sticky = get_posts( $args2 );


            set_transient( 'crumwidget_' . $widget_id, $crumwidget, 60*2*0 );
            set_transient( 'crumwidget_sticky_' . $widget_id, $crumwidget_sticky, 60*2*0 );

        } ?>

        <ul class="recent-posts-list">

            <?php foreach( $crumwidget_sticky as $post ) :	setup_postdata( $post ); ?>

                <li class="clearfix sticky-post">

                    <?php if( has_post_thumbnail() && $thumb == true ) {
                        $thumb_img = get_post_thumbnail_id();
                        $img_url = wp_get_attachment_url($thumb_img, 'thumb'); //get img URL
                        $article_image = aq_resize($img_url, 80, 80, true);
                        ?>
                        <div class="entry-thumb">
                            <a href="<?php the_permalink() ;?>" class="more">
                                <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                            </a>
                        </div>

                    <?php } ?>

                    <h3 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'crum' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h3>

                    <?php if( $date == true ) {
                        get_template_part('templates/entry-meta-mini');
                    } ?>

                    <?php if( $excerpt == true ) {  ?>
                        <div class="entry-summary"> <?php echo wp_trim_words( get_the_excerpt() , $num_words = $length, $more = null ); ?> </div>
                    <?php } ?>

                </li>

            <?php endforeach; wp_reset_postdata(); ?>


            <?php foreach( $crumwidget as $post ) :	setup_postdata( $post ); ?>

            <li class="clearfix">

                <?php if( has_post_thumbnail() && $thumb == true ) {
                    $thumb_img = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb_img, 'thumb'); //get img URL
                    $article_image = aq_resize($img_url, 60, 60, true);
                    ?>
                    <div class="entry-thumb">
                        <a href="<?php the_permalink() ;?>" class="more">
                            <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        </a>
                    </div>

                <?php } ?>

                <h3 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'crum' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                </h3>

                <?php if( $date == true ) {
                    get_template_part('templates/entry-meta-mini');
                } ?>

            </li>

            <?php endforeach; wp_reset_postdata(); ?>

        </ul>

    <?php

        echo $after_widget;

    }

    /**
     * Update widget
     */
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = esc_attr( $new_instance['title'] );
        $instance['limit'] = $new_instance['limit'];
        $instance['excerpt'] = $new_instance['excerpt'];
        $instance['length'] = (int)( $new_instance['length'] );
        $instance['thumb'] = $new_instance['thumb'];
        $instance['cat'] = $new_instance['cat'];
        $instance['date'] = $new_instance['date'];

        delete_transient( 'crumwidget_' . $this->id );

        return $instance;

    }

    /**
     * Widget setting
     */
    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array(
            'title' => '',
            'limit' => 5,
            'excerpt' => '',
            'length' => 10,
            'thumb' => true,
            'cat' => '',
            'date' => true,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = esc_attr( $instance['title'] );
        $limit = $instance['limit'];
        $excerpt = $instance['excerpt'];
        $length = (int)($instance['length']);
        $thumb = $instance['thumb'];
        $cat = $instance['cat'];
        $date = $instance['date'];

        ?>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'crum' ); ?></label>
        <select class="widefat" name="<?php echo $this->get_field_name( 'limit' ); ?>" id="<?php echo $this->get_field_id( 'limit' ); ?>">
            <?php for ( $i=1; $i<=20; $i++ ) { ?>
            <option <?php selected( $limit, $i ) ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>
    </p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php _e( 'Display date?', 'crum' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?> />&nbsp;
    </p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"><?php _e( 'Display excerpt?', 'crum' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" type="checkbox" value="1" <?php checked( '1', $excerpt ); ?> />&nbsp;
    </p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>"><?php _e( 'Excerpt length:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="text" value="<?php echo $length; ?>" />
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>"><?php _e( 'Display thumbnail?', 'crum' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" type="checkbox" value="1" <?php checked( '1', $thumb ); ?> />&nbsp;
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php _e( 'Limit to category: ' , 'crum' ); ?></label>
        <?php wp_dropdown_categories( array( 'name' => $this->get_field_name( 'cat' ), 'show_option_all' => __( 'All categories' , 'crum' ), 'hide_empty' => 1, 'hierarchical' => 1, 'selected' => $cat ) ); ?>
    </p>

    <?php
    }

}
