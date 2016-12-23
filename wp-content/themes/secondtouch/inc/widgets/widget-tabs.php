<?php
/*-----------------------------------------------------------------------------------*/
/* Tabbed Widget
/*-----------------------------------------------------------------------------------*/

class Crum_Widget_Tabs extends WP_Widget
{
    var $settings = array('number', 'pop', 'latest');


    public function __construct()
    {
        parent::__construct(
            'crum_widget_tabs', // Base ID
            'Widget: Tabbed Widget', // Name
            array('description' => __('Tabs: Popular posts, Recent Posts, Comments', 'crum'),) // Args
        );
    }

    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        $instance = $this->aq_enforce_defaults($instance);
        if(isset( $instance['title']) &&  $instance['title']){
            $title = apply_filters('widget_title', $instance['title']);
        } else {
            $title = '';
        }

        extract($instance, EXTR_SKIP);
        $header_format = $instance['header_format'];
        $thumb_sel = $instance['thumb_sel'];
        $number = $instance['number'];


        echo $before_widget;

        if ($title) {

            echo $before_title;
            echo $title;
            echo $after_title;


        } ?>

        <ul class="tabs contained horisontal">
            <?php if ($header_format == 'popular-recent'): ?>

                <li class="active"><a href="#popular-p-tab"><?php _e('Popular', 'crum') ?></a></li>
                <li><a href="#recent-p-tab"><?php _e('Recent', 'crum') ?></a></li>
                <li><a href="#comments-p-tab"><?php _e('Comments', 'crum') ?></a></li>

            <?php else : ?>

                <li class="active"><a href="#recent-p-tab"><?php _e('Recent', 'crum') ?></a></li>
                <li><a href="#popular-p-tab"><?php _e('Popular', 'crum') ?></a></li>
                <li><a href="#comments-p-tab"><?php _e('Comments', 'crum') ?></a></li>


            <?php endif; ?>
        </ul>
        <ul class="tabs-content contained folio-wrap clearfix cl">
            <li id="popular-p-tabTab" <?php echo (($header_format == 'popular-recent')) ? 'class="active"' : ''; ?>>
                <?php if (function_exists('aq_widget_tabs_popular')) aq_widget_tabs_popular($thumb_sel, $number); ?>
            </li>
            <li id="recent-p-tabTab" <?php echo (($header_format != 'popular-recent')) ? 'class="active"' : ''; ?>>
                <?php if (function_exists('aq_widget_tabs_latest')) aq_widget_tabs_latest($thumb_sel, $number); ?>
            </li>
            <li id="comments-p-tabTab">
                <?php if (function_exists('aq_widget_tabs_comments')) aq_widget_tabs_comments($number); ?>
            </li>
        </ul>

        <?php  echo $after_widget;
    }

    /*----------------------------------------
       update()
       ----------------------------------------

     * Function to update the settings from
     * the form() function.

     * Params:
     * - Array $new_instance
     * - Array $old_instance
     ----------------------------------------*/

    function update($new_instance, $old_instance)
    {
        $new_instance = $this->aq_enforce_defaults($new_instance);
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['thumb_sel'] = $new_instance['thumb_sel'];
        $instance['header_format'] = $new_instance['header_format'];
        return $new_instance;
    } // End update()

    function aq_enforce_defaults($instance)
    {
        $defaults = $this->aq_get_settings();
        $instance = wp_parse_args($instance, $defaults);
        $instance['number'] = intval($instance['number']);
        if ($instance['number'] < 1)
            $instance['number'] = $defaults['number'];


        return $instance;
    }

    /**
     * Provides an array of the settings with the setting name as the key and the default value as the value
     * This cannot be called get_settings() or it will override WP_Widget::get_settings()
     */
    function aq_get_settings()
    {
        // Set the default to a blank string
        $settings = array_fill_keys($this->settings, '');
        // Now set the more specific defaults
        $settings['number'] = 5;
        $settings['thumb_sel'] = 'thumb';
        $settings['header_format'] = 'popular-recent';
        return $settings;
    }

    /*----------------------------------------
      form()
      ----------------------------------------

       * The form on the widget control in the
       * widget administration area.

       * Make use of the get_field_id() and
       * get_field_name() function when creating
       * your form elements. This handles the confusing stuff.

       * Params:
       * - Array $instance
     ----------------------------------------*/

    function form($instance)
    {
        $instance = $this->aq_enforce_defaults($instance);
        extract($instance, EXTR_SKIP);

        $thumb_sel = $instance['thumb_sel'];
        $header_format = $instance['header_format'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:', 'crum'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('number'); ?>"
                   name="<?php echo $this->get_field_name('number'); ?>"
                   value="<?php echo esc_attr($instance['number']); ?>"/>
        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('header_format'); ?>"><?php _e('Select header format:', 'crum'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('header_format'); ?>"
                    name="<?php echo $this->get_field_name('header_format'); ?>  value="<?php echo esc_attr($header_format); ?>
            " >
            <option
                value='popular-recent' <?php if (esc_attr($header_format) == 'popular-recent') echo 'selected'; ?>><?php _e('Popular-Recent', 'crum'); ?></option>
            <option
                value='recent-popular' <?php if (esc_attr($header_format) == 'recent-popular') echo 'selected'; ?>><?php _e('Recent-Popular', 'crum'); ?></option>
            </select>

        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('thumb_sel'); ?>"><?php _e('Display date or thumb:', 'crum'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('thumb_sel'); ?>"
                    name="<?php echo $this->get_field_name('thumb_sel'); ?>  value="<?php echo esc_attr($thumb_sel); ?>"
            >
            <option  value='thumb' <?php if (esc_attr($thumb_sel) == 'thumb') echo 'selected'; ?>><?php _e('Thumbnail', 'crum'); ?></option>
            <option  value='date' <?php if (esc_attr($thumb_sel) == 'date') echo 'selected'; ?>><?php _e('Post format', 'crum'); ?></option>
            </select>

        </p>
    <?php
    } // End form()

} // End Class

