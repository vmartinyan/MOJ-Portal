<?php $post_id = get_the_ID();
$options = get_option('second-touch');
$image_crop    = $options['thumb_image_crop'];
$sharrre_blog_post = isset($options['sharrre_blog_post']) ? $options['sharrre_blog_post'] : false;

if ( $image_crop == '1' ) {
	$thumb_width  = $options['post_thumbnails_width'];
	$thumb_height = $options['post_thumbnails_height'];
} else {
	$thumb_width  = 430;
	$thumb_height = 220;
}

if ( get_post_meta( get_the_ID(), 'post_vimeo_video_url', true ) ) {
	?>

	<div class="flex-video widescreen vimeo">
		<iframe src='https://player.vimeo.com/video/<?php echo get_post_meta( get_the_ID(), 'post_vimeo_video_url', true ); ?>?portrait=0' width='640' height='460' frameborder='0'></iframe>
	</div>

<?php
} elseif ( get_post_meta( get_the_ID(), 'post_youtube_video_url', true ) ) {
	?>

	<div class="flex-video  widescreen">
		<iframe width="640" height="460" src="https://www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), 'post_youtube_video_url', true ); ?>?wmode=opaque" frameborder="0" class="youtube-video" allowfullscreen></iframe>
	</div>
<?php
} elseif ( get_post_meta( $post_id, "self_hosted_videos", true ) ) {

	if ( has_post_thumbnail() ) {
		$thumb         = get_post_thumbnail_id();
		$img_url       = wp_get_attachment_url( $thumb, 'full' ); //get img URL
		$article_image = aq_resize( $img_url, 500, 300, true );
	} ?>

	<link href="https://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
	<script src="https://vjs.zencdn.net/c/video.js"></script>



	<video id="video-post<?php the_ID(); ?>" class="video-js vjs-default-skin" controls
	       preload="auto"
	       width="500"
	       height="281"
	       poster="<?php echo $article_image ?>"
	       data-setup="{}">


		<?php if ( get_post_meta( $post_id, "post_video_mp4", true ) ): ?>
			<source src="<?php echo get_post_meta( $post_id, "post_video_mp4", true ) ?>" type='video/mp4'>
		<?php endif; ?>
		<?php if ( get_post_meta( $post_id, "post_video_webm", true ) ): ?>
			<source src="<?php echo get_post_meta( $post_id, "post_video_webm", true ) ?>" type='video/webm'>
		<?php endif; ?>
	</video>


<?php
} elseif ( has_post_thumbnail() ) {
	$thumb         = get_post_thumbnail_id();
	$img_url       = wp_get_attachment_url( $thumb, 'full' ); //get img URL
	$article_image = aq_resize( $img_url, $thumb_width, $thumb_height, true );
} else {
	$img_url       = get_template_directory_uri() . '/assets/images/no-image-blog-one.jpg';
	$article_image = aq_resize( $img_url, $thumb_width, $thumb_height, true );
}?>
<?php if(isset($article_image) && !(empty($article_image))){?>
<div class="entry-thumb">
	<img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" />
	<a href="<?php the_permalink(); ?>" class="link"></a>
	<?php if ( comments_open() ) : ?>
		<span class="comments-link"> <?php comments_popup_link( __( 'No Comments', 'crum' ), __( '1 Comment', 'crum' ), __( '% Comments', 'crum' ) ); ?></span>
	<?php endif; ?>

	<?php if ( $sharrre_blog_post ) : ?>
		<div class="post-sharrre" data-url="<?php the_permalink(); ?>" data-media="<?php echo $img_url; ?>" data-text="<?php content( '20', true ); ?>"></div>
	<?php endif; ?>

</div>
<?php }?>