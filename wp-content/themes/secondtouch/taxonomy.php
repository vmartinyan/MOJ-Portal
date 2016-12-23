<?php crum_header();?>
<?php get_template_part('templates/top','page'); ?>

<section id="layout">
    <div class="row">

<?php global $NHP_Options;

    if (!have_posts()) : ?>

        <div class="alert">
            <?php _e('Sorry, no results were found.', 'crum'); ?>
        </div>
        <?php get_search_form(); ?>
        <?php endif; ?>

<?php while (have_posts()) : the_post();

        get_template_part('templates/portfolio', 'item');

      endwhile;

if ($wp_query->max_num_pages > 1) : ?>

        <nav class="page-nav">

            <?php echo crumina_pagination(); ?>

        </nav>

        <?php endif; ?>

    </div>
</section>
<?php crum_footer();?>