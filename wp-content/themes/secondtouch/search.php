<?php crum_header();?>
<?php get_template_part('templates/top', 'page'); ?>

<section id="layout">
    <div class="row">

        <?php
        set_layout('search');

        get_template_part('templates/content','search');

        set_layout('search', false);

        ?>

    </div>
</section>
<?php crum_footer();?>