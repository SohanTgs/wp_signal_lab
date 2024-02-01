<?php viser_layout('admin/layouts/master'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card-body ps-0 pe-0">
            <form action="<?php echo viser_route_link('admin.signal.add') ?>" method="POST">
                <?php viser_nonce_field('admin.signal.add') ?>
                <div class="row">
                    <div class="col-xl-8 mt-xl-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-12">
                                        <div class="form-group">
                                            <label><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></label> 
                                            <input type="text" class="form-control" name="name" required value="<?php echo viser_old('name'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="form-group">
                                            <label><?php esc_html_e('Signal Details', VISERLAB_PLUGIN_NAME); ?></label>
                                            <textarea name="signal" rows="6" class="form-control" required><?php echo viser_old('signal'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-6">
                                        <div class="form-group">
                                            <label><?php esc_html_e('Set Time', VISERLAB_PLUGIN_NAME); ?></label>
                                            <select name="set_time" class="form-control setTime" required>
                                                <option value=""><?php esc_html_e('Select One', VISERLAB_PLUGIN_NAME); ?></option>
                                                <option value="0">
                                                    <?php esc_html_e('Send Now', VISERLAB_PLUGIN_NAME); ?>
                                                </option>
                                                <option value="1">
                                                    <?php esc_html_e('Set Minute', VISERLAB_PLUGIN_NAME); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-md-6 form-group">
                                        <label><?php esc_html_e('Send Signal After', VISERLAB_PLUGIN_NAME); ?></label>
                                        <div class="input-group">
                                            <input type="number" name="minute" id="minute" class="form-control" value="{{ old('minute') }}">
                                            <span class="input-group-text"><?php esc_html_e('Minutes', VISERLAB_PLUGIN_NAME); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 form-group">
                                        <div class="form-group statusArea">
                                            <label><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></label>
                                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="<?php esc_html_e('Enable', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_html_e('Disable', VISERLAB_PLUGIN_NAME); ?>" name="status" class="line-height-27 status">
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 mt-3 border-top pt-4">
                                        <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-xl-0 mt-3">
                        <div class="card">
                            <div class="card-header justify-content-between d-flex flex-wrap">
                                <h6 class="card-title"><?php esc_html_e('Selected Package For This Signal', VISERLAB_PLUGIN_NAME); ?></h6>
                                <div>
                                    <button class="btn btn-sm btn-outline--primary checkedPackage" type="button">
                                        <?php esc_html_e('Select All', VISERLAB_PLUGIN_NAME); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body packages">
                                <ol> 
                                    <?php foreach($packages as $package) { ?> 
                                        <li>
                                            <input type="checkbox" name="packages[]" class="form--control" value="<?php echo intval($package->id); ?>" 
                                                id="<?php echo intval($package->id); ?>"
                                            >
                                            <label for="<?php echo intval($package->id); ?>">
                                                <?php echo esc_html($package->name); ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header justify-content-between d-flex flex-wrap">
                                <h6 class="card-title"><?php esc_html_e('Notification Send Via', VISERLAB_PLUGIN_NAME); ?></h6>
                                <div>
                                    <button class="btn btn-sm btn-outline--primary checkedVia" type="button">
                                        <?php esc_html_e('Select All', VISERLAB_PLUGIN_NAME); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body via">
                                <ol>
                                    <?php foreach($sendVia as $via) { ?> 
                                        <li>
                                            <input type="checkbox" name="send_via[]" class="form--control" value="<?php echo strtolower(esc_html($via)); ?>" 
                                                id="<?php echo esc_html($via); ?>"
                                            >
                                            <label for="<?php echo esc_html($via); ?>">
                                                <?php echo esc_html($via); ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$html = '
    <a class="btn btn-sm btn-outline--primary" href="'.viser_route_link('admin.signal.all').'">
        <i class="las la-undo"></i>' . __("Back", VISERLAB_PLUGIN_NAME) . 
    '</a>';
viser_push_breadcrumb($html);
?>

<script>
    jQuery(document).ready(function($) {
        "use strict";

        $('.setTime').on('change', function () {
            var selected =  $('.setTime option:selected').val();

            if(selected == 0){
                $('#minute').attr('disabled', 'disabled');
                $('.statusArea').hide();
            }else{
                $('#minute').removeAttr('disabled');
                $('.statusArea').show();
            }
        });

        var checkedPackage = false;
        var checkedVia = false;

        $('.checkedPackage').on('click', function(){
            if(checkedPackage){
                checkedPackage = false;
                return $('.packages input:checkbox').prop('checked', false);
            }

            checkedPackage = true;
            return $('.packages input:checkbox').prop('checked', true);
        });

        $('.checkedVia').on('click', function(){
            if(checkedVia){
                checkedVia = false;
                return $('.via input:checkbox').prop('checked', false);
            }

            checkedVia = true;
            return $('.via input:checkbox').prop('checked', true);
        });

    });
</script>
