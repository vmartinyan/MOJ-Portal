<?php
class Crum_News_Cat extends WP_Widget
{


    function __construct()
    {
        parent::__construct(
            'crum_news_cat',
            __('Widget: Posts', 'crum'), // Name
            array('description' => __('Posts from some category', 'crum'),
            )
        );
    }

    function widget($args, $instance)
    {

        extract($args);

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Latest articles', 'crum');
        }

        if ( isset($instance['number']) ) {
			$number = $instance['number'];
		}
        if ( isset($instance['post_order']) ) {
			$post_order = $instance['post_order'];
		}
        if ( isset($instance['post_order_by']) ) {
			$post_order_by = $instance['post_order_by'];
		}else{
			$post_order_by= 'none';
		}
        if ( isset($instance['cat_sel']) ) {
			$cat_selected = $instance['cat_sel'];
		}


        echo $before_widget;

        if ($title) {
            echo $before_title;
            echo $title;
            echo $after_title;
        }

        $args = array(
            'cat' => $cat_selected,
            'posts_per_page' => $number,
            'suppress_filters' => false,
            'ignore_sticky_posts' => 'true',
            'orderby' => $post_order_by,
            'order' => $post_order
        );

        $the_query = new WP_Query($args);

        while ($the_query->have_posts()) : $the_query->the_post(); ?>

            <article class="hnews hentry featured-news vertical">

                <?php

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'medium'); //get img URL
                    $article_image = aq_resize($img_url, 380, 270, true);
                    ?>


                    <div class="entry-thumb ">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>

                        <?php comments_popup_link(__('0 Comments', 'crum'), __('1 Comment', 'crum'), __('% Comments', 'crum'), 'comments-link', ''); ?>

                    </div>

                <?php
                }


                get_template_part('templates/entry-meta', 'date'); ?>

                <div class="entry-summary">

                    <p><?php content(25) ?></p>

                </div>

            </article>

        <?php  endwhile;
        wp_reset_postdata();

        echo $after_widget;

    }

    function update($new_instance, $old_instance)
    {

        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);

        $instance['number'] = $new_instance['number'];

        $instance['post_order'] = $new_instance['post_order'];

        $instance['cat_sel'] = $new_instance['cat_sel'];

		$instance['post_order_by'] = $new_instance['post_order_by'];

        return $instance;

    }

    function form($instance)
    {

        $title = apply_filters('widget_title', $instance['title']);

        $cat_selected = $instance['cat_sel'];

        $number = $instance['number'];

        $post_order = $instance['post_order'];

        $post_order_by = $instance['post_order_by'];

        ?>


        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'crum'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts', 'crum'); ?>:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>"/>
        </p>



        <p>
            <label for="<?php echo $this->get_field_id('cat_sel'); ?>"><?php _e('Select category', 'crum'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('cat_sel'); ?>" name="<?php echo $this->get_field_name('cat_sel'); ?>">


                <option class="widefat" value=""><?php _e('All', 'crum'); ?></option>

                <?php
                $cats = get_categories();

                foreach ($cats as $cat) {

                    $cat_sel = (isset($cat_selected) && $cat_selected  && ($cat_selected == $cat->term_id)) ? ' selected="selected"' : '';
                    echo '<option class="widefat" value="' . $cat->term_id . '"' . $cat_sel . '>' . $cat->name . '</option>';
                }?>

            </select>

        </p>

        <p>
            <label for="<?php echo $this->get_field_id('post_order'); ?>"><?php _e('Order posts', 'crum'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('post_order'); ?>" name="<?php echo $this->get_field_name('post_order'); ?>">

                <option class="widefat" <?php if (esc_attr($post_order) == 'DESC') echo 'selected'; ?> value="DESC"><?php _e('Descending', 'crum'); ?></option>
                <option class="widefat" <?php if (esc_attr($post_order) == 'ASC') echo 'selected'; ?> value="ASC"><?php _e('Ascending', 'crum'); ?></option>

            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_order_by'); ?>"><?php _e('Order posts by', 'crum'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('post_order_by'); ?>" name="<?php echo $this->get_field_name('post_order_by'); ?>">

                <option class="widefat" value="none" <?php if (esc_attr($post_order_by) == 'none') echo 'selected'; ?>><?php _e('No order', 'crum'); ?></option>
                <option class="widefat" value="ID" <?php if (esc_attr($post_order_by) == 'ID') echo 'selected'; ?>><?php _e('Order by post id', 'crum'); ?></option>
                <option class="widefat" value="title" <?php if (esc_attr($post_order_by) == 'title') echo 'selected'; ?>><?php _e('Order by title', 'crum'); ?></option>
                <option class="widefat" value="name" <?php if (esc_attr($post_order_by) == 'name') echo 'selected'; ?>><?php _e('Order by post name (post slug)', 'crum'); ?></option>
                <option class="widefat" value="date" <?php if (esc_attr($post_order_by) == 'date') echo 'selected'; ?>><?php _e('Order by date', 'crum'); ?></option>
                <option class="widefat" value="modified" <?php if (esc_attr($post_order_by) == 'modified') echo 'selected'; ?>><?php _e('Order by last modified date', 'crum'); ?></option>
                <option class="widefat" value="rand" <?php if (esc_attr($post_order_by) == 'rand') echo 'selected'; ?>><?php _e('Random order', 'crum'); ?></option>
                <option class="widefat" value="comment_count" <?php if (esc_attr($post_order_by) == 'comment_count') echo 'selected'; ?>><?php _e('Order by number of comments', 'crum'); ?></option>

            </select>

        </p>

    <?php

    }

}

add_action('widgets_init', create_function('', 'register_widget("Crum_News_Cat");'));