<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Crumina page slider
 * @author    Liondekam <liondekam@gmail.com>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2013 Crumina Team
 */
?>


<div class="wrap">

    <?php

    $plugin_slug = 'crumina-page-slider';


    if (isset($_GET['action']) && $_GET['action'] == 'add') {
        include(dirname(__FILE__) . '/add.php');

    } elseif (isset($_GET['action']) && $_GET['action'] == 'edit') {
        include(dirname(__FILE__) . '/edit.php');

    } else {
        include(dirname(__FILE__) . '/list.php');
    }

    // Remove slider
    if (isset($_GET['page']) && $_GET['page'] == $plugin_slug && isset($_GET['action']) && $_GET['action'] == 'remove') {
        crumina_slider_removeslider($plugin_slug);
    }
    if (isset($_GET['page']) && $_GET['page'] == $plugin_slug && isset($_GET['action']) && $_GET['action'] == 'edit') {
        cruminaslider_edit($plugin_slug);
    }
    if (isset($_GET['page']) && $_GET['page'] == $plugin_slug && isset($_GET['action']) && $_GET['action'] == 'add') {
        cruminaslider_add_new($plugin_slug);
    }

    /********************************************************/
    /*            Crumina slider remove           */
    /********************************************************/

    function crumina_slider_removeslider($plugin_slug)
    {

        if (!isset($_GET['id'])) {
            return;
        }

        $id = (int)$_GET['id'];

        global $wpdb;

        $table_name = $wpdb->prefix . 'crum_page_slider';

        $wpdb->query("DELETE FROM $table_name WHERE id = '$id' LIMIT 1");

		echo "<script>document.location.replace('admin.php?page=' . $plugin_slug . ')';</script>";

        //header('Location: admin.php?page=' . $plugin_slug . '');
        die();
    }


    /********************************************************/
    /*            Crumina slider save settings              */
    /********************************************************/


    function cruminaslider_add_new($plugin_slug)
    {
        if (isset($_POST['posted_add']) && strstr($_SERVER['REQUEST_URI'], $plugin_slug)) {

            global $wpdb;

            $slider_data = json_encode($_POST['slider']);
            $slider_title = (isset($_POST['title'])) ? $_POST['title'] : '';

            // Table name
            $table_name = $wpdb->prefix . "crum_page_slider";

            $id = mysql_insert_id();

            $wpdb->insert($table_name, array(
                'id' => $id,
                'name' => $slider_title,
                'data' => $slider_data,
                'date_c' => time(),
                'date_m' => time()
            ), array(
                '%d',
                '%s',
                '%s',
                '%d',
                '%d'
            ));

			//echo "<script>document.location.replace('admin.php?page=' . $plugin_slug . ')';</script>";
	        $slider_id = $wpdb->insert_id;
	        $url = 'admin.php?page=crumina-page-slider&action=edit&id='.$slider_id.'';
		        $string = '<script type="text/javascript">';
		        $string .= 'window.location = "' . $url . '"';
		        $string .= '</script>';
		        echo $string;

            //header('Location: admin.php?page=' . $plugin_slug . '');
            die();
        }
    }

    /********************************************************/
    /*            Crumina slider save settings              */
    /********************************************************/


    function cruminaslider_edit($plugin_slug)
    {
        if (isset($_POST['posted_edit']) && strstr($_SERVER['REQUEST_URI'], $plugin_slug)) {

            // Get WPDB Object
            global $wpdb;

            // Table name
            $table_name = $wpdb->prefix . "crum_page_slider";

            // Get the IF of the slider
            $id = (int)$_GET['id'];

            $slider = array();

            $slider = $_POST['slider'];
            $title = (isset($_POST['title'])) ? $_POST['title'] : '';

            // DB data
            $slider_title = $title;
            $slider_data = json_encode($slider);

            // Update
            $wpdb->update($table_name, array(
                    'name' => $slider_title,
                    'data' => $slider_data,
                    'date_c' => time()
                ),
                array('ID' => $id),
                array(
                    '%s',
                    '%s',
                    '%d'
                ),
                array('%d'));

            //clear slider transient cache
            crumina_slider_reset_cache($id);

			crum_slider_custom_styles();

        }
    }

	/********************************************************/
	/*            Crumina slider generate custom css        */
	/********************************************************/

	function crum_slider_custom_styles(){


		//crumSliders();
		$sliderz = crumSliders();

		$custom_css = '';

		foreach ($sliderz as $slide){
			$id = $slide['id'];

		$slider = crumSliderById($id);
		$slider = $slider['data'];

		$category_bg_color = $slider ['category_background_color'];
		$slide_hover_color = $slider['slide_hover_color'];
		$odd_slide_hover_color = $slider ['odd_slide_hover_color'];
		$slide_hover_opacity = $slider['opacity'];

		$template = $slider['template'];

		if (!empty($category_bg_color)) {

			$bg_color = slider_convert_hex_to_rgb($category_bg_color);

		} else {
			$bg_color = false;
		}

		if (!empty($slide_hover_color)) {

			$b_color =  slider_convert_hex_to_rgb($slide_hover_color);
		} else {
			$b_color = false;
		}

		if (!empty($odd_slide_hover_color)) {

			$odd_b_color =  slider_convert_hex_to_rgb($odd_slide_hover_color);
		} else {
			$odd_b_color = false;
		}

		if (!empty($slide_hover_opacity) || $slide_hover_opacity === '0'){
			if ($slide_hover_opacity >= 100){
				$opacity = '1';
			}elseif($slide_hover_opacity <=0){
				$opacity = '0';
			}elseif(($slide_hover_opacity>0) && ($slide_hover_opacity<10)){
				$opacity = '0.0'.$slide_hover_opacity.'';
			}else{
				$opacity = '0.'.$slide_hover_opacity.'';
			}
		}else{
			$opacity = '87';
		}

			if ( $b_color ) {
				$custom_css .= "
				#wrap-slider-" . $id . " .crum-slider .item .item-content-metro {   background: rgb(" . $b_color . "); background: rgba(" . $b_color . "," . $opacity . ");}
				#wrap-slider-" . $id . " .entry-thumb a:hover {opacity: 1; background: rgba(" . $b_color . "," . $opacity . ");}
				#wrap-slider-" . $id . ".crumina-slider-wrap .active .item-content:hover{background: rgb(" . $b_color . ");background: rgba(" . $b_color . "," . $opacity . ");}";

			}
			if ( $odd_b_color ) {
				$custom_css .= "
				#wrap-slider-" . $id . " .crum-slider .item.even .item-content-metro {   background: rgb(" . $odd_b_color . ");background: rgba(" . $odd_b_color . "," . $opacity . ");}";
			}
			if ( $bg_color ) {
				$custom_css .= "
				#wrap-slider-" . $id . ".crumina-slider-wrap .active .click-section { background: rgb(" . $bg_color . ");}
				#wrap-slider-" . $id . ".crumina-slider-wrap .item-content .slider-icon-wrap{color: rgb(" . $bg_color . ");}
				#wrap-slider-" . $id . ".crumina-slider-wrap .active .click-section {background:  rgb(" . $bg_color . ");}
				#wrap-slider-" . $id . ".crumina-slider-wrap .item-content .slider-icon{color:  rgb(" . $bg_color . ");}
				#wrap-slider-" . $id . ".crumina-slider-wrap .entry-thumb a:before{color:  rgb(" . $bg_color . ");}
				#wrap-slider-" . $id . ".crumina-slider-wrap .cat-name { background: rgb(" . $bg_color . "); background: rgba(" . $bg_color . ", 0.5);}
				#wrap-slider-" . $id . ".crumina-slider-wrap .cat-name:hover {background: rgb(" . $bg_color . ");background: rgba(" . $bg_color . ", 1);}
				#wrap-slider-" . $id . ".entry-thumb a:before {color: rgb(" . $bg_color . ");}
				#wrap-slider-" . $id . ".crumina-slider-wrap .entry-title a:hover   {color: rgb(" . $bg_color . ");}";
			}
			if ( $template == '1b-4s' ) {
				$custom_css .= "
				#wrpap-slider-" . $id .".crumina-slider-wrap .small-element.item .cat-name {
				position: absolute;
				left: 3px;
				top: 0;}";

			}
		}
		/** Capture CSS output **/
		ob_start();
		echo $custom_css;
		$css = ob_get_clean();

		/** Write to options.css file **/
		WP_Filesystem();
		global $wp_filesystem;
		if ( ! $wp_filesystem->put_contents(plugin_dir_path( __FILE__).'../css/options.css', $css, 0755) ) {
			file_put_contents( plugin_dir_path( __FILE__).'../css/options.css', $css );
			return true;
		}

	}


    /********************************************************/
    /*            Crumina slider clear cache           */
    /********************************************************/

    function crumina_slider_reset_cache($id) {

        delete_transient( 'crum_page_slider_cache_'.$id );
        delete_transient( 'crum_loopOutput_'.$id );

    }



    /********************************************************/
    /*            Crumina slider list items             */
    /********************************************************/

    function crumSliders($limit = 50, $desc = true, $withData = false)
    {

        // Get DB stuff
        global $wpdb;
        $table_name = $wpdb->prefix . 'crum_page_slider';

        // Order
        $order = ($desc === true) ? 'DESC' : 'ASC';

        // Data
        if ($withData === true) {
            $data = ' data,';
        }

        // Get sliders
        $link = $sliders = $wpdb->get_results("SELECT * FROM $table_name
									ORDER BY id $order LIMIT " . (int)$limit . "", ARRAY_A);

        // No results
        if ($link == null) {
            return array();
        }

        return $sliders;
    }


    function crumSliderById($id = 0)
    {

        // No ID
        if ($id == 0) {
            return false;
        }

        // Get DB stuff
        global $wpdb;
        $table_name = $wpdb->prefix . "crum_page_slider";

        // Get data
        $link = $slider = $wpdb->get_row("SELECT * FROM $table_name WHERE id = " . (int)$id . " ORDER BY date_c DESC LIMIT 1", ARRAY_A);

        // No results
        if ($link == null) {
            return false;
        }

        // Convert data
        $slider['data'] = json_decode($slider['data'], true);

        // Return the slider
        return $slider;
    }


	function slider_convert_hex_to_rgb($hex)
	{
		$hex = str_replace("#", "", $hex);

		if (strlen($hex) == 3) {
			$r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
			$g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
			$b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
		} else {
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb);
	}


    ?>

</div>
