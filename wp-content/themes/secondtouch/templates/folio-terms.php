<?php $id = get_the_ID();

$product_terms = wp_get_object_terms($id, 'my-product_category');
$count = count($product_terms); $i=0;
if (!empty($product_terms)) {
    if (!is_wp_error($product_terms)) {
        foreach ($product_terms as $term) {
            $i++;
            echo ' <a href="' . get_term_link($term->slug, 'my-product_category') . '">' . $term->name . '</a>';
            if ($count != $i) echo ',&nbsp;'; else echo'';
        }
    }
}

the_tags('<span class="delim">&nbsp;</span> <span class="tags">', ', ', '</span>');