<?php 
$sb_footer_14       = apply_filters('nictitate_lite_get_sidebar', 'sidebar_14', 'pos_sidebar_14');
?>
<div id="main-content">

    <?php get_template_part( 'templates/content/content', 'page-title' ); ?>

    <div class="wrapper container">

        <div class="row-fluid">

            <div class="span12">

                <div id="main-col">

                    <ul class="kopa-article-list">

                        <?php get_template_part( 'templates/content/contents' ); ?>

                    </ul><!--kopa-article-list-->

                    <?php get_template_part( 'templates/pagination' ); ?>

                </div><!--main-col-->

                <div class="sidebar">

                    <?php if ( is_active_sidebar($sb_footer_14) )
                        dynamic_sidebar($sb_footer_14);
                    ?>

                </div><!--sidebar-->

                <div class="clear"></div>

            </div><!--span12-->

        </div><!--row-fluid-->

    </div><!--wrapper-->
    
</div> <!-- #main-content -->