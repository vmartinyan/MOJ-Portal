<div class="pie_charts_module module row <?php echo $css ?> ">

    <?php if ($main_title != ''): ?>

        <h3 class="widget-title">

            <?php echo $main_title ?>

        </h3>

    <?php endif; ?>

    <?php if (count($r_items) > 0): ?>

        <?php $i = '1';
        foreach ($r_items as $panel): ?>


            <?php if ($panel['effects']){
                $cr_effect = ' cr-animate-gen"  data-gen="'.$panel['effects'].'" data-gen-offset="bottom-in-view';
            } else {
                $cr_effect ='';
            } ?>

            <?php
            if ($panel['item_size'] == 'large') {
                $chart_size = '260';
                $chart_class = 'large';
            } else {
                $chart_size = '220';
                $chart_class = 'normal';
            }
            ?>

            <div class="<?php echo $column_number ?> columns <?php echo $cr_effect; ?>">

                <div class="charts-box <?php echo $chart_class; ?>">

                    <canvas id="<?php echo $unique_id . $i; ?>-pieChartCanvas" height="<?php echo $chart_size; ?>" width="<?php echo $chart_size; ?>"></canvas>

            <span class="chart-wrapper">
            <?php if ($panel['icon'] != '') { ?>

                <i class="<?php echo $panel['icon'] ?>"></i>

            <?php } ?>
            </span>

                    <script>

                        jQuery(document).ready(function () {

                            var <?php echo $unique_id . $i; ?>_pieChartData = [
                                {
                                    value: <?php echo $panel['percent']; ?>,
                                    color: "<?php if ($panel['chart_main']){ echo '#'.$panel['chart_main'];}else {echo '#36bae2';}?>"
                                },
                                {
                                    value: 100 -<?php echo $panel['percent']; ?>,
                                    color: "<?php if ($panel['chart_bg']){ echo '#'.$panel['chart_bg'];}else {echo '#8397a0';}?>"
                                }

                            ];

                            var globalGraphSettings = {
                                percentageInnerCutout : 95,
                                segmentShowStroke: false,
                                segmentStrokeWidth: 0,
                                animationEasing: "easeInOutQuad",
                                animation: true,
                                animationSteps: 100,
                                animateScale : true };

                            var <?php echo $unique_id . $i;  ?>_ctx = document.getElementById("<?php echo $unique_id . $i; ?>-pieChartCanvas").getContext("2d");
                            new Chart(<?php echo $unique_id . $i; ?>_ctx).Doughnut(<?php echo $unique_id . $i; ?>_pieChartData, globalGraphSettings);

                        });

                    </script>


                    <div class="charts-box-content">

                        <div class="percent">
                            <?php echo $panel['percent']; ?>
                            <span>%</span>
                        </div>

                        <div class="title">
                            <div class="block-title"><?php echo $panel['main_title'] ?></div>
                            <div class="dopinfo"><?php echo $panel['sub_title'] ?></div>
                        </div>


                        <?php if ($panel['content'] != ''): ?>
                            <div class="text">
                                <?php echo mvb_parse_content($panel['content'], TRUE); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        <?php $i++;  endforeach; ?>
    <?php endif; ?>
</div>