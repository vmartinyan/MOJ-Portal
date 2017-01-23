<?php
/**
 * Author Box
 *
 * Displays author box with author description and thumbnail on single posts
 *
 * @package WordPress
 * @subpackage OneTouch theme, for WordPress
 * @since OneTouch theme 1.9
 */
?>

<?php $options = get_option('second-touch'); ?>

<div class="about-author">
    <figure class="author-photo">
        <?php echo get_avatar( get_the_author_meta('ID') , 80 ); ?>
    </figure>
    <div class="ovh">
        <div class="author-description">
            <h4><?php the_author_posts_link(); ?><span><?php _e('Post author','crum');?></span></h4>
            <p><?php the_author_meta('description'); ?></p>
        </div>

        <div class="share-icons">
         
            <?php if (get_the_author_meta('twitter')) {  echo '<a href="',the_author_meta('twitter'),'"><i class="soc_icon-twitter"></i></a>';  } ?>
            <?php if (get_the_author_meta('cr_facebook')) {  echo '<a href="',the_author_meta('cr_facebook'),'"><i class="soc_icon-facebook"></i></a>';  } ?>
            <?php if (get_the_author_meta('googleplus')) {  echo '<a href="',the_author_meta('googleplus'),'"><i class="soc_icon-googleplus"></i></a>';  } ?>
            <?php if (get_the_author_meta('linkedin')) {  echo '<a  href="',the_author_meta('linkedin'),'"><i class="soc_icon-linkedin"></i></a>';  } ?>
            <?php if (get_the_author_meta('vimeo')) {  echo '<a  href="',the_author_meta('vimeo'),'"><i class="soc_icon-vimeo"></i></a>';  } ?>
            <?php if (get_the_author_meta('lastfm')) {  echo '<a  href="',the_author_meta('lastfm'),'"><i class="soc_icon-last_fm"></i></a>';  } ?>
            <?php if (get_the_author_meta('tumblr')) {  echo '<a  href="',the_author_meta('tumblr'),'"><i class="soc_icon-tumblr"></i></a>';  } ?>
            <?php if (get_the_author_meta('skype')) {  echo '<a  href="',the_author_meta('skype'),'"><i class="soc_icon-skype"></i></a>';  } ?>
            <?php if (get_the_author_meta('vkontakte')) {  echo '<a  href="',the_author_meta('vkontakte'),'"><i class="soc_icon-vkontakte"></i></a>';  } ?>
            <?php if (get_the_author_meta('deviantart')) {  echo '<a  href="',the_author_meta('deviantart'),'"><i class="soc_icon-deviantart"></i></a>';  } ?>
            <?php if (get_the_author_meta('picasa')) {  echo '<a  href="',the_author_meta('picasa'),'"><i class="soc_icon-picasa"></i></a>';  } ?>
            <?php if (get_the_author_meta('wordpress')) {  echo '<a  href="',the_author_meta('wordpress'),'"><i class="soc_icon-wordpress"></i></a>';  } ?>
            <?php if (get_the_author_meta('instagram')) {  echo '<a  href="',the_author_meta('instagram'),'"><i class="soc_icon-instagram"></i></a>';  } ?>

        </div>
    </div>
</div>