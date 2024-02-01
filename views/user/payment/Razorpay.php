<?php viser_layout('user/layouts/master'); ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center"><?php esc_html_e('Razorpay', VISERLAB_PLUGIN_NAME); ?></h5>
            </div>
            <div class="card-body p-5">
                <ul class="list-group text-center">
                    <li class="list-group-item d-flex justify-content-between">
                        <?php esc_html_e('You have to pay', VISERLAB_PLUGIN_NAME); ?>
                        <strong><?php echo viser_show_amount($deposit->final_amo); ?> <?php echo esc_html($deposit->method_currency); ?></strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <?php esc_html_e('You will get', VISERLAB_PLUGIN_NAME); ?>
                        <strong><?php echo viser_show_amount($deposit->amount); ?> <?php echo viser_currency('text'); ?></strong>
                    </li>
                </ul>
                <form action="<?php echo esc_url($data->url); ?>" method="<?php echo esc_attr($data->method); ?>">
                    <input type="hidden" custom="<?php echo esc_attr($data->custom); ?>" name="hidden">
                    <script src="<?php echo esc_url($data->checkout_js); ?>" <?php foreach ($data->val as $key => $value) { ?> data-<?php echo esc_attr($key); ?>="<?php echo esc_attr($value); ?>" <?php } ?>>
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        "use strict";
        $('input[type="submit"]').addClass("mt-4 btn btn-primary w-100");
    });
</script>