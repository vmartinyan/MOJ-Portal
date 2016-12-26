<?php if ($effects){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<div class="my_skills_widget module <?php echo $css ?> <?php echo $cr_effect; ?>">

    <?php if ( ! empty( $main_title ) ) { ?>
        <h3 class="widget-title">
            <?php echo $main_title ?>
        </h3>
    <?php } ?>

    <div class="wrap">

        <?php foreach ($r_items as $skill): ?>
            <?php
            echo '<label>' . $skill['skill_title'] . '</label>';
            echo '  <div class="progress twelve cr-animate-gen" data-gen="expand"><span class="meter cr-animate-gen"  style="width: ' . $skill['skill_percent'] . '%">
                        <span class="skill-percent">' . $skill['skill_percent'] . '<span>%</span></span>
                        </span></div>';
            ?>

        <?php endforeach; ?>

    </div>

    <div class="me-wrap">
        <?php if ($image) { ?>
            <div class="avatar">

                <?php
                $img = wp_get_attachment_url($image);
                $article_image = aq_resize($img, 80, 80, true);
                ?>
                <img src="<?php echo $article_image ?>" alt="<?php echo $main_title; ?>">
            </div>
        <?php
        }
        if ($name) {
            echo '<h4>' . $name . '</h4>';
        }
        if ($client_job) {
            echo '<div class="dopinfo">' . $client_job . '</div>';
        }
        if ($description) {
            echo '<div class="text">' . mvb_parse_content($description) . '</div>';
        }
        ?>

    </div>

</div>