<?php viser_layout('user/layouts/master'); ?>

<section class="pt-120 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="custom--card card-deposit">
                    <div class="card-header">
                        <h5 class="card-title text-center"><?php esc_html_e('NMI', VISERLAB_PLUGIN_NAME); ?></h5>
                    </div>
                    <div class="card-body card-body-deposit">

                    <form role="form" id="payment-form" method="<?php echo esc_attr($data->method); ?>" action="<?php echo esc_url($data->url); ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label"><?php esc_html_e('Card Number', VISERLAB_PLUGIN_NAME); ?></label>
                                <div class="input-group">
                                    <input type="tel" class="form-control form--control" name="billing-cc-number" autocomplete="off" required autofocus />
                                    <span class="input-group-text bg--base text-white border-0"><i class="fa fa-credit-card"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="form-label"><?php esc_html_e('Expiration Date', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="tel" class="form-control form--control" name="billing-cc-exp" placeholder="<?php echo esc_attr(__('e.g. MM/YY', VISERLAB_PLUGIN_NAME)); ?>" autocomplete="off" required />
                            </div>
                            <div class="col-md-6 ">
                                <label class="form-label"><?php esc_html_e('CVC Code', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="tel" class="form-control form--control" name="billing-cc-cvv" autocomplete="off" required />
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary w-100" type="submit"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>