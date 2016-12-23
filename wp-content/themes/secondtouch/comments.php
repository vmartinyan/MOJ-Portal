<?php function crum_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?>>
    <div class="clearfix">

        <div class="avatar-box"><?php echo get_avatar($comment, $size = '80'); ?></div>

        <div class="ovh">
            <header class="comment-author vcard">

                <span class="fn"><cite class="fn"><?php _e('Posted by','crum');?> <?php echo get_comment_author_link(); ?></cite></span>

                <time datetime="<?php echo comment_date('c'); ?>">
                    <?php _e('on','crum');?> <?php printf(__('%1$s, %2$s', 'crum'), get_comment_date(), get_comment_time()); ?>
                </time>

                <span class="dop-link">
                    <?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth'])); ?>
                    <?php edit_comment_link(__('(Edit)', 'crum'), '', ''); ?>
                </span>

            </header>

            <section class="comment-content">

                <?php if ($comment->comment_approved == '0') : ?>

                <div class="alert-box">
                    <?php _e('Your comment is awaiting moderation.', 'crum'); ?>
                </div>

                <?php endif; ?>

                <?php comment_text(); ?>

            </section>
        </div>
    </div>
 
    <?php } ?>

<?php if (post_password_required()) : ?>
    <div class="row">
	<section id="comments">
        <div class="alert-box alert">
            <?php _e('This post is password protected. Enter the password to view comments.', 'crum'); ?>
        </div>
    </section><!-- /#comments -->
	</div>
    <?php endif; ?>


<?php if (have_comments()) : ?>
    <div class="row">
	<section id="comments">
        <h3><?php printf(_n('There are <span>1</span> Comment', 'There are <span>%1$s</span> Comments', get_comments_number(), 'crum'), number_format_i18n(get_comments_number())); ?></h3>

        <ol class="commentlist">
            <?php wp_list_comments(array('callback' => 'crum_comment')); ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>

        <nav class="page-nav">
            <?php echo crumina_pagination(); ?>
        </nav>

        <?php endif; // check for comment navigation ?>

        <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
        <?php endif; ?>

    </section><!-- /#comments -->
	</div>
    <?php endif; ?>

<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <?php endif; ?>


<?php if (comments_open()) : ?>
	<div class="row">
    <section id="respond">

        <h3><?php comment_form_title(__('Leave a Reply', 'crum'), __('Leave a Reply to %s', 'crum')); ?></h3>

        <p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
        <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>

        <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'roots'), wp_login_url(get_permalink())); ?></p>

        <?php else : ?>

        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

            <?php if (is_user_logged_in()) : ?>
            <p><span class="log-out"><?php printf(__('Logged in as <a href="%s/wp-admin/profile.php" class="com-author">%s</a>.', 'crum'), get_option('siteurl'), $user_identity); ?></span>
                <a href="<?php echo wp_logout_url(get_permalink()); ?>"  title="<?php __('Log out of this account', 'crum'); ?>"><?php _e('Log out &raquo;', 'crum'); ?></a>
            </p>
            <?php else : ?>

                <label><?php _e('Name', 'crum'); if ($req) _e('*'); ?></label>
                <input type="text" placeholder="" class="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?>>

                <label><?php _e('Email (will not be published)', 'crum'); if ($req) _e('*', 'crum'); ?></label>
                <input type="email" placeholder="" class="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?>>

                <label><?php _e('Website', 'crum'); ?></label>
                <input type="url" class="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3">

            <?php endif; ?>

            <label><?php _e('Comment', 'crum'); ?></label>
            <textarea rows="8" name="comment" id="comment" tabindex="4"></textarea>

            <p>
                <button name="submit" class="button" tabindex="5">
                    <span class="icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow-right.gif" alt="&rarr;"/></span>
                    <?php _e('Submit Comment', 'crum'); ?>
                </button>
            </p>

            <?php comment_id_fields(); ?>
            <?php do_action('comment_form', $post->ID); ?>
        </form>
        <?php endif; // If registration required and not logged in ?>
    </section>
	</div>
<?php endif; // if you delete this the sky will fall on your head ?>
