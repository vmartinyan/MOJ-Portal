<?php crum_header();?>
<?php

get_template_part('templates/top', 'page'); ?>

<?php $custom_layout = get_post_meta(get_the_ID(),'page_layout_select',true);

if(isset($custom_layout) && !empty($custom_layout)){
	$layout = $custom_layout;
	$custom = 'yes';
}else{
	$layout = 'pages';
	$custom = 'no';
}

?>

<?php $options = get_option('second-touch');?>
<section id="layout">
    <div class="row">

        <?php
        set_layout($layout, true, $custom);

        get_template_part('templates/content', 'page');

?>
		<div class="twelve columns"><?php
		if ($options['page_comments_display'] == '1'){
		comments_template();
		}?>
		</div><?php


        set_layout($layout, false, $custom);

        ?>
    </div>
</section>
<?php crum_footer();?>