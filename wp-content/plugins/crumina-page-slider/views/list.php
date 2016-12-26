<?php

$sliders = crumSliders(200, false, true);
$plugin_slug = 'crumina-page-slider';


?>
<div class="wrap">

    <h2>
        <?php _e('Crumina sliders', 'crumina-page-slider') ?>
        <a href="?page=<?php echo $plugin_slug ?>&action=add" class="add-new-h2"><?php _e('Add New', 'crumina-page-slider') ?></a>
    </h2>

    <div class="ls-box ls-slider-list">
        <table id="hor-zebra">
            <thead>
            <tr>
                <td>#</td>
                <td><?php _e('Name', 'crumina-page-slider') ?></td>
                <td><?php _e('Shortcode', 'crumina-page-slider') ?></td>
                <td><?php _e('Actions', 'crumina-page-slider') ?></td>

            </tr>
            </thead>
            <tbody>

            <?php if(!empty($sliders)) : ?>
            <?php foreach($sliders as $key => $item) : ?>
            <?php $name = empty($item['name']) ? 'Unnamed' : $item['name']; ?>

                      <tr>
                        <td><?php echo($key + 1) ?></td>
                        <td>
                            <a href="?page=<?php echo $plugin_slug; ?>&action=edit&id=<?php echo $item['id'] ?>"><?php echo $name ?></a>
                        </td>
                        <td>[cruminaslider id="<?php echo $item['id'] ?>"]</td>
                        <td>
                            <a href="?page=<?php echo $plugin_slug; ?>&action=edit&id=<?php echo $item['id'] ?>"><?php _e('Edit', 'crumina-page-slider') ?></a>
                            |
                            <a href="?page=<?php echo $plugin_slug; ?>&action=remove&id=<?php echo $item['id'] ?>" class="remove">
                                <?php _e('Remove', 'crumina-page-slider') ?></a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (empty($sliders)) : ?>
                <tr>
                    <td colspan="6"><?php _e("You didn't create any slider yet.", "crum") ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>