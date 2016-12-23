<?php
/*
Template Name: Contacts page
*/
crum_header();
$options = get_option('second-touch');
get_template_part('templates/top', 'page');

?>

<section id="layout">

    <?php

    if ($options["cont_m_disp"]) {

        $opt = $options["map_address"];
	    $opt_coord = $options['map_address_coords'];
        $zoom_level = ($options["cont_m_zoom"]) ? $options["cont_m_zoom"] : '14';

        $add_text = get_post_meta($post->ID, '_contacts_page_text', true);
        $qr_code = get_post_meta($post->ID, '_contacts_page_qr', true);
	    $custom_shortcode = get_post_meta($post->ID, '_contacts_page_custom_shortcode', true);

        ?>

        <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>

        <div class="row map-holder">
            <div id="map"></div>

            <?php if ($add_text || $qr_code): ?>

                <div class="box-text">

                    <?php if ($add_text) : echo $add_text; endif ?>

                    <?php if ($qr_code): ?>

                        <div id="qr_code"></div>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        </div>

        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("#map")<?php if ($options["cont_m_height"]) echo '.height("' . $options["cont_m_height"] . 'px")'; ?>.gmap3({

                    marker: {
                        values: [
							<?php
							$resultstr = array();
							if(is_array(($opt))){
								foreach ($opt as $k => $val) {
										$opt[$k] = $val;
										$resultstr[] = '{address: " '. $opt[$k] .'" , data:"'. $opt[$k] .'"}';
								}
							}elseif(!empty($opt)){
								$resultstr[] = '{address: " '. $opt .'" , data:"'. $opt .'"}';
							}else{
								$opt = 'greenwich';
								$resultstr[] = '{address: " '. $opt .'" , data:"'. $opt .'"}';
							}
							if (is_array($opt_coord) && !empty($opt_coord) && !('' === $opt_coord[0])){
								foreach($opt_coord as $single_pair){
									$atts = explode('|',$single_pair);
									$resultstr[] = '{latLng:['.$atts[0].'], data:"'.$atts[1].'"}';
								}
							}
							$result_names = implode(",",$resultstr);
							 echo $result_names;
							?>
                        ],
                        events:{
                            mouseover: function(marker, event, context){
                                var map = jQuery(this).gmap3("get"),
                                    infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
                                if (infowindow){
                                    infowindow.open(map, marker);
                                    infowindow.setContent(context.data);
                                } else {
                                    jQuery(this).gmap3({
                                        infowindow:{
                                            anchor:marker,
                                            options:{content: context.data}
                                        }
                                    });
                                }
                            },
                            mouseout: function(){
                                var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
                                if (infowindow){
                                    infowindow.close();
                                }
                            }
                        }
                    },
                    map: {
                        options: {
                            zoom: <?php echo $zoom_level; ?>,
                            navigationControl: true,
                            mapTypeControl: false,
                            scrollwheel: false,
                            streetViewControl: true
                        }
                    }
                });
                <?php if ($qr_code): ?>

                    jQuery('#qr_code').qrcode({width: 148, height: 148, render	: "table", text: "<?php echo $qr_code; ?>"});

                <?php endif; ?>
            });
        </script>

    <?php } ?>

    <div class="row">
        <div class="six columns">
            <div class="contacts-text">

                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>

                <div class="in-content-social">
                    <div class="soc-icons">
                        <?php crum_social_networks(false); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="six columns">

            <h3 class="widget-title">
                <?php _e('Contact us', 'crum'); ?>
            </h3>

            <?php

            if (isset($custom_shortcode) && !($custom_shortcode == '')){

	            echo do_shortcode($custom_shortcode);

            }elseif ($options["custom_form_shortcode"]) {

                echo do_shortcode($options["custom_form_shortcode"]);

            } else {

                $admin_email = $options["contacts_form_mail"];
                $antispam_answer = $options["antispam_answer"];

                if (empty($admin_email)) {
                    echo __('You need enter email in options panel', 'crum');
                } else  {
                    if ( isset( $_POST['submit'] ) ) {
                        if (trim (strtolower($_POST['antispam_answer']))!== strtolower($antispam_answer)){
                            $antispamError = apply_filters('reactor_antispam_error_message', '<small class="error">' . __('Please enter correct antispam answer.','reactor') . '</small>');
                            $errorClass = 'error';
                            $hasError = true;
                        }

                    }

					$antispamError = (isset($antispamError)) ? $antispamError : '';
					if (!isset($_POST['sender_name']) || !isset($_POST['sender_email']) || !isset($_POST['letter_subject']) || !isset($_POST['letter_text']) || $antispamError) {


                        ?>
                        <form action="" method="POST" name="page_feedback" id="page_feedback">

                            <label for="sender_name"><?php _e('Enter your name', 'crum'); ?></label>
                            <input id="sender_name" name="sender_name" type="text" required="required" value="<?php if ( isset( $_POST['sender_name'] ) ) echo $_POST['sender_name'];?>">

                            <label for="sender_email"><?php _e('Your email', 'crum'); ?></label>
                            <input id="sender_email" name="sender_email" type="email" required="required" value="<?php if ( isset( $_POST['sender_email'] ) ) echo $_POST['sender_email'];?>">

                            <label for="letter_subject"><?php _e('Mail subject', 'crum'); ?></label>
                            <input id="letter_subject" name="letter_subject" type="text" required="required" value="<?php if ( isset( $_POST['letter_subject'] ) ) echo $_POST['letter_subject'];?>">

                            <label for="letter_text"><?php _e('Message', 'crum'); ?></label>
                            <textarea id="letter_text" rows="5" name="letter_text" required="required"><?php if ( isset( $_POST['letter_text'] ) ) { if ( function_exists('stripslashes') ) { echo stripslashes( $_POST['letter_text'] ); } else { echo $_POST['letter_text']; } } ?></textarea>

                            <label for="antispam_answer"><?php _e('Please answer antispam question', 'crum'); ?></label>

                            <div class="row">
                                <div class="eight columns">
                                    <p class="anti-spam-question"><?php echo $options["antispam_question"]; ?></p>
                                </div>
                                <div class="four columns">
                                    <input type="text" required="required" name="antispam_answer" class="text"
                                           id="antispam_answer">
                                    <?php if(isset($antispamError) &&($antispamError !='') ){?>
                                        <span class="error"><?php echo $antispamError;?></span>
                                    <?php }	?>
                                </div>
                            </div>

                            <button class="button flat" name="submit">
                                <span class="icon"><img
                                        src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow-right.gif"
                                        alt="&rarr;"/></span> <?php _e('Send message', 'crum'); ?>
                            </button>

						<?php }else{

						if (isset($_POST['sender_name'])) {
							$headers = 'From: "'. $_POST['sender_name'] . '" <'. $_POST['sender_email'].'>' . "\r\n";
						}

						wp_mail( $admin_email, "Subject: " . $_POST['letter_subject'], $_POST['letter_text'], $headers );

						echo '<h2>' . __('Thank you for your message!' . '</h2>', 'crum');}?>

                        </form>

                        <p><?php echo $options['add_form_text']; ?></p>

                    <?php

                }
            } ?>

        </div>

    </div>
</section>

<?php crum_footer();?>