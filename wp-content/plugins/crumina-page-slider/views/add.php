<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="wrap" id="ls-slider-form">

<input type="hidden" name="posted_add" value="1">

<h2>
    <?php _e('Add New Slider', 'crumina-page-slider') ?>
    <a href="?page=crumina-page-slider" class="add-new-h2"><?php _e('Back to the list', 'crumina-page-slider') ?></a>
</h2>

<div id="ls-pages">

    <div class="ls-page ls-settings active">

        <div id="post-body-content">
            <div id="titlediv">
                <div id="titlewrap">
                    <input type="text" name="title" value="" id="title" autocomplete="off" placeholder="<?php _e('Slider name', 'crumina-page-slider') ?>">
                </div>
            </div>
        </div>

        <div class="ls-box ls-settings" id="hor-zebra">
            <table>
                <tbody>
                <thead>
                <tr>
                    <td colspan="3">
                        <h4><?php _e('Basic settings', 'crumina-page-slider') ?></h4>
                    </td>
                </tr>
                </thead>

                <!--<tr>
                    <td><?php _e('Select slider width', 'crumina-page-slider') ?></td>
                    <td>
                        <select name="slider[slider_width]">
                            <option value='full width' <?php if($slider_width == 'full width') echo 'selected'; ?>><?php _e('Full page width slider', 'crumina-page-slider') ?></option>
                            <option value='boxed' <?php if($slider_width == 'boxed') echo 'selected'; ?>><?php _e('Boxed slider', 'crumina-page-slider') ?></option>
                        </select>
                    <td class="desc"><?php _e('Select width of displayed slider. Full Page slider is recommended to be used on all pages without sidebars', 'crumina-page-slider') ?></td>
                </tr> -->

                <tr>
                    <td><?php _e('Select slider template', 'crumina-page-slider') ?></td>
                    <td>
                        <select name="slider[template]">
                            <option value='1b-4s'><?php _e('1 Big and 4 small tiles (like Second touch)', 'crumina-page-slider') ?></option>
                            <option value='1b-2s'><?php _e('1 Big and 2 small tiles (like OneTouch)', 'crumina-page-slider') ?></option>
                            <!--<option value='4s-1b'><?php _e('4 small and 1 Big tiles', 'crumina-page-slider') ?></option>
                            <option value='8s'><?php _e('8 small tiles', 'crumina-page-slider') ?></option>
                            <option value='2b'><?php _e('2 Big tiles', 'crumina-page-slider') ?></option> -->
                        </select>
                    <td class="desc"><?php _e('Select template to display post in one slide item', 'crumina-page-slider') ?></td>
                </tr>

                <tr>
                    <td><?php _e('Choose Sorting of Posts/Pages', 'crumina-page-slider') ?></td>
                    <td>
                        <select name="slider[sort]">
                            <option value='date'><?php _e('Date', 'crumina-page-slider') ?></option>
                            <option value='ID'><?php _e('Post ID', 'crumina-page-slider') ?></option>
                            <option value='name'><?php _e('Slug', 'crumina-page-slider') ?></option>
                            <option value='title'><?php _e('Title', 'crumina-page-slider') ?></option>
                            <option value='rand'><?php _e('Random', 'crumina-page-slider') ?></option>
                        </select>
                    <td class="desc"></td>
                </tr>
                <tr>
                    <td><?php _e('Choose Order of Posts/Pages', 'crumina-page-slider') ?></td>
                    <td>
                        <select name="slider[sort_order]">
                            <option value='asc'> <?php _e('Ascending', 'crumina-page-slider') ?></option>
                            <option value='desc'><?php _e('Descending', 'crumina-page-slider') ?></option>
                        </select>

                    </td>
                    <td class="desc"></td>
                </tr>

                <tr>
                    <td><?php _e('Number of Posts slides', 'crumina-page-slider') ?></td>
                    <td>
                        <select name="slider[posts]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>
                    </td>
                    <td class="desc"><?php _e('Select how many posts slides will be shown on the slider', 'crumina-page-slider') ?></td>
                </tr>

                <tr>
                    <td><?php _e('Number of slides of other post types (portfolio, products etc)', 'crumina-page-slider') ?></td>
                    <td>
                        <select name="slider[portfolios]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>
                    </td>
                    <td class="desc"><?php _e('Select how many slides of other post types (portfolio, products ... etc) will be shown on the slider', 'crumina-page-slider') ?></td>
                </tr>

                <tr>
                    <td><?php _e('Number of Pages slides', 'crumina-page-slider') ?></td>
                    <td>
                        <select name="slider[pages]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>
                    </td>
                    <td class="desc"><?php _e('Select how many pages slides will be shown on the slider', 'crumina-page-slider') ?></td>
                </tr>

                <tr>
                    <td><?php _e('Cache time', 'crumina-page-slider') ?></td>
                    <td><input type="text" name="slider[cache]" value="10" class="input"></td>
                    <td class="desc"><?php _e('Enter time in minutes to cache slider for more high performance. Set 0 to disable slider cache.', 'crumina-page-slider') ?></td>
                </tr>

                <thead>
                <tr>
                    <td colspan="3">
                        <h4><?php _e('Slider elements', 'crumina-page-slider') ?></h4>
                    </td>
                </tr>
                </thead>

                <tr>
                    <td><?php _e('Enable Post/Page title', 'crumina-page-slider') ?></td>
                    <td><input type="checkbox" name="slider[enable][title]" checked="checked"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crumina-page-slider') ?></td>
                </tr>
                <tr>
                    <td><?php _e('Enable Post type icon', 'crumina-page-slider') ?></td>
                    <td><input type="checkbox" name="slider[enable][icon]" checked="checked"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crumina-page-slider') ?></td>
                </tr>
                <tr>
                    <td><?php _e('Enable Post category', 'crumina-page-slider') ?></td>
                    <td><input type="checkbox" name="slider[enable][category]"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crumina-page-slider') ?></td>
                </tr>

                <tr>
                    <td><?php _e('Enable Post description', 'crumina-page-slider') ?></td>
                    <td><input type="checkbox" name="slider[enable][description]" checked="checked"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crumina-page-slider') ?></td>
                </tr>
                <tr>
                    <td><?php _e('Limit Description (Number of words)', 'crumina-page-slider') ?></td>
                    <td><input type="text" name="slider[words_limit]" value="30" class="input"></td>
                    <td class="desc"></td>
                </tr>
                <tr>
                    <td><?php _e('Enable link to full page', 'crumina-page-slider') ?></td>
                    <td><input type="checkbox" name="slider[enable][link]" checked="checked"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crumina-page-slider') ?></td>
                </tr>
                <tr>
	                <td><?php _e('Choose type of link to full page', 'crumina-page-slider') ?></td>
	                <td>
		                <select name="slider[link_type]">
			                <option value='on_title'><?php _e('Link on slide title', 'crumina-page-slider') ?></option>
			                <option value='on_hoverbox'><?php _e('Link on slide hover box', 'crumina-page-slider') ?></option>
		                </select>

	                </td>
	                <td class="desc"></td>
                </tr>

                <tr>
	                <td><?php _e('Delay between cycles in seconds', 'crumina-page-slider') ?></td>
	                <td><input type="text" name="slider[auto_mode]"></td>
	                <td class="desc"><?php _e('If you put delay number, slider begins scrolling automatically.', 'crumina-page-slider') ?></td>
                </tr>

                <tr>
	                <td><?php _e('Start from first slide', 'crumina-page-slider') ?></td>
	                <td><input type="checkbox" name="slider[from_first]"></td>
	                <td class="desc"><?php _e('Check this box to start slider from the first slide.', 'crumina-page-slider') ?></td>
                </tr>
                <!--
                <thead>
                <tr>
                    <td colspan="3">
                        <h4><?php _e('Slideshow options', 'crumina-page-slider') ?></h4>
                    </td>
                </tr>
                </thead>

                <tr>
	                <td><?php _e('Choose target window', 'crumina-page-slider') ?></td>
	                <td>
		                <select name="slider[target_window]">
			                <option value='_self'><?php _e('Open link in same window', 'crumina-page-slider') ?></option>
			                <option value='_blank'><?php _e('Open link in new window', 'crumina-page-slider') ?></option>
		                </select>

	                </td>
	                <td class="desc"></td>
                </tr>

                <tr>
                    <td><?php _e('Set Slider Timeout (in ms)', 'crumina-page-slider') ?></td>
                    <td><input type="text" name="slider[timeout]" value="5000" class="input"></td>
                    <td class="desc"><?php _e('Delay between cycles in milliseconds', 'crumina-page-slider') ?></td>
                </tr>
                -->

                <thead>
                <tr>
                    <td colspan="3">
                        <h4><?php _e('Select content', 'crumina-page-slider') ?></h4>
                    </td>
                </tr>
                </thead>



                    <td>
                        <?php

                        echo '<select name="slider[post_select][]" multiple="multiple" style="width: 350px;height: 150px;">';

                        $categ = array('category');

                        foreach ($categ as $cat) {

                            $args = array(
                                'orderby' => 'id',
                                'hierarchical' => 'false',
                                'taxonomy' => $cat
                            );
                            $categories = get_terms($cat, $args);

                            switch ($cat) {
                                case 'category':
                                    echo '<option value="" disabled="disabled">---------------- Posts categories ------------</option>';
                                    break;
                                case 'project_type':
                                    echo '<option value="" disabled="disabled">---------------- Portfolio categories ------------</option>';
                                    break;
                                case 'product_cat':
                                    echo '<option value="" disabled="disabled">---------------- Woocommerce categories ------------</option>';
                                    break;
                            }

                            foreach ($categories as $category) {

                                if (is_array($selected_posts) && in_array($category->slug, $selected_posts)) $selected = 'selected'; else $selected = '';

                                echo '<option value="' . $category->slug . '" ' . $selected . '>"' . $category->name . '"</option>';

                            }

                        }
                        echo '</select>';
                        ?>
                        <br class="clear"/>
                        <?php
                        $custom_posts_args = array(
                            'public'   => true,
                            '_builtin' => false
                        );

                        $output = 'names'; // names or objects, note names is the default
                        $operator = 'and'; // 'and' or 'or'

                        $custom_post_types = get_post_types( $custom_posts_args, $output, $operator );

                        $deprecated_post_types = array(
	                        "product_variation",
	                        "shop_coupon",
	                        "pricing-table",
	                        "product",
	                        "pricetable",
	                        "forum",
	                        "topic",
	                        "reply",
	                        "timeline"
                        );

                        $custom_post_type_counter = 0;

                        if (is_array($custom_post_types)) {
                            foreach ($custom_post_types as $custom_post_type) {
                                //if (!($custom_post_type == "product_variation" or $custom_post_type == "shop_coupon" or $custom_post_type == "pricing-table" or $custom_post_type == "product")) {
	                            if (!(in_array($custom_post_type,$deprecated_post_types))){
                                    $selected_custom_categories[$custom_post_type_counter] = (isset ($_POST['slider'])) ? $_POST['slider']['custom_select_' . $custom_post_type . ''] : $slider['custom_select_' . $custom_post_type . ''];


                                    $custom_taxonomy = get_object_taxonomies($custom_post_type);
                                    echo '<select name="slider[custom_select_' . $custom_post_type . '][]" multiple="multiple" style="width: 350px;height: 150px;">';
                                    echo '<option value="" disabled="disabled">---------------- ' . $custom_post_type . ' ------------</option>';

                                    foreach ($custom_taxonomy as $tax) {
                                        if (!($tax == 'product_shipping_class')) {

                                            $args = array(
                                                'orderby' => 'name',
                                                'show_count' => 0,
                                                'pad_counts' => 0,
                                                'hierarchical' => 1,
                                                'taxonomy' => $tax,
                                                'title_li' => ''
                                            );
                                            $list_categories = get_categories($args);


                                            foreach ($list_categories as $list) {
                                                if (!($list->taxonomy == "post_tag")) {
                                                    if (is_array($selected_custom_categories[$custom_post_type_counter]) && in_array($list->slug, $selected_custom_categories[$custom_post_type_counter])) $selected = 'selected'; else $selected = '';
                                                    echo '<option value="' . $list->slug . '"' . $selected . ' >"' . $list->name . '"</option>';


                                                }

                                            }


                                        }
                                    }
                                    $custom_post_type_counter++;
                                    echo '</select>';
                                    echo '<br class="clear"/>';

                                }

                            }
                        }
                        ?>

						<?php

						//woocommerce products selection

						if (class_exists('Woocommerce')){
							echo '<select name="slider[products_select][]" multiple="multiple" style="width: 350px;height: 150px;">';
							echo '<option value="" disabled="disabled">---------------- Products ------------</option>';

							$product_taxonomy = get_object_taxonomies('product','names');

							foreach($product_taxonomy as $prod_tax){
								if ($prod_tax == 'product_cat'){
									$tax_args = array(
										'orderby' => 'name',
										'show_count' => 0,
										'pad_counts' => 0,
										'hierarchical' => 1,
										'taxonomy' => $prod_tax,
										'title_li' => ''
									);
									$list_product_cat = get_categories($tax_args);

									foreach ($list_product_cat as $list_cat){
										if (is_array($selected_products) && in_array($list_cat->slug, $selected_products)) $selected = 'selected'; else $selected = '';
										echo '<option value="' . $list_cat->slug . '" ' . $selected . '>"' . $list_cat->name . '"</option>';
									}
								}
							}
							echo '</select>';
						}
						?>

                        <?php

                        echo '<select name="slider[pages_select][]" multiple="multiple" style="width: 350px;height: 150px;">';
                        echo '<option value="" disabled="disabled">---------------- Pages ------------</option>';


                        $pages = get_pages();
                        foreach ($pages as $page) {
                            if (is_array($selected_pages) && in_array($page->ID, $selected_pages)) $selected = 'selected'; else $selected = '';
                            $option = '<option value="' . $page->ID . '"  ' . $selected . '>';
                            $option .= $page->post_title;
                            $option .= '</option>';
                            echo $option;
                        }

                        echo '</select>';
                        ?>

                    </td>
                    <td class="desc"><?php _e('Selecting multiple options vary in different operating systems and browsers:
                        <br>
                        <br>
                        For windows: Hold down the control (ctrl) button to select multiple posts/pages<br>
                        For Mac: Hold down the command button to select multiple posts/pages', 'crumina-page-slider') ?>
                    </td>
					<td></td>
                </tr>

                <thead>
                <tr>
                    <td colspan="3">
                        <h4><?php _e('Select colors', 'crumina-page-slider') ?></h4>
                    </td>
                </tr>
                </thead>
                <tr>
                    <td><?php _e('Set Category and Scrollbar Color', 'crumina-page-slider'); ?></td>
                    <td><input type="text" id="category_background_color" name="slider[category_background_color]" class="input">
                        <div id="color_picker_background_color"></div>
                    </td>
                    <td class="desc"><?php _e('Select color of post category background and scrollbar', 'crumina-page-slider');?></td>
                </tr>


                <tr>
                    <td><?php _e('Set Element Background Color', 'crumina-page-slider');?></td>
                    <td><input type="text" id="background_color" name="slider[slide_hover_color]" class="input">
                        <div id="color_picker_background_color"></div>
                    </td>
                    <td class="desc"><?php _e('This option determines hover box background color only for even slides', 'crumina-page-slider');?></td>
                </tr>



                <tr>
                    <td><?php _e('Set Odd Element Background Color', 'crumina-page-slider') ?></td>
                    <td><input type="text" id="odd_background_color" name="slider[odd_slide_hover_color]"  class="input">
                        <div id="color_picker_background_color"></div>
                    </td>
                    <td class="desc"><?php _e (' This option determines hover box background color only for odd slides', 'crumina-page-slider');?></td>
                </tr>


                <tr>
                    <td><?php _e('Set Opacity (0 - 100)', 'crumina-page-slider') ?></td>
                    <td><input type="text" name="slider[opacity]" value="75" class="input"></td>
                    <td class="desc"><?php _e (' This option determines hover box opacity for all slides', 'crumina-page-slider');?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="inner">
    <button class="button-primary"><?php _e('Save changes', 'crumina-page-slider') ?></button>
    <p class="ls-saving-warning"></p>

    <div class="clear"></div>
</div>

</form>