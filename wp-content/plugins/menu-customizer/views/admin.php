<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Menu_Cusomizer
 * @author    Liondekam <info@crumina.net>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>


    <?php
    function construct()
    {
        $function = (isset($_POST["func"])) ? $_POST["func"] : '';

        switch ($function):

            case 'save_menu_settings':
                $menu_data = $_POST['menu_data'];

                save_menu_settings($menu_data);
                break;

            default:

                break;

        endswitch;

    }


    function save_menu_settings($menu_data)
    {
        $menu_saved_data = get_menu_settings();
        $menu_slug_name = key($menu_data);

        if (isset($menu_saved_data[$menu_slug_name])) {
            $menu_saved_data[$menu_slug_name] = $menu_data[$menu_slug_name];
            $menu_data = $menu_saved_data;
        } else {
            if (is_array($menu_saved_data)) {
                $menu_data = array_merge($menu_saved_data, $menu_data);
            }
        }

        update_option('crumina_menu_data', $menu_data);
    }

    function get_menu_settings()
    {
        return get_option('crumina_menu_data');
    }

    function get_menu_slug()
    {
        if (isset($_POST['menu_slug_name'])) {
            $menu_slug_name = $_POST['menu_slug_name'];
        } else {
            $locations = array();
            $locations = wp_get_nav_menus();

            if (count($locations) > 0) {
                $menu_slug_name = $locations[0]->slug;
            }
        }

        return $menu_slug_name;
    }


    function get_main_menu_selectbox($slug_menu)
    {
        echo __('Select menu:', 'menu-customizer') . '<br>';
        echo '<select id="menu-list" name="menu_slug_name">';

        $menus = get_terms('nav_menu');

        foreach ($menus as $menu) {
            if ($menu->slug == $slug_menu) $selected = ' selected = "selected" '; else $selected = '';
            echo '<option value="' . $menu->slug . '" ' . $selected . '  >' . $menu->name . '</option>';

        }
        echo '</select>';
    }

    function show_crum_menus_items_list($slug_menu)
    {
        if (empty($slug_menu)) $slug_menu = 'primary-navigation';

        $menu_items = wp_get_nav_menu_items($slug_menu);
        $menu_settings = get_menu_settings();

		$menu_settings[$slug_menu]['item_size'] = (isset($menu_settings[$slug_menu]['item_size'])) ? $menu_settings[$slug_menu]['item_size'] : '';
		$menu_settings[$slug_menu]['dropdown_style'] = (isset($menu_settings[$slug_menu]['dropdown_style'])) ? $menu_settings[$slug_menu]['dropdown_style'] : '';

		if ($menu_settings){
            $item_size = $menu_settings[$slug_menu]['item_size'];
            $dropdown_style = $menu_settings[$slug_menu]['dropdown_style'];
        }

        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='func' value='save_menu_settings'>";

        ?>

        <div style="width: 150px; margin:30px 0;">

            <?php  get_main_menu_selectbox($slug_menu); ?>

        </div>

        <h3> <?php _e('Additional options','menu-customizer') ?></h3>

        <div>
            <label><?php _e('Menu items size (in px)','menu-customizer') ?>:</label> <br>
            <?php echo '<input type="text" class="metro-item-size"  value="' . $item_size . '" name="menu_data[' . $slug_menu . '][item_size]"  />'; ?>

            <label><?php _e('Style of dropdown items','menu-customizer') ?>:</label>

            <select id="dropdown_style" name="<?php echo 'menu_data[' . $slug_menu . '][dropdown_style]'; ?>">
                <option <?php if ($dropdown_style == 'classic'){ echo   'selected = "selected"';} ?>  value="classic">Clasic (default)</option>
                <option <?php if ($dropdown_style == 'metro'){ echo   'selected = "selected"';} ?>  value="metro">Metro style</option>

            </select>

        </div>

        <?php

        echo '<ul>';

        foreach ($menu_items as $menu_item) {
            if ($menu_item->menu_item_parent == 0) {

                $menu_id = $menu_item->ID;

                $menu_font_color = '';
	            $menu_bg_color = '';
	            $menu_bg_inherit = '';
                $menu_bg_image ='';
                $menu_icon = '';

                if ($menu_settings){
                    $menu_font_color = (isset($menu_settings[$slug_menu][$menu_id]['font_color'])) ? $menu_settings[$slug_menu][$menu_id]['font_color'] : '';
	                $menu_bg_color = (isset($menu_settings[$slug_menu][$menu_id]['bg_color'])) ? $menu_settings[$slug_menu][$menu_id]['bg_color'] : '';
	                $menu_bg_inherit = (isset($menu_settings[$slug_menu][$menu_id]['bg_color_inherit'])) ? $menu_settings[$slug_menu][$menu_id]['bg_color_inherit'] : 'do_not_inherit';
                    $menu_bg_image = (isset($menu_settings[$slug_menu][$menu_id]['bg_image'])) ? $menu_settings[$slug_menu][$menu_id]['bg_image'] : '';
                    $menu_icon = (isset($menu_settings[$slug_menu][$menu_id]['icon'])) ? $menu_settings[$slug_menu][$menu_id]['icon'] : '';
                }



                $tile_styles = '';
	            $item_tile_styles = '';

	            if($menu_font_color){
		            $item_tile_styles .= 'style="color:'.$menu_font_color.'"';
	            }

                if($menu_bg_color) {
                    $tile_styles .= ' background-color:'.$menu_bg_color.';';
                }
                if($menu_bg_image) {
                    $tile_styles .= ' background-image: url('.$menu_bg_image.');';
                }

                echo '<li class="metro-menu-item">
                    <a href="#">
                    <span class="menu-tile" style="'.$tile_styles.'"><i class="tile-icon '.$menu_icon.' "></i></span>
                    <span class="item-title">'.$menu_item->title.'<span>
                    </a>';

                echo '<div class="metro-menu-settings">';

		            echo '<label>' . __( 'Font color', 'menu-customizer' ) . ':</label>
	                    <input type="text" value="' . $menu_font_color . '" class="metro-item-color" name="menu_data[' . $slug_menu . '][' . $menu_id . '][font_color]" />';
		            echo '<p> </p>';


                echo '<label>'. __('Background color', 'menu-customizer') .':</label>
                    <input type="text" value="' . $menu_bg_color . '" class="metro-item-color" name="menu_data[' . $slug_menu . '][' . $menu_id . '][bg_color]" />';
                echo '<p> </p>';

	            echo '<label>'. __('Inherit bg color', 'menu-customizer') .':</label>';?>
                    <select name="menu_data[<?php echo $slug_menu;?>][<?php echo $menu_id;?>][bg_color_inherit]">';

		            <option value="do_not_inherit" <?php if ($menu_bg_inherit == 'do_not_inherit'){echo 'selected="selected"';}?>><?php  _e( 'Do not inherit', 'menu-customizer' ); ?></option>
		            <option value="inherit" <?php if ($menu_bg_inherit == 'inherit'){echo 'selected="selected"';}?>><?php  _e( 'Inherit', 'menu-customizer' ) ?></option>

                    </select>
                    <?php echo '<p> </p>';

                echo '<label>'. __('Background image', 'menu-customizer') .':</label>
                    <input type="text" class="metro-item-image"  value="' . $menu_bg_image . '" name="menu_data[' . $slug_menu . '][' . $menu_id . '][bg_image]"  />
                    <a href="#" class="add-item-image button" title="' . __('Add image', 'menu-customizer') . '">' . __('Add', 'menu-customizer') . '</a>
                    <a href="#" class="remove-item-image button" title="' . __('Remove image', 'menu-customizer') . '">' . __('Remove', 'menu-customizer') . '</a>';
                echo '<p> </p>';

                echo '<label>'. __('Menu icon', 'menu-customizer') .':</label>
                    <input type="text" class="metro-item-icon iconname" value="'.$menu_icon.'"  name="menu_data[' . $slug_menu . '][' . $menu_id . '][icon]"   />
                    <a href="#" class="button crum-icon-add" title="'.__('Add Icon','menu-customizer').'">'.__('Add','menu-customizer').'</a>
                    <a href="#" class="button crum-icon-remove" title="' . __('Remove Icon', 'menu-customizer') . '">' . __('Remove', 'menu-customizer') . '</a>';

                echo '</div></li>';
            }
        }
        echo '</ul>';

        echo '<div class="clear"></div> ';
        echo '<br><br><input class="button-primary" style="float:none;" type="submit" id="save_menu" value="Save">';
        echo "</form>";
    }


    $menu_slug_name = get_menu_slug();

    construct();

    show_crum_menus_items_list($menu_slug_name);


?>

</div>
