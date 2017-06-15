<?php global $NHP_Options;

    if (!have_posts()) : ?>

    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1><?php _e( '[:hy]Ոչինչ չի գտնվել[:en]Nothing Found[:ru]Ничего не найдено[:]', 'crum' ); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <p><?php _e( '[:hy]Ներողություն, հարցման արդյունքում ոչինչ չի գտնվել: Խնդրում ենք փորձել ևս մեկ անգամ այլ բառերով[:en]Sorry, but nothing matched your search criteria. Please try again with some different keywords.[:ru]Извините, но ничего не соответствует критериям поиска. Пожалуйста, попробуйте еще раз с другими ключевыми словами.[:]', 'crum' ); ?></p>
          <!--  <?php get_search_form(); ?>-->
        </div><!-- .entry-content -->

<!--
    <header class="entry-header">
        <h2><?php _e('Tags also can be used', 'crum'); ?></h2>
    </header><!-- .entry-header -->
<!--
    <div class="tags-widget">
        <?php wp_tag_cloud('smallest=10&largest=10&number=30'); ?>
    </div>-->

    </article><!-- #post-0 -->
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>

	<article class="hnews hentry small-news twelve columns post post-<?php the_ID(); ?> <?php echo 'format-' . $format ?>">

			<div class="ovh">
				<?php get_template_part('templates/entry-meta', 'date'); ?>
			</div>

		<div class="entry-summary">

			<p><?php the_excerpt(); ?></p>

		</div>


	</article>
<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : ?>

	<nav class="page-nav">

		<?php echo crumina_pagination(); ?>

	</nav>

<?php endif; ?>