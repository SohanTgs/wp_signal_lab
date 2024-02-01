<?php viser_layout('user/layouts/master'); ?>

<div class="pt-120 pb-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom--card">
                    <div class="card-header card-header-bg">
                        <h5 class="card-title text-center"><?php esc_html_e('Payment Preview', VISERLAB_PLUGIN_NAME); ?></h3>
                    </div>

                    <div class="card-body text-center">
                        <h4 class="my-2"><?php esc_html_e('PLEASE SEND EXACTLY', VISERLAB_PLUGIN_NAME); ?> <span class="text-success"><?php echo esc_html($data->amount); ?></span> <?php echo esc_html($data->currency); ?></h4>
                        <h5 class="mb-2"><?php esc_html_e('TO', VISERLAB_PLUGIN_NAME); ?> <span class="text-success"> <?php echo esc_html($data->sendto); ?></span></h5>
                        <img src="<?php echo esc_url($data->img); ?>" alt="<?php esc_html_e('Image', VISERLAB_PLUGIN_NAME); ?>">
                        <h4 class="text-white bold my-4"><?php esc_html_e('SCAN TO SEND', VISERLAB_PLUGIN_NAME); ?></h4>
                    </div> 

                </div>
            </div>
        </div>
    </div>
</div>