/*-----------------------------------------------------------------------------------*/
/*  Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('aq_widget_tabs_popular')) {
    function aq_widget_tabs_popular($thumb_sel, $posts = 5)
    {
        global $post;
        $popular = get_posts(array('suppress_filters' => false, 'ignore_sticky_posts' => 1, 'orderby' => 'comment_count', 'numberposts' => $posts));

        foreach ($popular as $post) :
            setup_postdata($post); ?>

            <article class="hentry mini-news clearfix">
                <?php

                if ((esc_attr($thumb_sel) == 'thumb')  && has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL
                    $article_image = aq_resize($img_url, 80, 80, true);
                    ?>

                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>
                    </div>

                <?php } else {  ?>

                    <span class="icon-format"></span>

                <?php } ?>

                <div class="box-name entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                <?php get_template_part('templates/entry-meta', 'mini'); ?>

            </article>

        <?php endforeach;
        wp_reset_query();
    }
}


/*-----------------------------------------------------------------------------------*/
/*  Latest Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('aq_widget_tabs_latest')) {
    function aq_widget_tabs_latest($thumb_sel, $posts = 5)
    {
        global $post;
	    $latest = get_posts(array('suppress_filters' => false,'ignore_sticky_posts' => 1,'numberposts' => $posts,'orderby' => 'post_date', 'order' => 'desc' ));
        foreach ($latest as $post) :
            setup_postdata($post); ?>

            <article class="hentry mini-news clearfix">
                <?php

                if ((esc_attr($thumb_sel) == 'thumb')  && has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL
                    $article_image = aq_resize($img_url, 80, 80, true);
                    ?>
                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>
                    </div>

                <?php } else {  ?>

                    <span class="icon-format"></span>

                <?php } ?>

                <div class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

                <?php get_template_part('templates/entry-meta', 'mini'); ?>

            </article>

        <?php endforeach;
        wp_reset_query();
    }
}
/*-----------------------------------------------------------------------------------*/
/*  Latest Comments */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('aq_widget_tabs_comments')) {
    function aq_widget_tabs_comments($posts = 5)
    {
        global $wpdb;

        $comments = get_comments(array('number' => $posts, 'status' => 'approve'));

        if ($comments) {
            foreach ((array)$comments as $comment) {

                $post = get_post($comment->comment_post_ID);
                ?>

                <article class="hentry mini-news clearfix">

                    <span class="icon-format linecon-bubble"></span>


                    <div class="box-name">
                        <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php echo $post->post_title; ?></a>
                    </div>

                    <div class="entry-summary">
                        <p><?php echo wp_trim_words(($comment->comment_content), 10); ?></p>

                    </div>

                </article>


            <?php
            }
        }
    }

    wp_reset_query();
}

add_action( 'widgets_init', create_function( '', 'register_widget("Crum_Widget_Tabs");' ) );

