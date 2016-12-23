<?php $options = get_option('second-touch'); ?>

<?php if ($options["footer_tw_disp"]) { ?>

    <section id="bot-twitter" style="
            <?php if($options['t_panel_padding']) {echo 'padding:30px 0;';} ?>
            <?php if($options['t_panel_bg_color']) {echo 'background-color:' . $options['t_panel_bg_color'] . ';';} ?>
    <?php if (isset($options["t_panel_bg_image"]) &&  ! array($options["t_panel_bg_image"])){
        $options["t_panel_bg_image"] = array('url' => $options["t_panel_bg_image"]);
    } ?>
            <?php if($options['t_panel_bg_image']['url']) {echo 'background-image:url(' . $options['t_panel_bg_image']['url'] . '); background-position: center; background-attachment: fixed;'; } ?>
    ">
        <div class="row">
            <div class="twitter-row">
                <div class="icon"><i class="soc_icon-twitter-3"></i></div>

                <?php
                $numTweets = $options["numb_lat_tw"]; // Number of tweets to display.
                $name = $options["username"]; // Username to display tweets from.
                $excludeReplies = true; // Leave out @replies
                $transName = 'list-tweets'; // Name of value in database.
                $cacheTime = $options["cachetime"]; // Time in minutes between updates.
                $backupName = $transName . '-backup';

                // Do we already have saved tweet data? If not, lets get it.
                /*if(false === ($tweets = get_transient($transName) ) ) :*/

                // Get the tweets from Twitter.
                require_once locate_template('/inc/lib/twitteroauth.php');

                $connection = new TwitterOAuth(
                    $options["twiiter_consumer"], // Consumer Key
                    $options["twiiter_con_s"], // Consumer secret
                    $options["twiiter_acc_t"], // Access token
                    $options["twiiter_acc_t_s"] // Access token secret
                );

                // If excluding replies, we need to fetch more than requested as the
                // total is fetched first, and then replies removed.
                $totalToFetch = ($excludeReplies) ? max(50, $numTweets * 3) : $numTweets;

                $fetchedTweets = $connection->get(
                    'statuses/user_timeline',
                    array(
                        'screen_name' => $name,
                        'count' => $totalToFetch,
                        'exclude_replies' => $excludeReplies
                    )
                );

                // Did the fetch fail?
                if ($connection->http_code != 200) :
                    $tweets = get_option($backupName); // False if there has never been data saved.

                else :
                    // Fetch succeeded.
                    // Now update the array to store just what we need.
                    // (Done here instead of PHP doing this for every page load)
                    $limitToDisplay = min($numTweets, count($fetchedTweets));

                    for ($i = 0; $i < $limitToDisplay; $i++) :
                        $tweet = $fetchedTweets[$i];

                        // Core info.
                        $name = $tweet->user->name;
                        $permalink = 'http://twitter.com/' . $name . '/status/' . $tweet->id_str;

                        /* Alternative image sizes method: http://dev.twitter.com/doc/get/users/profile_image/:screen_name */
                        $image = $tweet->user->profile_image_url;

                        // Message. Convert links to real links.

                        $text = crum_twitter_convert_links($tweet->text);

                        // Need to get time in Unix format.
                        $time = $tweet->created_at;
                        $time = date_parse($time);
                        $uTime = mktime($time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year']);

                        // Now make the new array.
                        $tweets[] = array(
                            'text' => $text,
                            'name' => $name,
                            'permalink' => $permalink,
                            'image' => $image,
                            'time' => $uTime
                        );
                    endfor;

                    update_option($backupName, $tweets);
                endif;
                ?>

                <div class="tw-slider">
                    <ul class="twitter_box slides">
                        <?php foreach ($tweets as $t) : ?>
                            <li class="twitter-item">
                                <?php echo $t['text']; ?>
                                <div class="date updated"><?php echo human_time_diff($t['time'] + ( get_option( 'gmt_offset' ) * 3600 ), current_time('timestamp')); ?>
                                    ago
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="nav">

            </div>
        </div>

        <script type="text/javascript">
            jQuery(window).load(function () {
                jQuery('.tw-slider').flexslider({
                    animation: "slide",
                    namespace: "foot-tw-",             //{NEW} String: Prefix string attached to the class of every element generated by the plugin
                    selector: ".slides > li",       //{NEW} Selector: Must match a simple pattern. '{container} > {slide}' -- Ignore pattern at your own peril
                    easing: "swing",               //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
                    direction: "vertical",
                    slideshow: false,
                    controlsContainer: "#top-footer .columns.nav",
                    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                    directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
                    prevText: "",           //String: Set the text for the "previous" directionNav item
                    nextText: ""
                });
            });
        </script>
    </section>
<?php } ?>