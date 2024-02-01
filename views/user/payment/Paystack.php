<?php viser_layout('user/layouts/master'); ?>

<div class="pt-120 pb-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title text-center"><?php esc_html_e('Paystack', VISERLAB_PLUGIN_NAME); ?></h5>
                    </div>

                    <div class="card-body p-5">
                        <form action="<?php echo viser_route_link('ipn.paystack'); ?>" method="POST" class="text-center">
                            <?php viser_nonce_field('ipn.paystack'); ?>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item d-flex justify-content-between">
                                    <?php esc_html_e('You have to pay', VISERLAB_PLUGIN_NAME); ?>
                                    <strong><?php echo viser_show_amount($deposit->final_amo); ?> <?php echo esc_html($deposit->method_currency); ?></strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <?php esc_html_e('You will get', VISERLAB_PLUGIN_NAME); ?>
                                    <strong><?php echo viser_show_amount($deposit->amount); ?> <?php echo viser_currency('text'); ?></strong>
                                </li>
                            </ul>
                            <button type="button" class="btn btn--base btn-primary w-100 mt-3" id="btn-confirm"><?php esc_html_e('Pay Now', VISERLAB_PLUGIN_NAME); ?></button>
                            <script src="//js.paystack.co/v1/inline.js" data-key="<?php echo esc_attr($data->key); ?>" data-email="<?php echo esc_attr($data->email); ?>" data-amount="<?php echo round($data->amount); ?>" data-currency="<?php echo esc_attr($data->currency); ?>" data-ref="<?php echo esc_attr($data->ref); ?>" data-custom-button="btn-confirm">
                            </script>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>