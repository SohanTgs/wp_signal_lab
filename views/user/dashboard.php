<?php viser_layout('user/layouts/master'); ?>

<!-- Dashboard Section -->
<div class="dashboard-section pt-100 pb-100 bg-light">
    <div class="container">
        <div class="row gy-4 pt-60 pb-60">
            <div class="col-lg-4 col-md-6">
                <div class="dashboard-widget has--link">
                    <a href="<?php echo viser_route_link('user.transaction.index'); ?>" class="item--link"></a>
                    <div class="dashboard-widget__icon">
                        <i class="las la-money-bill-wave text--base"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <p class="text-uppercase mb-1 fw-medium"><?php esc_html_e('Total Balance', VISERLAB_PLUGIN_NAME); ?></p>
                        <h4 class="title"><?php echo get_option('viser_cur_sym'); ?> <?php echo viser_show_amount(viser_balance($user->ID)); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="dashboard-widget has--link">
                    <a href="javascript:void(0)" class="item--link <?php echo $user->package_id ? 'renewBtn' : null; ?>"
                        <?php if ($user->package_id): ?>
                            data-package="<?php echo esc_html(json_encode($package)); ?>"
                        <?php endif; ?>
                    >
                    </a>
                    <div class="dashboard-widget__icon">
                        <i class="las la-calendar text--base"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <p class="text-uppercase mb-1 fw-medium">
                            <?php if ($user->package_id != 0): ?>
                                <?php echo esc_html($package->name); ?>
                            <?php else: ?>
                                <?php esc_html_e('Package', VISERLAB_PLUGIN_NAME); ?>
                            <?php endif; ?>
                        </p>
                        <h4 class="title">
                            <?php if ($user->package_id != 0): ?>
                                <?php echo viser_show_date_time($user->validity, 'd M Y'); ?>
                            <?php else: ?>
                                <?php esc_html_e('N/A', VISERLAB_PLUGIN_NAME); ?>
                            <?php endif; ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="dashboard-widget has--link">
                    <a href="<?php echo viser_route_link('user.deposit.history'); ?>" class="item--link"></a>
                    <div class="dashboard-widget__icon">
                        <i class="las la-wallet text--base"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <p class="text-uppercase mb-1 fw-medium"><?php esc_html_e('Total Deposit', VISERLAB_PLUGIN_NAME); ?></p>
                        <h4 class="title "><?php echo get_option('viser_cur_sym'); ?> <?php echo viser_show_amount($totalDeposit); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="dashboard-widget has--link">
                    <a href="<?php echo viser_route_link('user.signals'); ?>" class="item--link"></a>
                    <div class="dashboard-widget__icon">
                        <i class="las la-signal text--base"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <p class=" text-uppercase mb-1 fw-medium"><?php esc_html_e('Total Signal', VISERLAB_PLUGIN_NAME); ?></p>
                        <h4 class="title "><?php echo intval($totalSignal); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="dashboard-widget has--link">
                    <a href="<?php echo viser_route_link('user.transaction.index'); ?>" class="item--link"></a>
                    <div class="dashboard-widget__icon">
                        <i class="las la-exchange-alt text--base"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <p class=" text-uppercase mb-1 fw-medium"><?php esc_html_e('Total Transaction', VISERLAB_PLUGIN_NAME); ?></p>
                        <h4 class="title "><?php echo intval($totalTrx); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="dashboard-widget has--link">
                    <a href="<?php echo viser_route_link('user.ticket.index'); ?>" class="item--link"></a>
                    <div class="dashboard-widget__icon">
                        <i class="las la-ticket-alt text--base"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <p class=" text-uppercase mb-1 fw-medium"><?php esc_html_e('Total Ticket', VISERLAB_PLUGIN_NAME); ?></p>
                        <h4 class="title "><?php echo intval($totalTicket); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h5 class="mb-4 text-center"><?php esc_html_e('Latest Transaction', VISERLAB_PLUGIN_NAME); ?></h5>
                <table class="table table--responsive--lg">
                    <thead class="bg--base">
                        <tr>
                            <th><?php esc_html_e('Trx', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Transacted', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Amount', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Post Balance', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Detail', VISERLAB_PLUGIN_NAME); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestTrx as $trx) { ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html($trx->trx); ?></strong>
                                </td>
                                <td>
                                    <?php echo viser_show_date_time($trx->created_at); ?> <br />
                                    <?php echo viser_diff_for_humans($trx->created_at); ?>
                                </td>
                                <td class="budget">
                                    <span class="fw-bold <?php echo esc_attr($trx->trx_type) == '+' ? 'text--success fw-bold' : 'text--danger fw-bold' ?>">
                                        <?php echo esc_html($trx->trx_type); ?>
                                        <?php echo viser_show_amount($trx->amount); ?> <?php echo viser_currency('text'); ?>
                                    </span>
                                </td>
                                <td class="budget">
                                    <?php echo viser_show_amount($trx->post_balance); ?> <?php echo viser_currency('text'); ?>
                                </td>
                                <td><?php echo esc_html($trx->details); ?></td>
                            </tr>
                        <?php } ?>
                        <?php if (viser_check_empty($latestTrx)) { ?>
                            <tr> 
                                <td class="text-muted text-center" colspan="100%"><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard Section -->

<?php if ($user->package_id != 0): ?>
    <div class="modal fade cmn--modal" id="renewModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo viser_route_link('user.renew.package'); ?>" method="post">
                    <?php viser_nonce_field('user.renew.package'); ?>
                    <div class="modal-body pt-0">
                        <div class="form-group">
                            <input type="hidden" name="id" required>
                        </div> 
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php esc_html_e('Package', VISERLAB_PLUGIN_NAME); ?> <span class="packageName"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-item s-center">
                                <?php esc_html_e('Price', VISERLAB_PLUGIN_NAME); ?> <span class="packagePrice"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php esc_html_e('Validity', VISERLAB_PLUGIN_NAME); ?> <span class="packageValidity"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php esc_html_e('Your Balance', VISERLAB_PLUGIN_NAME); ?>
                                <span><?php echo viser_show_amount(viser_balance($user->ID)); ?> <?php echo get_option('viser_cur_text'); ?> </span>
                            </li> 
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn--sm" data-bs-dismiss="modal">
                            <?php esc_html_e('Close', VISERLAB_PLUGIN_NAME); ?>
                        </button>
                        <div class="prevent-double-click">
                            <button type="submit" class="btn btn--sm btn--success">
                                <?php esc_html_e('Confirm', VISERLAB_PLUGIN_NAME); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
            "use strict";

            $('.renewBtn').on('click', function () {
                var modal = $('#renewModal');

                modal.find('.modal-title').text('Are you sure to renew '+$(this).data('package').name).addClass('text-uppercase');
                modal.find('.packageName').text($(this).data('package').name);
                modal.find('.packagePrice').text($(this).data('package').price+' '+'<?php echo get_option('viser_cur_text'); ?>');
                modal.find('.packageValidity').text($(this).data('package').validity+' <?php esc_html_e('Days', VISERLAB_PLUGIN_NAME); ?>');
                modal.find('input[name=id]').val($(this).data('package').id);

                modal.modal('show');
            });

        });
    </script>

<?php endif; ?>