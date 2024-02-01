<?php
    $balance = 0;
    $user = null;

    $auth = viser_auth();
    $packages = Viserlab\Models\Package::where('status', 1)->paginate(20);
    
    if($auth){ 
        viser_layout('user/layouts/master');
        $user = $auth->user;
        $balance = viser_balance($user->ID);
    }
?> 

<!-- Plan Section -->
<div class="signallab-plan-section pt-120 pb-100">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <?php foreach ($packages->data as $package) { ?>
                <div class="col-xl-3 col-md-6">
                    <div class="plan-item">
                        <div class="plan-item__header">
                            <h4 class="plan-name mb-3 d-flex align-items-center gap-3">
                                <span class="plan-icon"><i class="fas la-hand-point-right"></i></span>
                                <?php echo esc_html($package->name); ?> 
                            </h4>
                            <h4 class="plan-price fw-semibold">
                                <sub class="pre-sub"><?php echo get_option('viser_cur_sym'); ?></sub>
                                <?php echo esc_html_e(viser_show_amount($package->price, 0), VISERLAB_PLUGIN_NAME); ?>
                                <sub>/ <?php esc_html_e('Package', VISERLAB_PLUGIN_NAME); ?></sub>
                            </h4>
                        </div>
                        <div class="plan-item__body">
                            <ul class="list list-style-check">
                                <?php 
                                    if($package->features == null || $package->features == 'null'){ 
                                        $features = [];
                                    }else{
                                        $features = json_decode($package->features);
                                    }
                                ?>
                                <?php foreach($features as $feature) { ?> 
                                    <li class="active"><?php echo esc_html_e($feature, VISERLAB_PLUGIN_NAME); ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="plan-item__footer">
                            <a href="javascript:void(0)" class="btn btn--base w-100 btn--sm text-center py-3 chooseBtn"
                            <?php if ($user) { ?>
                                data-id="<?php echo esc_html_e($package->id, VISERLAB_PLUGIN_NAME); ?>" 
                                data-name="<?php echo esc_html_e($package->name, VISERLAB_PLUGIN_NAME); ?>"
                                data-price="<?php echo esc_html_e(viser_show_amount($package->price), VISERLAB_PLUGIN_NAME); ?>" 
                                data-validity="<?php echo esc_html_e($package->validity, VISERLAB_PLUGIN_NAME); ?>"
                            <?php } ?>
                            >
                                <?php esc_html_e('Choose Plan', VISERLAB_PLUGIN_NAME); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (viser_check_empty($packages->data)) { ?>
                <div>
                    <?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="pt-50 d-flex text-center justify-content-center">
        <?php if ($packages->links) { ?>
            <?php echo wp_kses($packages->links, viser_allowed_html()); ?>
        <?php } ?>
    </div>
</div>
<!-- Plan Section -->

<?php if ($user) { ?>
    <div class="modal fade cmn--modal" id="chooseModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name"><?php esc_html_e('Are you sure to buy', VISERLAB_PLUGIN_NAME); ?> <span class="modal-title-text"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo viser_route_link('user.purchase.package'); ?>" method="post">
                    <?php viser_nonce_field('user.purchase.package'); ?>
                    <div class="modal-body pt-0">
                        <div class="form-group">
                            <input type="hidden" name="id">
                        </div>
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php esc_html_e('Package', VISERLAB_PLUGIN_NAME); ?> <span class="packageName"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php esc_html_e('Price', VISERLAB_PLUGIN_NAME); ?> <span class="packagePrice"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php esc_html_e('Validity', VISERLAB_PLUGIN_NAME); ?> <span class="packageValidity"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php esc_html_e('Your Balance', VISERLAB_PLUGIN_NAME); ?>
                                <span><?php echo esc_html_e(viser_show_amount($balance, 2), VISERLAB_PLUGIN_NAME); ?> <?php echo get_option('viser_cur_text'); ?></span>
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
<?php }else{ ?>
    <div class="modal fade cmn--modal" id="chooseModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header bg--base">
                    <h5 class="modal-title method-name"><?php esc_html_e('Please login before buy a package', VISERLAB_PLUGIN_NAME); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3"><?php esc_html_e('To purchase a package, you have to login into your account', VISERLAB_PLUGIN_NAME); ?></p>
                    <div class="form-group">
                        <a href="<?php echo viser_route_link('user.login'); ?>" class="btn btn--sm btn--base w-100">
                            <?php esc_html_e('Login', VISERLAB_PLUGIN_NAME); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<style>
    .signallab-package-wrapper{
        max-width: 100% !important;
    }
</style>

<script>
    jQuery(document).ready(function($) {
        "use strict";

        $('.chooseBtn').on('click', function () {
            var modal = $('#chooseModal');
            
            <?php if ($user) { ?>
                modal.find('.modal-title-text').text($(this).data('name'));
                modal.find('.packageName').text($(this).data('name'));
                modal.find('.packagePrice').text($(this).data('price')+' '+'<?php echo get_option('viser_cur_text'); ?>');
                modal.find('.packageValidity').text($(this).data('validity')+' Days');
                modal.find('input[name=id]').val($(this).data('id'));
            <?php } ?>

            modal.modal('show');
        });

    });
</script>