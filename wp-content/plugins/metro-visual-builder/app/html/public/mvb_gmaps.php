<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="gmap_module <?php echo $css ?> <?php echo $cr_effect; ?>">


    <?php if ($main_title != ''): ?>

        <h3 class="twelve columns widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

    <?php if (isset($additional_info) && $additional_info) {$columns = 'six';} else {$columns = 'twelve';} ?>


    <div class="row map-widget ">

        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>

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