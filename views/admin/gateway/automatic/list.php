<?php viser_layout('admin/layouts/master'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Gateway', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Supported Currency', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Enabled Currency', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Action', VISERLAB_PLUGIN_NAME); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gateways as $k => $gateway) {
                                $supported_currencies = json_decode($gateway->supported_currencies, true);
                            ?>
                                <tr>
                                    <td><?php echo esc_html($gateway->name); ?></td>
                                    <td><?php echo count($supported_currencies); ?></td>
                                    <td><?php echo viser_gateway_currency_count($gateway->code); ?></td>
                                    <td>
                                        <?php
                                        if ($gateway->status == 1) {
                                            echo '<span class="text--small badge badge--success">' . __("Enabled", VISERLAB_PLUGIN_NAME) . '</span>';
                                        } else {
                                            echo '<span class="text--small badge badge--warning">' . __("Disabled", VISERLAB_PLUGIN_NAME) . '</span>';
                                        } ?>
                                    </td>

                                    <td>
                                        <div class="button--group">
                                            <a href="<?php echo viser_route_link('admin.gateway.automatic.edit'); ?>&amp;id=<?php echo intval($gateway->id); ?>" class="btn btn-sm btn-outline--primary">
                                                <i class="la la-pencil"></i> <?php esc_html_e('Edit', VISERLAB_PLUGIN_NAME); ?>
                                            </a>
                                            <?php if ($gateway->status == 0) { ?>
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-question="<?php esc_attr_e('Are you sure to enable this gateway?', VISERLAB_PLUGIN_NAME); ?>" data-action="<?php echo viser_route_link('admin.gateway.automatic.status'); ?>&amp;id=<?php echo intval($gateway->id); ?>" data-nonce="<?php echo esc_attr(viser_nonce('admin.gateway.automatic.status')) ?>">
                                                    <i class="la la-eye"></i> <?php esc_html_e('Enable', VISERLAB_PLUGIN_NAME); ?>
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn" data-question="<?php esc_attr_e('Are you sure to disable this gateway?', VISERLAB_PLUGIN_NAME); ?>" data-action="<?php echo viser_route_link('admin.gateway.automatic.status'); ?>&amp;id=<?php echo intval($gateway->id); ?>" data-nonce="<?php echo esc_attr(viser_nonce('admin.gateway.automatic.status')) ?>">
                                                    <i class="la la-eye-slash"></i> <?php esc_html_e('Disable', VISERLAB_PLUGIN_NAME); ?>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (viser_check_empty($gateways)) { ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php esc_html_e('Data Not found', VISERLAB_PLUGIN_NAME); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>
<?php viser_include('partials/confirmation'); ?>