<?php

// Buttons
function crum_flexslider( $atts, $content = null ) {
    $id =0;
    extract( shortcode_atts( array(
        'id' => '', /* some unique id */
    ), $atts ) );

    /* If there's no content, just return back what we got. */
    if ( is_null( $content ) )
        return $content;

    $output = '<div id="' . $id . '"><span class="extra-links"></span>';
    $output .= $content;
    $output .= '</div>';

    $output .= '<script type="text/javascript">
            jQuery(document).ready(function () {

                jQuery("#' . $id . ' div.woocommerce").flexslider({
                    selector: "ul.products > li",
                    animation: "slide",
                    direction: "horizontal",
                    itemWidth: 280,                     //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
                    itemMargin: 20,                     //{NEW} Integer: Margin between carousel items.
                    minItems: 1,                        //{NEW} Integer: Minimum number of carousel items that should be visible. Items will resize fluidly when below this.
                    maxItems: 4,
                    controlsContainer: ".extra-links",
                    slideshow: false,
                    controlNav: false,            //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav: true,           //Boolean: Create navigation for previous/next navigation? (true/false)
                    prevText: "",                 //String: Set the text for the "previous" directionNav item
                    nextText: ""
                });

            });
        </script>';

    return $output;
}

add_shortcode('flexslider', 'crum_flexslider');
