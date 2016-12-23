<?php $options = get_option( 'second-touch' );
$image_crop    = $options['thumb_image_crop'];
if ( $image_crop == "" ) {
	$image_crop = true;
}

if ( $image_crop == '1' ) {
	$thumb_width  = $options['post_thumbnails_width'];
	$thumb_height = $options['post_thumbnails_height'];
} else {
	$thumb_width  = 430;
	$thumb_height = 220;
}
$sharrre_blog_post = isset($options['sharrre_blog_post']) ? $options['sharrre_blog_post'] : false;
?>


<?php
global $post;
$args        = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_parent'    => $post->ID,
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => - 1,
);
$attachments = get_posts( $args );
if ( $attachments ) {
	echo '<div class="slide-post">';

	foreach ( $attachments as $attachment ) {
		$img_url = wp_get_attachment_url( $attachment->ID ); //get img URL

		if ( $options['post_thumbnails_width'] != '' && $options['post_thumbnails_height'] != '' ) {
			$article_image = aq_resize( $img_url, $options['post_thumbnails_width'], $options['post_thumbnails_height'], $image_crop );
		} else {
			$article_image = aq_resize( $img_url, 900, 400, $image_crop );
		}

		?>
		<div><a href="<?php echo $img_url; ?>" data-gal="prettyPhoto[galname]">
				<img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" />
			</a></div>

	<?php
	}
	echo '</div>';

	$postid = get_the_ID(); ?>

	<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery(".post-<?php echo $postid; ?> .slide-post").orbit({
				fluid         : true,
				advanceSpeed  : 6000, 		 // if timer is enabled, time between transitions
				directionalNav: false
			});

		});

	</script>
<?php
} elseif ( has_post_thumbnail() ) {
	$thumb         = get_post_thumbnail_id();
	$img_url       = wp_get_attachment_url( $thumb, 'full' ); //get img URL
	$image_featured = aq_resize( $img_url, $thumb_width, $thumb_height, true );
} else {
	$img_url       = get_template_directory_uri() . '/assets/images/no-image-blog-one.jpg';
	$image_featured = aq_resize( $img_url, $thumb_width, $thumb_height, true );
}?>
<?php if ( isset( $image_featured ) && ! ( empty( $image_featured ) ) ) { ?>
	<div class="entry-thumb">
		<img src="<?php echo $image_featured ?>" alt="<?php the_title(); ?>" />
		<a href="<?php the_permalink(); ?>" class="link"></a>
		<?php if ( comments_open() ) : ?>
			<span class="comments-link"> <?php comments_popup_link( __( 'No Comments', 'crum' ), __( '1 Comment', 'crum' ), __( '% Comments', 'crum' ) ); ?></span>
		<?php endif; ?>

		<?php if ( $sharrre_blog_post ) : ?>
			<div class="post-sharrre" data-url="<?php the_permalink(); ?>" data-media="<?php echo $img_url; ?>" data-text="<?php content( '20', true ); ?>"></div>
		<?php endif; ?>

	</div>
<?php } ?>
