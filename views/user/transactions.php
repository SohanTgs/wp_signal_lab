<?php viser_layout('user/layouts/master'); ?>

<div class="pt-120 pb-100 bg-light">
    <div class="container">
        <table class="table table--responsive--lg mt-4">
            <thead>
                <tr>
                    <th><?php esc_html_e('Trx', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Transacted', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Amount', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Post Balance', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Detail', VISERLAB_PLUGIN_NAME); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions->data as $trx) { ?>
                    <tr>
                        <td>
                            <strong><?php echo esc_html($trx->trx); ?></strong>
                        </td>

                        <td>
                            <?php echo viser_show_date_time($trx->created_at); ?><br><?php echo viser_diff_for_humans($trx->created_at); ?>
                        </td>

                        <td class="budget">
                            <span class="fw-bold <?php if ($trx->trx_type == '+') {
                                                        echo 'text-success';
                                                    } else {
                                                        echo 'text-danger';
                                                    } ?>">
                                <?php echo esc_html($trx->trx_type); ?> <?php echo viser_show_amount($trx->amount); ?> <?php echo viser_currency('text'); ?>
                            </span>
                        </td>

                        <td class="budget">
                            <?php echo viser_show_amount($trx->post_balance); ?> <?php echo viser_currency('text'); ?>
                        </td>

                        <td><?php echo esc_html($trx->details); ?></td>
                    </tr>
                <?php } ?>

                <?php if (viser_check_empty($transactions->data)) { ?>
                    <tr>
                        <td class="text-muted text-center" colspan="100%"><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pt-50">
            <?php if ($transactions->links) { ?>
                <?php echo wp_kses($transactions->links, viser_allowed_html()); ?>
            <?php } ?>
        </div>
    </div>
</div>