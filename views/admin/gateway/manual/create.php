<?php viser_layout('admin/layouts/master'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <form action="<?php echo viser_route_link('admin.gateway.manual.store'); ?>" method="POST" enctype="multipart/form-data">
                <?php viser_nonce_field('admin.gateway.manual.store'); ?>
                <div class="card-body">
                    <div class="payment-method-item">
                        <div class="payment-method-body">
                            <div class="row mb-none-15">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                    <div class="form-group">
                                        <label><?php esc_html_e('Gateway Name', VISERLAB_PLUGIN_NAME); ?></label>
                                        <input type="text" class="form-control" name="name" value="<?php echo esc_attr(viser_old('name')); ?>" required />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                    <div class="form-group">
                                        <label><?php esc_html_e('Currency', VISERLAB_PLUGIN_NAME); ?></label>
                                        <input type="text" name="currency" class="form-control border-radius-5" value="<?php echo esc_attr(viser_old('currency')); ?>" required/>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
                                    <div class="form-group">
                                        <label><?php esc_html_e('Rate', VISERLAB_PLUGIN_NAME); ?></label>
                                        <div class="input-group">
                                            <div class="input-group-text">1 <?php echo viser_currency('text'); ?> =</div>
                                            <input type="number" step="any" class="form-control" name="rate" required value="<?php echo esc_attr(viser_old('rate')); ?>" />
                                            <div class="input-group-text"><span class="currency_symbol"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="card border--primary mt-3">
                                        <h5 class="card-header bg--primary"><?php esc_html_e('Range', VISERLAB_PLUGIN_NAME); ?></h5>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label><?php esc_html_e('Minimum Amount', VISERLAB_PLUGIN_NAME); ?></label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control" name="min_limit" required value="<?php echo esc_attr(viser_old('min_limit')); ?>" />
                                                    <div class="input-group-text"><?php echo viser_currency('text'); ?></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php esc_html_e('Maximum Amount', VISERLAB_PLUGIN_NAME); ?></label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control" name="max_limit" required value="<?php echo esc_attr(viser_old('max_limit')); ?>" />
                                                    <div class="input-group-text"><?php echo viser_currency('text'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="card border--primary mt-3">
                                        <h5 class="card-header bg--primary"><?php esc_html_e('Charge', VISERLAB_PLUGIN_NAME); ?></h5>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label><?php esc_html_e('Fixed Charge', VISERLAB_PLUGIN_NAME); ?></label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control" name="fixed_charge" value="<?php echo esc_attr(viser_old('fixed_charge')); ?>" required />
                                                    <div class="input-group-text"><?php echo viser_currency('text'); ?></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php esc_html_e('Percent Charge', VISERLAB_PLUGIN_NAME); ?></label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control" name="percent_charge" value="<?php echo esc_attr(viser_old('percent_charge')); ?>" required>
                                                    <div class="input-group-text">%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border--primary mt-3">
                                        <h5 class="card-header bg--primary"><?php esc_html_e('Deposit Instruction', VISERLAB_PLUGIN_NAME); ?></h5>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <textarea rows="8" class="form-control border-radius-5 nicEdit" name="instruction"><?php echo wp_kses(viser_old('instruction') ?? '', viser_allowed_html()); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card border--primary mt-3">
                                        <div class="card-header bg--primary d-flex justify-content-between">
                                            <h5 class="text-white"><?php esc_html_e('User Data', VISERLAB_PLUGIN_NAME); ?></h5>
                                            <button type="button" class="btn btn-sm btn-outline-light float-end form-generate-btn"> <i class="la la-fw la-plus"></i><?php esc_html_e('Add New', VISERLAB_PLUGIN_NAME); ?></button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row addedField">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php viser_include('form/modal') ?>
<?php viser_include('form/generator') ?>

<script>
    "use strict";
    var formGenerator = new FormGenerator();
</script>

<?php viser_include('form/action') ?>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        $('input[name=currency]').on('input', function() {
            $('.currency_symbol').text($(this).val());
        });
        <?php if (viser_old('currency')) { ?>
            $('input[name=currency]').trigger('input');
        <?php } ?>
    });
</script>