<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/inc/custom_style/assets/stylechanger.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/custom_style/assets/stylechanger.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/custom_style/assets/colorpicker/farbtastic.css">

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/inc/custom_style/assets/farbtastic.js"></script>


<?php

$pattern_dir_path = get_template_directory().'/inc/custom_style/assets/img/body/';
$pattern_dir_url = get_template_directory_uri().'/inc/custom_style/assets/img/thumb/';
$pattern_dir = opendir ($pattern_dir_path);


$foot_pattern_dir_path = get_template_directory().'/inc/custom_style/assets/foot/';
$foot_pattern_dir_url = get_template_directory_uri().'/inc/custom_style/assets/foot/thumb/';
$foot_pattern_dir = opendir ($foot_pattern_dir_path);

$img_path = get_template_directory_uri().'/assets/stylechanger/';
echo '<script> var customStyleImgUrl = "'.$img_path.'";</script>';



$image_patterns = array();
while($file = readdir($pattern_dir)){
    if(is_image($pattern_dir_path.$file)){
        $image_patterns[] = $file;
    }
}

$footer_patterns = array();
while($file = readdir($foot_pattern_dir)){
    if(is_image($foot_pattern_dir_path.$file)){
        $footer_patterns[] = $file;
    }
}

//Checks is current file is image
function is_image($path){
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    if( ($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif') ){
        return true;
    }
    else
        return false;
}
function insert_patterns_block( $image_patterns ){

    foreach($image_patterns as $image_pattern){
        echo '<a href="#"  class="pattern-example pic"><img src = "'. get_template_directory_uri().'/inc/custom_style/assets/img/thumb/'.$image_pattern.'" alt = "" /></a>';
    }

} ?>

<div class="style_changer">
    <div class="wrap">
    <a href="#" class="changer_button"><i class="moon-cogs"></i></a>

    <div class="changer_content">

        <h3>Change Skin:</h3>

        <div class="layout-change">
            <div class="item">
                <a class="template-option" href = "http://theme.crumina.net/second/">Corporate</a>
                <img src="<?php echo get_template_directory_uri()?>/inc/custom_style/assets/img/layouts/1.jpg" alt=""/>
            </div>
            <div class="item">
                <a class="template-option" href = "http://theme.crumina.net/second/third-layout-2/">Skills</a>
                <img src="<?php echo get_template_directory_uri()?>/inc/custom_style/assets/img/layouts/2.jpg" alt=""/>
            </div>
            <div class="item">
                <a class="template-option" href = "http://theme.crumina.net/second/second-layout-2/">Pageslider</a>
                <img src="<?php echo get_template_directory_uri()?>/inc/custom_style/assets/img/layouts/3.jpg" alt=""/>
            </div>
            <div class="item">
                <a class="template-option" href = "http://theme.crumina.net/second/magazine/">Magazine</a>
                <img src="<?php echo get_template_directory_uri()?>/inc/custom_style/assets/img/layouts/4.jpg" alt=""/>
            </div>
            <div class="item">
                <a class="template-option" href = "http://theme.crumina.net/second/shopped/">Shop</a>
                <img src="<?php echo get_template_directory_uri()?>/inc/custom_style/assets/img/layouts/5.jpg" alt=""/>
            </div>
            <div class="item">
                <a class="template-option" href = "http://theme.crumina.net/second/four-layout/">Timeline</a>
                <img src="<?php echo get_template_directory_uri()?>/inc/custom_style/assets/img/layouts/6.jpg" alt=""/>
            </div>
        </div>

        <div class="cl"></div>
        <h3>Change layout:</h3>

            <div class="boxed_wrap">
                <div class="check_wrap">

                    <input type="checkbox" id="wide_layout"  />
                    <label for="wide_layout" class="wide_layout active">Wide</label>

                    <input type="checkbox" id="boxed_layout"  />
                    <label for="boxed_layout" class="boxed_layout">Boxed</label>

                </div>
            </div>

        <div class="line"></div>

            <div class="boxed_bg">
                <?php insert_patterns_block( $image_patterns ) ?>
            </div>
        <div class="cl"></div>


        <div class="color_scheme_wrap">

            <h3>Change color schemes</h3>

            <a href="#" class="first_color"><span class="round_color"></span><label for="#"> 1st color </label></a>
            <a href="#" class="second_color"><span class="round_color"></span><label for="#"> 2nd color </label></a>
        </div>

        <div class="cl"></div>

        <a href="#" class="ch_button button green load-def">reset to defaults</a>


        <div class="cl"></div>
    </div>
    <div id="custom-style-colorpicker"></div>
    </div>
</div>

<style type="text/css" id="font_color_1"></style>
<style type="text/css" id="font_color_2"></style>