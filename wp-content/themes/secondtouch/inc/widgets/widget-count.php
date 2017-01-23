<?php

class Counter_Mail_Subscribe extends WP_Widget {


    public function __construct() {
        parent::__construct(
            'counter_mail_subscribe', // Base ID
            'Widget: Social Counter', // Name
            array( 'description' => __( 'Subscribe to social and rss', 'crum' ), ) // Args
        );
    }

    function widget( $args, $instance ) {
        extract( $args );
        $title          = apply_filters( 'widget_title', $instance['title'] );
        $feedburner     = $instance['feedburner'];
        $label          = $instance['label'];
        $facebook_page  = $instance['facebook'] ;
        $twitter_id     = $instance['twitter'] ;
        $youtube_url    = $instance['youtube'] ;
        $new_window     = $instance['new_window'];

        if( $new_window ) $new_window =' target="_blank" ';
        else $new_window ='';

        echo $before_widget;

        if ( ! empty( $title ) )
            echo $before_title . $title . $after_title; ?>


    <div class="follow-widget">


        <?php if( $twitter_id ):
        $twitter = tie_followers_count(); ?>
        <a href="<?php echo $twitter['page_url'] ?>"<?php echo $new_window ?> class="tw">
            <i class="soc_icon-twitter"></i>

            <span class="number"><?php echo @number_format($twitter['followers_count']) ?></span> <br>
            <span class="text"><?php _e('followers' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>

        <?php if( $facebook_page ):
        $facebook = tie_facebook_fans( $facebook_page ); ?>
        <a href="<?php echo $facebook_page ?>"<?php echo $new_window ?> class="fb">
            <i class="soc_icon-facebook"></i>

            <span class="number"><?php echo @number_format( $facebook ) ?></span> <br>
            <span class="text"><?php _e('fans' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>

        <?php if( $youtube_url ):
        $youtube = tie_youtube_subs( $youtube_url ); ?>
        <a href="<?php echo $youtube_url ?>"<?php echo $new_window ?> class="yt">
            <i class="soc_icon-youtube"></i>

            <span class="number"><?php echo @number_format( $youtube ) ?></span> <br>
            <span class="text"><?php _e('subscribers' , 'crum' ) ?></span>
        </a>
        <?php endif; ?>


    </div>

    <form id="feedburner_subscribe" class="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">


        <input class="text" type="text" name="email" id="subsmail" placeholder="<?php echo $label; ?>" />
        <input type="submit" class="submit" value="" />


        <input type="hidden" value="<?php echo $feedburner; ?>" name="uri"/>
        <input type="hidden" name="loc" value="en_US"/>

    </form>

   <?php

        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['feedburner'] = strip_tags( $new_instance['feedburner'] );
        $instance['label'] = strip_tags( $new_instance['label'] );
        $instance['new_window'] = strip_tags( $new_instance['new_window'] );
        $instance['facebook'] = $new_instance['facebook'] ;
        $instance['twitter'] =  $new_instance['twitter'];
        $instance['youtube'] = $new_instance['youtube'] ;
        return $instance;
    }

    function form($instance)
    {
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('feedburner'); ?>"><?php _e('Feedburner Feed Name:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('feedburner'); ?>" name="<?php echo $this->get_field_name('feedburner'); ?>" type="text" value="<?php echo $instance['feedburner']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Textbox Label:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" type="text" value="<?php echo esc_attr($instance['label']); ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('new_window'); ?>"><?php _e('Open links in a new window', 'crum'); ?></label>
            <input id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" value="true" <?php if ($instance['new_window']) echo 'checked="checked"'; ?> type="checkbox"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook Page URL', 'crum'); ?></label>
            <input id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $instance['facebook']; ?>" class="widefat" type="text"/>
            <small>Link must be like http://www.facebook.com/username/ or http://www.facebook.com/PageID/</small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Enable Twitter', 'crum'); ?></label>
            <input id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" value="true" <?php if ($instance['twitter']) echo 'checked="checked"'; ?> type="checkbox"/>
            <small><em style="color:red;">Make sure you Setup Twitter API OAuth settings under Theme options > Twitter
                    panel </em></small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube Channel URL', 'crum'); ?></label>
            <input id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $instance['youtube']; ?>" class="widefat" type="text"/>
            <small>Link must be like http://www.youtube.com/user/username</small>
        </p>

    <?php
    }
}

add_action( 'widgets_init', create_function( '', 'register_widget("Counter_Mail_Subscribe");' ) );