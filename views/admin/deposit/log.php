<?php viser_layout('admin/layouts/master'); ?>
<div class="card b-radius--10">
    <div class="card-body p-0">
        <div class="table-responsive--sm table-responsive">
            <table class="table table--light style--two">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Gateway | Transaction', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('Initiated', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('User', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('Amount', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('Conversion', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('Action', VISERLAB_PLUGIN_NAME); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deposits->data as $deposit) {
                        $user = get_userdata($deposit->user_id);
                        $gateway = viser_gateway($deposit->method_code);
                    ?>
                        <tr>
                            <td>
                                <span class="fw-bold"><?php esc_html_e(@$gateway->name, VISERLAB_PLUGIN_NAME); ?></span>
                                </br>
                                <small><?php echo esc_html($deposit->trx); ?></small>
                            </td>
                            <td>
                                <?php echo viser_show_date_time($deposit->created_at); ?><br><?php echo viser_diff_for_humans($deposit->created_at); ?>
                            </td>
                            <td>
                                <span class="fw-bold"><?php echo esc_html($user->display_name); ?></span>
                                <br />
                                <a href="<?php echo viser_route_link('admin.users.detail'); ?>&amp;id=<?php echo intval($user->ID); ?>">
                                    <span class="small">@<?php echo esc_html($user->user_login); ?></span>
                                </a>
                            </td>
                            <td>
                                <?php echo viser_currency('sym') . viser_show_amount($deposit->amount); ?> + <span class="text--danger" title="<?php esc_attr_e('charge', VISERLAB_PLUGIN_NAME); ?>"><?php echo viser_show_amount($deposit->charge); ?></span>
                                <br>
                                <strong title="<?php esc_attr_e('Amount after charge', VISERLAB_PLUGIN_NAME); ?>">
                                    <?php echo viser_show_amount($deposit->amount + $deposit->charge); ?> <?php echo viser_currency('text'); ?>
                                </strong>
                            </td>
                            <td>
                                1 <?php echo viser_currency('text'); ?> = <?php echo viser_show_amount($deposit->rate); ?> <?php echo esc_html($deposit->method_currency); ?>
                                <br>
                                <span class="fw-bold"><?php echo viser_show_amount($deposit->final_amo); ?> <?php echo esc_html($deposit->method_currency); ?></span>
                            </td>
                            <td>
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
                                    $html = '<span class="badge badge--dark">' . __('Initiated', VISERLAB_PLUGIN_NAME) . '</span>';
                                }
                                echo wp_kses($html, viser_allowed_html());
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo viser_route_link('admin.deposit.details'); ?>&amp;id=<?php echo intval($deposit->id); ?>" class="btn btn-sm btn-outline--primary ms-1">
                                    <i class="la la-desktop"></i> <?php esc_html_e('Details', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php if (viser_check_empty($deposits->data)) { ?>
                        <tr>
                            <td colspan="7" class="text-center"><?php esc_html_e('Data Not Found', VISERLAB_PLUGIN_NAME); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table><!-- table end -->
        </div>
    </div>
    <?php if (@$deposits->links) { ?>
        <div class="card-footer">
            <?php echo wp_kses($deposits->links, viser_allowed_html()); ?>
        </div>
    <?php } ?>
</div><!-- card end -->