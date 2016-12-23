<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-my-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

crum_header();

if (!defined('ABSPATH')) exit; // Exit if accessed directly

?>

<?php $options = get_option('second-touch');

if ($options['stan_header']) {
    if (isset($options["stan_header_image"]) &&  ! array($options["stan_header_image"])){
        $options["stan_header_image"] = array('url' => $options["stan_header_image"]);
    }
    echo '<div id="stuning-header" style="';
    if
    ($options['stan_header_color']
    ) {
        echo ' background-color: ' . $options['stan_header_color'] . '; ';
    }

    if
    ($options['stan_header_image']['url']
    ) {
        echo 'background-image: url(' . $options['stan_header_image']['url'] . ');  background-position: center;';
    }

    echo '">';
} ?>


    <div class="row">
        <div class="twelve columns">
            <div id="page-title">
                <a href="javascript:history.back()" class="back"></a>

                <div class="page-title-inner">
                    <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
                    <div class="subtitle">
                        <?php bloginfo('description');?>
                    </div>
                    <div class="breadcrumbs">
                        <?php woocommerce_breadcrumb() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if ($options['stan_header']) {
	echo '</div>';
} ?>

<section id="layout">

    <div class="row">
        <div class="nine columns">

            <?php while (have_posts()) : the_post(); ?>

                <?php woocommerce_get_template_part('content', 'single-product'); ?>

            <?php endwhile; // end of the loop. ?>

        </div>


        <div class="three columns">
            <?php dynamic_sidebar('shop-sidebar'); ?>
        </div>


    </div>
</section>
<?php crum_footer();?>