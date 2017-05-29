<?php $options = get_option('second-touch'); ?>


<div class="post-social">

    <time datetime="<?php echo get_the_time('c'); ?>"  class="date updated">
        <span class="day"><?php echo get_the_date('d'); ?></span>
        <span class="month"><?php echo get_the_date('M Y'); ?></span>
    </time>

    <div class="post-format clearfix">

        <?php if (has_post_format('video')) {
            echo '<i class="linecon-video"></i>';
        } elseif (has_post_format('audio')) {
            echo '<i class="linecon-sound"></i>';
        } elseif (has_post_format('gallery')) {
            echo '<i class="linecon-camera"></i>';
        } else {
            echo '<i class="linecon-pen"></i>';
        } ?>

    </div>

    <?php
    if ($options["post_share_button"] == '1') {
        if ($options["custom_share_code"]) {
            echo $options["custom_share_code"];
        } else {  ?>

            <div class="count">
                <div class="fb-like" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false" data-font="arial"></div>
                <script type="text/javascript">
                    (function (d, s, id) {
                        var js = undefined,
                            fjs = d.getElementsByTagName(s)[0];

                        if (d.getElementById(id)) {
                            return;
                        }

                        js = d.createElement(s);
                        js.id = id;
                        js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';

                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                </script>
            </div>


            <div class="count">
                <div class="g-plusone" data-size="tall"></div>
                <script type="text/javascript">
                    (function () {
                        var po = document.createElement('script'),
                            s = document.getElementsByTagName('script')[0];

                        po.type = 'text/javascript';
                        po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';

                        s.parentNode.insertBefore(po, s);
                    })();
                </script>
            </div>

            <div class="count">
				<iframe allowtransparency="true"  frameborder="0" scrolling="no"
						src="https://platform.twitter.com/widgets/tweet_button.html?count=vertical"
						style="width:60px;"></iframe>


            </div>

        <?php }
    } ?>
</div>