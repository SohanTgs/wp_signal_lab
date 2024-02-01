<?php viser_layout('admin/layouts/master'); ?>
<div class="row mb-none-30 justify-content-center">
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 text-muted"><?php esc_html_e('Deposit Via', VISERLAB_PLUGIN_NAME); ?> <?php echo esc_html(@$gateway->name); ?></h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Date', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold"><?php echo esc_html(viser_show_date_time($deposit->created_at)); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Transaction Number', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold"><?php echo esc_html($deposit->trx); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Username', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold">
                            <a href="<?php echo viser_route_link('admin.users.detail');?>&amp;id=<?php echo intval($user->ID); ?>">
                                <?php echo esc_html($user->user_login); ?>
                            </a>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Method', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold"><?php echo esc_html(@$gateway->name); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Amount', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold"><?php echo esc_html(viser_show_amount($deposit->amount)); ?> <?php echo viser_currency('text'); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Charge', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold"><?php echo esc_html(viser_show_amount($deposit->charge)); ?> <?php echo viser_currency('text'); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('After Charge', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold"><?php echo esc_html(viser_show_amount($deposit->amount + $deposit->charge)); ?> <?php echo viser_currency('text'); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Rate', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold">1 <?php echo viser_currency('text'); ?> = <?php echo esc_html(viser_show_amount($deposit->rate)); ?> <?php echo esc_html($deposit->method_currency); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Payable', VISERLAB_PLUGIN_NAME); ?>
                        <span class="fw-bold"><?php echo viser_show_amount($deposit->final_amo); ?> <?php echo esc_html($deposit->method_currency); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?>
                        <?php

                        $html = '';
                        if ($deposit->status == 2) {
                            $html = '<span class="badge badge--warning">' . __('Pending', VISERLAB_PLUGIN_NAME) . '</span>';
                        } elseif ($deposit->status == 1 && $deposit->method_code >= 1000) {
                            $html = '<span><span class="badge badge--success">' . __('Approved', VISERLAB_PLUGIN_NAME) . '</span><br>' . viser_diff_for_humans($deposit->updated_at) . '</span>';
                        } elseif ($deposit->status == 1 && $deposit->method_code < 1000) {
                            $html = '<span class="badge badge--success">' . __('Succeed', VISERLAB_PLUGIN_NAME) . '</span>';
                        } elseif ($deposit->status == 3) {
                            $html = '<span><span class="badge badge--danger">' . __('Rejected', VISERLAB_PLUGIN_NAME) . '</span><br>' . viser_diff_for_humans($deposit->updated_at) . '</span>';
                        } else {
                            $html = '<span><span class="badge badge--dark">' . __('Initiated', VISERLAB_PLUGIN_NAME) . '</span></span>';
                        }

                        echo wp_kses($html, viser_allowed_html());

                        ?>
                    </li>
                    <?php if ($deposit->admin_feedback) { ?>
                        <li class="list-group-item">
                            <strong><?php esc_html_e('Admin Response', VISERLAB_PLUGIN_NAME); ?></strong>
                            <br>
                            <p><?php echo esc_html($deposit->admin_feedback); ?></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <?php if($deposit->method_code >= 1000) : ?>

    <?php $details = json_decode(json_encode(maybe_unserialize($deposit->detail))); ?>

    <?php if ($details || $deposit->status == 2) { ?>
        <div class="col-xl-8 col-md-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2"><?php esc_html_e('User Deposit Information', VISERLAB_PLUGIN_NAME); ?></h5>
                    <?php
                    if (!viser_check_empty($details)) {
                        foreach ($details as $val) { ?>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6><?php echo esc_html($val->name); ?></h6>
                                    <?php if ($val->type == 'checkbox') {
                                        echo implode(',', $val->value);
                                    } elseif ($val->type == 'file') {
                                        if ($val->value) { ?>
                                            <a href="<?php echo viser_route_link('admin.download.attachment') ?>&amp;file_path=<?php echo viser_encrypt(viser_file_path('verify') . '/' . $val->value) ?>" class="me-3"><i class="fa fa-file"></i> <?php esc_html_e('Attachment', VISERLAB_PLUGIN_NAME); ?> </a>
                                        <?php } else {
                                            echo esc_html__('No File', VISERLAB_PLUGIN_NAME);
                                        }
                                    } else { ?>
                                        <?php echo esc_html($val->value); ?></p>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                    <?php }
                    } ?>

                    <?php if ($deposit->status == 2) { ?>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button class="btn btn-outline--success btn-sm ms-1 confirmationBtn" data-nonce="<?php echo esc_attr(viser_nonce('admin.deposit.approve')) ?>" data-action="<?php echo viser_route_link('admin.deposit.approve'); ?>&amp;id=<?php echo intval($deposit->id); ?>" data-question="<?php esc_attr_e('Are you sure to approve this transaction?', VISERLAB_PLUGIN_NAME); ?>">
                                    <i class="las la-check-double"></i> <?php esc_html_e('Approve', VISERLAB_PLUGIN_NAME); ?>
                                </button>
                                <button class="btn btn-outline--danger btn-sm ms-1 rejectBtn" data-id="<?php echo intval($deposit->id); ?>" data-info="<?php echo wp_json_encode($details); ?>" data-amount="<?php echo esc_attr(viser_show_amount($deposit->amount)); ?> <?php echo viser_currency('text'); ?>" data-username="<?php echo esc_attr($user->user_login); ?>"><i class="las la-ban"></i> <?php esc_html_e('Reject', VISERLAB_PLUGIN_NAME); ?>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php endif ?>

<?php viser_include('partials/confirmation'); ?>

<div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e('Reject Deposit Confirmation', VISERLAB_PLUGIN_NAME); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="<?php echo viser_route_link('admin.deposit.reject'); ?>" method="POST">
                <?php viser_nonce_field('admin.deposit.reject'); ?>
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p><?php esc_html_e('Are you sure to', VISERLAB_PLUGIN_NAME); ?> <span class="fw-bold"><?php esc_html_e('reject', VISERLAB_PLUGIN_NAME); ?></span> <span class="fw-bold withdraw-amount text-success"></span> <?php esc_html_e('deposit of', VISERLAB_PLUGIN_NAME); ?> <span class="fw-bold withdraw-user"></span>?</p>

                    <div class="form-group">
                        <label class="fw-bold mt-2"><?php esc_html_e('Reason for Rejection', VISERLAB_PLUGIN_NAME); ?></label>
                        <textarea name="message" maxlength="255" class="form-control" rows="5" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function($) {
        "use strict";
        $('.rejectBtn').on('click', function() {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));
            modal.modal('show');
        });
    })(jQuery);
</script>