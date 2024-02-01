<?php viser_layout('admin/layouts/master'); ?>

<div class="row">
    <div class="col-xxl-12 col-md-12 mb-30">
        <div class="card-body ps-0 pe-0">
            <form action="<?php echo viser_route_link('admin.signal.update') ?>" method="POST" class="form">
                <?php viser_nonce_field('admin.signal.update') ?>
                <input type="hidden" name="id" value="<?php echo intval($signal->id); ?>" required>
                <div class="row">
                    <div class="col-xl-8 mt-xl-0">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title mt-2 justify-content-between d-flex flex-wrap">
                                    <div>
                                        <h6 class="d-inline"><?php esc_html_e('Send Status', VISERLAB_PLUGIN_NAME); ?></h6> 
                                        <?php 
                                            $html = ''; 
                                            if($signal->send == 1){
                                                $html = "<span class='text--small badge font-weight-normal badge--success'>".__('Send', VISERLAB_PLUGIN_NAME)."</span>";
                                            }else{
                                                $html  = "<span class='text--small badge font-weight-normal badge--warning'>".__('Not Send', VISERLAB_PLUGIN_NAME)."</span>";
                                            }
                                            echo wp_kses($html, viser_allowed_html());
                                        ?>
                                    </div>
                                    <div>
                                        <h6 class="d-inline"><?php esc_html_e('Send Time', VISERLAB_PLUGIN_NAME); ?></h6>
                                        <?php if ($signal->send_signal_at) { ?>
                                            <?php echo viser_show_date_time($signal->send_signal_at); ?> 
                                            <small>(<?php echo viser_diff_for_humans($signal->send_signal_at); ?>)</small>
                                        <?php }else { ?>
                                            <?php esc_html_e('N/A', VISERLAB_PLUGIN_NAME); ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-12">
                                        <div class="form-group">
                                            <label><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></label>
                                            <input type="text" class="form-control" name="name" placeholder="@lang('Name')" required 
                                            value="<?php echo esc_attr($signal->name);?>">
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="form-group">
                                            <label><?php esc_html_e('Signal Details', VISERLAB_PLUGIN_NAME); ?></label>
                                            <textarea name="signal" rows="6" class="form-control" required placeholder="@lang('Signal Details')"><?php echo esc_attr($signal->signal);?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div class="form-group">
                                            <label><?php esc_html_e('Set Time', VISERLAB_PLUGIN_NAME); ?></label>
                                            <select name="set_time" class="form-control setTime" required>
                                                <option value=""><?php esc_html_e('Select One', VISERLAB_PLUGIN_NAME); ?></option>
                                                <option value="0" <?php if (!$signal->minute) { ?> selected <?php } ?>>
                                                    <?php esc_html_e('Send Now', VISERLAB_PLUGIN_NAME); ?>
                                                </option>
                                                <option value="1" <?php if ($signal->minute) { ?> selected <?php } ?>>
                                                    <?php esc_html_e('Set Minute', VISERLAB_PLUGIN_NAME); ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6 form-group">
                                        <label><?php esc_html_e('Send Signal After', VISERLAB_PLUGIN_NAME); ?></label>
                                        <div class="input-group">
                                            <input type="number" name="minute" id="minute" class="form-control" placeholder="<?php esc_html_e('Minute', VISERLAB_PLUGIN_NAME); ?>" value="<?php echo esc_attr($signal->minute);?>">
                                            <span class="input-group-text"><?php esc_html_e('Minutes', VISERLAB_PLUGIN_NAME); ?></span>
                                        </div>
                                    </div>
                                    <?php if ($signal->send) { ?>
                                        <div class="col-xxl-3 col-md-6 form-group">
                                            <div class="form-group">
                                                <label><?php esc_html_e('Signal Resend Now', VISERLAB_PLUGIN_NAME); ?></label>
                                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="<?php esc_html_e('Yes', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_html_e('No', VISERLAB_PLUGIN_NAME); ?>" name="resend" class="line-height-27">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-xxl-3 col-md-6 form-group"> 
                                        <div class="form-group statusArea">
                                            <label><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></label>
                                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="<?php esc_html_e('Enable', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_html_e('Disable', VISERLAB_PLUGIN_NAME); ?>" name="status" class="line-height-27 status" <?php if ($signal->status == 1) { ?> checked <?php } ?>>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 border-top pt-4">
                                        <div class="row">
                                            <div class="col-xxl-12">
                                                <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                                            </div>
                                        </div>
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
                                <?php 
                                    if($signal->package_id == null || $signal->package_id == 'null'){ 
                                        $packageArray = [];
                                    }else{
                                        $packageArray = json_decode($signal->package_id);
                                    }
                                ?>
                                <ol> 
                                    <?php foreach($packages as $package) { ?> 
                                        <li>
                                            <input type="checkbox" name="packages[]" class="form--control" value="<?php echo intval($package->id); ?>" 
                                            id="<?php echo intval($package->id); ?>"
                                            <?php if(in_array($package->id, $packageArray)) { ?>
                                                checked
                                            <?php } ?>
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
                                <?php 
                                    if($signal->send_via == null || $signal->send_via == 'null'){ 
                                        $sendArray = [];
                                    }else{
                                        $sendArray = json_decode($signal->send_via);
                                    }
                                ?>
                                <ol>
                                    <?php foreach($sendVia as $via) { ?> 
                                        <li>
                                            <input type="checkbox" name="send_via[]" class="form--control" value="<?php echo strtolower(esc_html($via)); ?>" 
                                            id="<?php echo esc_html($via); ?>"
                                            <?php if(in_array(strtolower($via), $sendArray)) { ?>
                                                checked
                                            <?php } ?>
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

<div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e('Confirmation Alert!', VISERLAB_PLUGIN_NAME); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="#" method="POST" class="confirmForm">
                <input type="hidden" name="id">

                <div class="modal-body">
                    <p class="question"><?php esc_html_e('Are you sure to resend this signal?', VISERLAB_PLUGIN_NAME); ?></p>
                    <p class="description mt-3 fw-bold">
                        <?php esc_html_e('If this signal has already been sent via', VISERLAB_PLUGIN_NAME); ?>
                        (<?php echo implode(',', $sendVia); ?>) <br>
                        <?php esc_html_e('We cannot modify that. The system updates it from our panel and resends the signal via', VISERLAB_PLUGIN_NAME); ?>
                        (<?php echo implode(',', $sendVia); ?>)
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php esc_html_e('No', VISERLAB_PLUGIN_NAME); ?></button>
                    <button type="submit" class="btn btn--primary"><?php esc_html_e('Yes', VISERLAB_PLUGIN_NAME); ?></button>
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

        var submit = null;
        var confirm = false;
        var checkedVia = false;
        var checkedPackage = false;

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

        $('.setTime').on('change', function () {
            var selected =  $('.setTime option:selected').val();

            if(selected == 0){
                $('#minute').attr('disabled', 'disabled');
                $('.statusArea').hide();
            }else{
                $('#minute').removeAttr('disabled');
                $('.statusArea').show();
            }
        }).change();

        $('.form').on('submit', function(e){
            var resend = $('input[name="resend"]').prop('checked');

            if(!confirm && resend){
                submit = false;
            }else{
                submit = true;
            }

            if(!submit){
                $('#confirmationModal').modal('show');
                return false;
            }

            return true;
        });

        $('.confirmForm').on('submit', function(e){
            e.preventDefault();
            submit = true;
            confirm = true;
            return $('.form').submit();
        });
    });
</script>
