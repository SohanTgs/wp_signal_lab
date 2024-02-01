<?php viser_layout('user/layouts/master'); ?>

<section class="pt-120 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="custom--card card-deposit">
                    <div class="card-header">
                        <h5 class="card-title text-center"><?php esc_html_e('Authorize Net', VISERLAB_PLUGIN_NAME); ?></h5>
                    </div>
                    <div class="card-body card-body-deposit">
                    <div class="card-wrapper"></div>
                    <br><br> 

                        <form role="form" id="payment-form" method="<?php echo esc_attr($data->method); ?>" action="<?php echo esc_url($data->url); ?>">
                            <?php viser_nonce_field('ipn.authorize'); ?>
                            <input type="hidden" value="<?php echo esc_attr($data->track); ?>" name="track">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"><?php esc_html_e('Name on Card', VISERLAB_PLUGIN_NAME); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form--control form-control custom-input" name="name" autocomplete="off" autofocus/>
                                        <span class="input-group-text bg--base text-white border-0"><i class="fa fa-font"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php esc_html_e('Card Number', VISERLAB_PLUGIN_NAME); ?></label>
                                    <div class="input-group">
                                        <input type="tel" class="form--control form-control custom-input" name="cardNumber" autocomplete="off" required autofocus/>
                                        <span class="input-group-text bg--base text-white border-0"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="form-label"><?php esc_html_e('Expiration Date', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="tel" class="form-control form--control" name="cardExpiry" autocomplete="off" required />
                                </div>
                                <div class="col-md-6 ">
                                    <label class="form-label"><?php esc_html_e('CVC Code', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="tel" class="form-control form--control" name="cardCVC" autocomplete="off" required />
                                </div>
                            </div>
                            <br>

                            <button class="btn btn-primary w-100" type="submit"><?php esc_html_e('Pay Now', VISERLAB_PLUGIN_NAME); ?></button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
wp_enqueue_script('card', viser_asset('public/js/card.js'), array('jquery'), null, true);
wp_enqueue_script('card-init', viser_asset('public/js/card-init.js'), array('jquery'), null, true);
?>