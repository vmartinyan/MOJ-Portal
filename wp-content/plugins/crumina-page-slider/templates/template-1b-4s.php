<?php
/**
 * @package   Crumina page slider
 * @author    Liondekam <liondekam@gmail.com>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2013 Crumina Team
 */

//elements options

$cache_time = $slider['cache'];

$enable_title = $slider['enable']['title'];
$enable_icon = $slider['enable']['icon'];
$show_category = $slider['enable']['category'];
$enable_description = $slider['enable']['description'];
$enable_link = $slider['enable']['link'];
$link_type = $slider['link_type'];

$limit_words = $slider['words_limit'];
$category_bg_color = $slider ['category_background_color'];
$slide_hover_color = $slider['slide_hover_color'];
$slide_hover_opacity = $slider['opacity'];
//slideshow options

if ( isset($slider['auto_mode']) && $slider['auto_mode'] ) {
	$auto_scroll = $slider['auto_mode'];
}
if ( isset($slider['timeout']) && $slider['timeout'] ) {
	$auto_timeout = $slider['timeout'];
}

//Posts and categories

$count = 1;

$crum_loop_output = get_transient( 'crum_loopOutput_'.$slider_id );

if ( empty( $crum_loop_output ) ){

    $query = get_transient( 'crum_page_slider_cache_'.$slider_id );

    ob_start();




while ($query->have_posts()) : $query->the_post();

    $post_type = get_post_type();

    if ($count == 1) {
        echo '<li>';
    } elseif ($count % 5 == 1) {
        echo '</li><li>';
    }

    if (has_post_thumbnail()) {
        $thumb = get_post_thumbnail_id();
        $img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
        $img_url = $this->theme_thumb($img_url, 590, 401, true);
    } else {
        $img_url = $page_slider_folder .'assets/no-image/big.png';
    }

    if ( $show_category ):

            switch ( $post_type ) {
                case 'portfolio':
                    $taxonomy = 'portfolio-category';
                    break;
                case 'my-product':
                    $taxonomy = 'my-product_category';
                    break;
                case 'product':
                    $taxonomy = 'product_cat';
                    break;
                case 'post':
                    $taxonomy = 'category';
                    break;
                case 'page':
                    $taxonomy = false;
                    break;
                default:
                    $taxonomy = 'category';
            }

            $terms = get_the_terms( get_the_ID(), $taxonomy);

            if ( $terms && ! is_wp_error( $terms ) ) :

                $tax_names = array();

                foreach ( $terms as $term ) {

                    $tax_names[] = '<a href="'.get_term_link( $term->slug, $taxonomy ).'">'.$term->name.'</a>';
                }

                $tax_names = join( ", ", $tax_names );

            endif;

    endif;

    if ($enable_description) {
        $content = get_the_excerpt();
        $trimmed_content = wp_trim_words(strip_shortcodes($content), $limit_words, '');
    }
    if ($enable_icon):

        if ($post_type == 'portfolio'){

            $format_icon = 'slider-photo';

        } elseif ($post_type == 'my-product'){

            $format_icon = 'slider-photo';

        }

        elseif ($post_type == 'product') {

            $format_icon = 'slider-wallet';

        }

        elseif ($post_type == 'post'){

            $post_format = get_post_format();

            if ($post_format = 'gallery' or $post_format = 'image'){

                $format_icon = 'slider-photo';

            }

        }

        else ($format_icon = 'slider-news');

    endif;

    if ($count % 5 == 1) {
        echo '<div class="big-element item">';
        echo '<img src="' . $img_url . '" alt="">'; ?>
        <?php if ( $show_category && !(false === $taxonomy) ): ?>

            <div class="cat-name"><?php echo $tax_names;?></div>

        <?php endif; ?>

        <?php
	    $hoverbox_link_class = '';
	    if ($enable_link && ($link_type == 'on_hoverbox')):
		    $hoverbox_link_class = 'hoverbox-link';
	    endif;?>

        <div class="item-content <?php echo $hoverbox_link_class?>">


            <?php if ($enable_icon): ?>
                <span class="slider-icon-wrap"><i class="slider-icon <?php echo $format_icon ?>"></i></span>
            <?php endif; ?>


            <?php if ($enable_title): ?>
                <div class="entry-title">
                    <?php if ($enable_link && ($link_type == 'on_title')) { ?>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php
                    } elseif($enable_link && ($link_type == 'on_hoverbox')){?>
			            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php }else {
                        the_title();
                    } ?>
                </div>
            <?php endif; ?>
            <?php if ($enable_description): ?>
                <div class="text"><?php echo $trimmed_content; ?></div>
            <?php endif; ?>


        </div>

    <?php
    } else {

		$height_fix = '';

		if (has_post_thumbnail()) {
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
			$img_url = $this->theme_thumb($img_url, 292, 199);
		} else {
			$img_url = $page_slider_folder .'assets/no-image/big.png';
			$img_url = $this->theme_thumb($img_url, 292, 199);
		}

        echo '<div class="small-element item">'; ?>
        <?php if ( $show_category && !(false === $taxonomy) ): ?>

            <div class="cat-name"><?php echo $tax_names; ?></div>

        <?php endif; ?>

        <?php
        echo '<span class="entry-thumb">';
        echo '<img src="' . $img_url . '"  alt="">';



        if ($enable_link) {
            ?>
            <a href="<?php the_permalink(); ?>" class="link"> </a>
        <?php
        }
    }

    echo '</span> </div>';


    if ($count % 5 == 0) {
        echo '</li>';
    }

    $count++;
endwhile;

    wp_reset_query();

    $crum_loop_output = ob_get_contents();

    ob_end_clean();

    set_transient('crum_loopOutput_'.$slider_id, $crum_loop_output, $cache_time*60);

}

echo $crum_loop_output;