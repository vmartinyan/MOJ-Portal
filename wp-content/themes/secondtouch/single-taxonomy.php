<?php crum_header();?>
<?php get_template_part('templates/top','page'); ?>

<section id="layout">
    <div class="row">

        <?php
        set_layout('pages');

        get_template_part('templates/content', 'page');

        set_layout('pages', false);

        ?>

    </div>
</section>
<?php crum_footer();?>