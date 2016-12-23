<?php

/*
 * Widget random work
 */


class crum_gallery_widget extends WP_Widget {



    public function __construct() {

        parent::__construct(

            'gallery_widget', // Base ID

            'Widget: Random portfolio item', // Name

            array( 'description' => __( 'Random work from portfolio', 'crum' ), ) // Args

        );

    }



    public function form( $instance ) {

        if ( isset( $instance[ 'title' ] ) ) {

            $title = $instance[ 'title' ];

        } else {

            $title = __( 'Random work', 'gallery' );

        }

        if ( isset( $instance[ 'image_number' ] ) ) {

            $image_number = $instance[ 'image_number' ];

        } else {

            $image_number = 1;

        }
        if ( isset( $instance[ 'width' ] ) ) {

            $width = $instance[ 'width' ];

        } else {

            $width = 280;

        }
        if ( isset( $instance[ 'height' ] ) ) {

            $height = $instance[ 'height' ];

        } else {

            $height = 160;

        }

?>

    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'crum' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
     </p>

    <p>

      <label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width(px):', 'crum' ); ?></label>

      <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />

    </p>
    <p>

      <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height(px):', 'crum' ); ?></label>

      <input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" />

    </p>


    <p>

        <label for="<?php echo $this->get_field_id( 'image_number' ); ?>"><?php _e( 'Images number:', 'crum' ); ?></label>

        <input class="widefat" id="<?php echo $this->get_field_id( 'image_number' ); ?>" name="<?php echo $this->get_field_name( 'image_number' ); ?>" type="text" value="<?php echo esc_attr( $image_number ); ?>" />

    </p>

        <?php

    }



    public function update( $new_instance, $old_instance ) {

        $instance = array();

        $instance['title'] = strip_tags( $new_instance['title'] );

        $instance['image_number'] = strip_tags( $new_instance['image_number'] );

        $instance['width'] = strip_tags( $new_instance['width'] );

        $instance['height'] = strip_tags( $new_instance['height'] );

        return $instance;

    }



    public function widget( $args, $instance ) {

        extract( $args );

            $title = apply_filters( 'widget_title', $instance['title'] );

            $width = $instance['width'];

            $height = $instance['height'];

            $image_number = $instance['image_number'];

        ?>



    <?php echo $before_widget;

        if ($title) {

            echo $before_title;
            echo $title;
            echo $after_title;

        }


        $slug = 'my-product';


            $args = array(

                'post_type' => $slug,

                'posts_per_page' => $image_number,

                'orderby' => 'rand'

            );

        global $post;

            $the_query = new WP_Query($args);


            // The Loop

            while ($the_query->have_posts()) : $the_query->the_post();


                if(has_post_thumbnail()) {

                    $thumb = get_post_thumbnail_id();

                    $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL

                    $article_image = aq_resize( $img_url, $width, $height, true ); //resize & crop img ?>
                <div class="folio-item">
                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                    <span class="hover-box">
                        <a href="<?php the_permalink(); ?>" class="more-link"> </a>
                        <a href="<?php echo $img_url; ?>" class="zoom-link"> </a>
                    </span>
                    </div>
                    
                    <h4 class="box-name entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

                    <span class="dopinfo"><?php get_template_part('templates/folio', 'terms'); ?></span>

                </div>


                <?php    }

                endwhile; wp_reset_postdata(); ?>



    <?php

        echo $after_widget;

    }



}

