<aside class="three columns" id="left-sidebar">

    <?php


    if(is_single()){
        global $post;
        $page_id = $post->ID;
    } else {
        $page_id     = get_queried_object_id();
    }

    $selected_sidebar = get_post_meta($page_id, 'crum_sidebars_sidebar_1', true);

    if ($selected_sidebar && (function_exists('smk_sidebar'))) {

        smk_sidebar($selected_sidebar);

    } elseif (is_active_sidebar('sidebar-left')) {

        dynamic_sidebar('sidebar-left');

    } else {

        the_widget( 'Crum_Widget_Tabs');

        the_widget( 'crum_latest_tweets', 'title_cat=Categories&title_arch=Archives');

        the_widget( 'crum_gallery_widget', 'title=Random portfolio item&width=280&height=228&image_number=1');

    }
    ?>

</aside>