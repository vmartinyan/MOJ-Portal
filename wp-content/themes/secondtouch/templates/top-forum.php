<?php $options = get_option('second-touch');

global $post;
$custom_head_img = get_post_meta($post->ID, 'crum_headers_bg_img', true);
$custom_head_color = get_post_meta($post->ID, 'crum_headers_bg_color', true);
$custom_head_subtitle = get_post_meta($post->ID, 'crum_headers_subtitle', true);

if (!($options['stan_header_show_hide'] == '1') ){
    if (isset($options["stan_header_image"]) &&  ! array($options["stan_header_image"])){
        $options["stan_header_image"] = array('url' => $options["stan_header_image"]);
    }
if ($options['stan_header']) {
    echo '<div id="stuning-header" style="';
    if ($custom_head_color && ($custom_head_color != '#ffffff') && ($custom_head_color != '#')) {
        echo ' background-color: ' . $custom_head_color . '; ';
    } elseif
    ($options['stan_header_color']
    ) {
        echo ' background-color: ' . $options['stan_header_color'] . '; ';
    }
    if ($custom_head_img) {
        echo 'background-image: url(' . $custom_head_img . ');  background-position: center;';
    } elseif
    ($options['stan_header_image']['url']
    ) {
        echo 'background-image: url(' . $options['stan_header_image']['url'] . ');  background-position: center;';
    }

    if ($options['stan_header_fixed']) {
        echo 'background-attachment: fixed; background-position:  center -10%;';
    }

    echo '">';
} ?>

    <div class="row">
        <div class="twelve columns">
            <div id="page-title">
                <a href="javascript:history.back()" class="back"></a>

                <div class="page-title-inner">
                    <h1 class="page-title">
                        <?php

                        the_title();

                        ?>
                    </h1>

                    <div class="subtitle">
                        <?php if ($custom_head_subtitle) {
                            echo $custom_head_subtitle;
                        } else {
                            bloginfo('description');
                        }
                        ?>
                    </div>



                    <?php

                if (isset($options['disable_breadcrumbs']) && !$options['disable_breadcrumbs']) {
                    if (function_exists('bbp_breadcrumb')) {

                        echo '<div class="breadcrumbs">';

                        function custom_bbp_breadcrumb()
                        {
                            $args['before'] = '<nav id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
                            $args['after'] = '</nav>';
                            $args['sep'] = '<span class="del">·</span>';
                            $args['home_text'] = __('Home', 'crum');
                            return $args;
                        }

                        add_filter('bbp_before_get_breadcrumb_parse_args', 'custom_bbp_breadcrumb');

                        bbp_breadcrumb();

                        echo '</div>';
                    }
                }  ?>


                </div>


            </div>
        </div>
    </div>
<?php if ($options['stan_header']) {
    echo '</div>';
} ?>
<?php do_action('crum_after_stan_header'); ?>
<?php }?>