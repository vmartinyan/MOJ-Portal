<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="gmap_module <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php
    $options = get_option('second-touch');
    if(isset($options['map-api']) && !empty($options['map-api']) ){
        $api_key = $options['map-api'];
    }else{
        $api_key = '';
    }
    $language = substr( get_locale(), 0, 2 );
    wp_enqueue_script( 'googleMaps', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&language=' . $language, null, null, true );
    ?>

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title twelve columns">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>


    <?php if (isset($additional_info) && $additional_info) {$columns = 'six';} else {$columns = 'twelve';} ?>


    <div class="row map-widget ">

        <div class="<?php echo $columns; ?> columns">

            <div id="map-<?php echo $unique_id; ?>" style="height: <?php echo $height; ?>px;"></div>

            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery("#map-<?php echo $unique_id; ?>").gmap3({

                        marker: {
                            <?php if ($r_items): ?>
                            values: [
                                <?php foreach ($r_items as $address):
                                echo '{address: " '. $address['address'] .'"},';
                                endforeach; ?>
                            ]
                            <?php else:

                            echo '{address: " '. $address .'"},';

                            endif; ?>
                        },
                        map: {
                            options: {
                                zoom: <?php if ($zoom) {echo $zoom;}  else {echo '14';}  ?>,
                                navigationControl: true,
                                scrollwheel: false,
                                streetViewControl: true
                            }
                        }
                    });
                });
            </script>

        </div>

        <?php if (isset($additional_info) && $additional_info) { ?>

            <div class="<?php echo $columns; ?> columns">

                <?php echo mvb_parse_content($additional_info); ?>

            </div>

        <?php } ?>

    </div>
</div>