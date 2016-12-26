<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="h_skills_module module <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php }

echo '<div class="skills_widget">';

echo '<div class="start-label"> ' . $start_label . ' </div>';

echo '<div class="finish-label"> ' . $finish_label . ' </div>';

?>
<div class="line"><hr></div><div class="skill-wrap">


<?php foreach ($r_items as $skill): ?>

<?php
    echo '<div class="skill-item ' . $skill['skill_position'] . ' ' . $skill['skill_color'] . '" style="left: ' . $skill['skill_percent'] . '% ">';

    echo '<div class="item-title">
                <span class="title">' . $skill['skill_title'] . ' </span>
                <div class="subtitle"> ' . $skill['skill_subtitle'] . ' </div>
          </div>';

    echo '<div class="percent"> ' . $skill['skill_percent'] . '<span>%</span> </div>';

    echo '</div>';
?>

<?php endforeach; ?>

</div></div>