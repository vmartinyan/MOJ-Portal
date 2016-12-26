<div class="tabs_module module <?php echo $css ?>">

	<?php if ( ! empty( $main_title ) ) { ?>
		<h3 class="widget-title">
			<?php echo $main_title ?>
		</h3>
	<?php } ?>

    <dl class="tabs horisontal clearfix">

		<?php $i = 1; ?>
		<?php $active_count = '0'; ?>
        <?php foreach( $r_items as $item ): ?>
            <?php if (!($active_count == '1')){?>
			<dd <?php if( $item['tab_selected'] == '1'){ ?> class="active"<?php $active_count = '1';} ?>><a href="#<?php echo $unique_id.'_'.$i ?>"><?php echo $item['tab_title'] ?></a></dd>
			<?php }else{?>
			<dd ><a href="#<?php echo $unique_id.'_'.$i ?>"><?php echo $item['tab_title'] ?></a></dd>
            <?php }$i++; ?>
        <?php endforeach; ?>
    </dl>
    <ul class="tabs-content clearfix">
        <?php $i = 1; ?>
		<?php $active_count = '0'; ?>
        <?php foreach( $r_items as $item ): ?>
			<?php if (!($active_count == '1')){?>
				<li <?php if( $item['tab_selected'] == '1'){ ?> class="active"<?php $active_count = '1'; } ?> id="<?php echo $unique_id.'_'.$i ?>Tab"><?php echo mvb_parse_content($item['content'], TRUE) ?></li>
			<?php }else{?>
				<li id="<?php echo $unique_id.'_'.$i ?>Tab"><?php echo mvb_parse_content($item['content'], TRUE) ?></li>
			<?php }$i++; ?>
        <?php endforeach; ?>
    </ul>
</div>
