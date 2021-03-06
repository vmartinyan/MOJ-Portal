<?php defined('ABSPATH') or die("Cannot access pages directly."); ?>

<div class="row">
    <div class="col-sm-6 col-md-6 data-source">
        <h4 class="c-black m-b-20">
            <?php _e('wpDataTable Data Source', 'wpdatatables'); ?>
            <i class="zmdi zmdi-help-outline" data-toggle="tooltip" data-placement="right"
               title="<?php _e('Please pick a wpDataTable which will be used as a data source for this chart.', 'wpdatatables'); ?>"></i>
        </h4>
        <div class="form-group">
            <div class="fg-line">
                <div class="select">
                    <select class="selectpicker" name="wpdatatables-chart-source" id="wpdatatables-chart-source"
                            data-live-search="true">
                        <option value=""><?php _e('Pick a wpDataTable', 'wpdatatables'); ?></option>
                        <?php foreach (WPDataTable::getAllTables() as $table) { ?>
                            <option value="<?php echo $table['id'] ?>"><?php echo $table['title'] ?>
                                (id: <?php echo $table['id']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
