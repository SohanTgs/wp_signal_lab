<?php viser_layout('user/layouts/master'); ?>

<div class="pt-120 pb-100 bg-light">
    <div class="container">
        <table class="table table--responsive--lg">
            <thead>
                <tr>
                    <th><?php esc_html_e('Gateway | Transaction', VISERLAB_PLUGIN_NAME); ?></th>
                    <th class="text-center"><?php esc_html_e('Initiated', VISERLAB_PLUGIN_NAME); ?></th>
                    <th class="text-center"><?php esc_html_e('Amount', VISERLAB_PLUGIN_NAME); ?></th>
                    <th class="text-center"><?php esc_html_e('Conversion', VISERLAB_PLUGIN_NAME); ?></th>
                    <th class="text-center"><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Details', VISERLAB_PLUGIN_NAME); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deposits->data as $deposit) {
                    $gateway = viser_gateway($deposit->method_code);
                ?>
                    <tr>
                        <td>
                            <div>
                                <span class="fw-bold"> <span class="text-primary"><?php echo esc_html(@$gateway->name); ?></span> </span>
                                <br>
                                <small><?php echo esc_html($deposit->trx); ?></small>
                            </div>
                        </td>

                        <td class="text-center">
                            <div>
                                <?php echo viser_show_date_time($deposit->created_at); ?><br><?php echo viser_diff_for_humans($deposit->created_at); ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <div>
                                <?php echo viser_currency('sym'); ?><?php echo viser_show_amount($deposit->amount); ?> + <span class="text-danger" title="<?php esc_attr_e('charge', VISERLAB_PLUGIN_NAME); ?>"><?php echo viser_show_amount($deposit->charge); ?> </span>
                                <br>
                                <strong title="<?php esc_attr_e('Amount with charge', VISERLAB_PLUGIN_NAME); ?>">
                                    <?php echo viser_show_amount($deposit->amount + $deposit->charge); ?> <?php echo viser_currency('text'); ?>
                                </strong>
                            </div>
                        </td>
                        <td class="text-center">
                            <div>
                                1 <?php echo viser_currency('text'); ?> = <?php viser_show_amount($deposit->rate); ?> <?php echo esc_html($deposit->method_currency); ?>
                                <br>
                                <strong><?php echo viser_show_amount($deposit->final_amo); ?> <?php echo esc_html($deposit->method_currency); ?></strong>
                            </div>
                        </td>
                        <td class="text-center">
                            <div>
                                <?php
                                $html = '';
                                if ($deposit->status == 2) {
                                    $html = '<span class="badge bg-warning">' . __('Pending', VISERLAB_PLUGIN_NAME) . '</span>';
                                } elseif ($deposit->status == 1 && $deposit->method_code >= 1000) {
                                    $html = '<span><span class="badge bg-success">' . __('Approved', VISERLAB_PLUGIN_NAME) . '</span><br>' . viser_diff_for_humans($deposit->updated_at) . '</span>';
                                } elseif ($deposit->status == 1 && $deposit->method_code < 1000) {
                                    $html = '<span class="badge bg-success">' . __('Succeed', VISERLAB_PLUGIN_NAME) . '</span>';
                                } elseif ($deposit->status == 3) {
                                    $html = '<span><span class="badge bg-danger">' . __('Rejected', VISERLAB_PLUGIN_NAME) . '</span><br>' . viser_diff_for_humans($deposit->updated_at) . '</span>';
                                } else {
                                    $html = '<span><span class="badge bg-dark">' . __('Initiated', VISERLAB_PLUGIN_NAME) . '</span></span>';
                                }
                                echo wp_kses($html, viser_allowed_html());
                                ?>
                            </div>
                        </td>

                        <?php
                            $details = ($deposit->detail != null) ? wp_json_encode(maybe_unserialize($deposit->detail)) : null;
                        ?>

                        <td>
                            <button class="badge badge--icon badge--fill-base <?php if ($deposit->method_code >= 1000) {
                                echo 'detailBtn';
                            } else {
                                echo 'disabled';
                            } ?>" <?php if ($deposit->method_code >= 1000) { ?> data-info='<?php echo esc_attr($details); ?>' <?php } ?> <?php if ($deposit->status == 3) { ?> data-admin_feedback="<?php echo esc_attr($deposit->admin_feedback); ?>" <?php } ?>>
                                <i class="fa fa-desktop"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>

                <?php if (viser_check_empty($deposits->data)) { ?>
                    <tr>
                        <td colspan="100%" class="text-center"><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pt-50">
            <?php if ($deposits->links) { ?>
                <div class="card-footer">
                    <?php echo wp_kses($deposits->links, viser_allowed_html()); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e('Details', VISERLAB_PLUGIN_NAME); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush userData mb-2">
                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--dark btn--sm" data-bs-dismiss="modal"><?php esc_html_e('Close', VISERLAB_PLUGIN_NAME); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');

            var userData = $(this).data('info');
            var html = '';
            if(userData){
                userData.forEach(element => {
                    if(element.type != 'file'){
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });
            }

            if(!html){
                html += `<p class='text-center'><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></p>`;
            }

            modal.find('.userData').html(html);

            if($(this).data('admin_feedback') != undefined){
                var adminFeedback = `
                    <div class="my-3 ms-3">
                        <strong>@lang('Admin Feedback')</strong>
                        <p>${$(this).data('admin_feedback')}</p>
                    </div>
                `;
            }else{
                var adminFeedback = '';
            }

            modal.find('.feedback').html(adminFeedback);

            modal.modal('show');
        });
    });
</script>