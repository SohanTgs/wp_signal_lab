<?php viser_layout('admin/layouts/master'); ?>

<div class="row">
    <div class="col-12">
        <div class="row gy-4">

            <div class="col-xxl-3 col-sm-6">
                <div class="widget-two style--two box--shadow2 b-radius--5 bg--19">
                    <div class="widget-two__icon b-radius--5 bg--primary">
                        <i class="las la-money-bill-wave-alt"></i>
                    </div>
                    <div class="widget-two__content">
                        <h3 class="text-white"><?php echo viser_currency('sym'); ?><?php echo viser_show_amount(viser_balance($user->ID)); ?></h3>
                        <p class="text-white"><?php esc_html_e('Balance', VISERLAB_PLUGIN_NAME); ?></p>
                    </div>
                    <a href="<?php echo viser_route_link('admin.report.transaction'); ?>&amp;username=<?php echo esc_html($user->user_login);?>" class="widget-two__btn"><?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?></a>
                </div>
            </div>
            <!-- dashboard-w1 end -->

            <div class="col-xxl-3 col-sm-6">
                <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                    <div class="widget-two__icon b-radius--5 bg--primary">
                        <i class="las la-wallet"></i>
                    </div>
                    <div class="widget-two__content">
                        <h3 class="text-white"><?php echo viser_currency('sym'); ?><?php echo viser_show_amount($totalDeposit); ?></h3>
                        <p class="text-white"><?php esc_html_e('Deposits', VISERLAB_PLUGIN_NAME); ?></p>
                    </div>
                    <a href="<?php echo viser_route_link('admin.deposit.list'); ?>&amp;username=<?php echo esc_html($user->user_login);?>" class="widget-two__btn"><?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?></a>
                </div>
            </div>
            <!-- dashboard-w1 end -->
            <!-- dashboard-w1 end -->
            <div class="col-xxl-3 col-sm-6">
                <div class="widget-two style--two box--shadow2 b-radius--5 bg--17">
                    <div class="widget-two__icon b-radius--5 bg--primary">
                        <i class="las la-exchange-alt"></i>
                    </div>
                    <div class="widget-two__content">
                        <h3 class="text-white"><?php echo intval($totalTransaction); ?></h3>
                        <p class="text-white"><?php esc_html_e('Transactions', VISERLAB_PLUGIN_NAME); ?></p>
                    </div>
                    <a href="<?php echo viser_route_link('admin.report.transaction'); ?>&amp;username=<?php echo esc_html($user->user_login);?>" class="widget-two__btn"><?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?></a>
                </div>
            </div>
            <!-- dashboard-w1 end -->

            <!-- dashboard-w1 end -->
            <div class="col-xxl-3 col-sm-6">
                <div class="widget-two style--two box--shadow2 b-radius--5 bg--11">
                    <div class="widget-two__icon b-radius--5 bg--primary">
                        <i class="fas fa-signal"></i>
                    </div>
                    <div class="widget-two__content">
                        <h3 class="text-white"><?php echo intval($totalSignal); ?></h3>
                        <p class="text-white"><?php esc_html_e('Signals', VISERLAB_PLUGIN_NAME); ?></p>
                    </div>
                    <a href="<?php echo viser_route_link('admin.report.signal.history'); ?>&amp;username=<?php echo esc_html($user->user_login);?>" class="widget-two__btn"><?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?></a>
                </div>
            </div>
            <!-- dashboard-w1 end -->
        </div>

        <div class="card mt-30">
            <div class="card-header">
                <h5 class="card-title mb-0 justify-content-between d-flex flex-wrap">
                    <div>
                        <?php esc_html_e('Information of', VISERLAB_PLUGIN_NAME);?> <?php echo esc_html($user->display_name);?> 
                        (<?php esc_html_e('Package', VISERLAB_PLUGIN_NAME);?> - 
                            <?php if($user->package_id){ ?>
                                <span class="text--primary"><?php echo esc_html(viser_package($user->package_id)->name); ?></span>
                            <?php }else{ ?>
                                <span class="text--primary"><?php esc_html_e('N/A', VISERLAB_PLUGIN_NAME); ?></span>
                            <?php } ?>
                        )
                    </div>
                    <div>
                        <?php esc_html_e('Validity', VISERLAB_PLUGIN_NAME);?> - <span class="text--primary">
                            <?php if($user->validity){ ?>
                                <span class="text--primary"><?php echo esc_html(viser_show_date_time($user->validity)); ?></span>
                            <?php }else{ ?>
                                <span class="text--primary"><?php esc_html_e('N/A', VISERLAB_PLUGIN_NAME); ?></span>
                            <?php } ?>
                        </span>
                    </div>
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo viser_route_link('admin.users.update');?>&amp;id=<?php echo intval($user->ID);?>" method="POST" enctype="multipart/form-data">
                    <?php viser_nonce_field('admin.users.update');?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php esc_html_e('Full Name', VISERLAB_PLUGIN_NAME);?></label>
                                <input class="form-control w-100" type="text" name="display_name" value="<?php echo esc_attr($user->display_name);?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php esc_html_e('Email', VISERLAB_PLUGIN_NAME);?></label>
                                <input class="form-control" type="email" name="email" value="<?php echo esc_attr($user->user_email);?>" required readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php esc_html_e('Mobile Number', VISERLAB_PLUGIN_NAME);?></label>
                                <div class="input-group ">
                                    <span class="input-group-text mobile-code"></span>
                                    <input type="number" name="mobile" value="<?php echo esc_attr( get_user_meta($user->ID, 'viser_mobile', true));?>" id="mobile" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 col-lg-8">
                            <div class="form-group">
                                <label><?php esc_html_e('Address', VISERLAB_PLUGIN_NAME);?></label>
                                <input class="form-control" type="text" name="address" value="<?php echo esc_attr( get_user_meta($user->ID, 'viser_address', true));?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label><?php esc_html_e('City', VISERLAB_PLUGIN_NAME);?></label>
                                <input class="form-control" type="text" name="city" value="<?php echo esc_attr( get_user_meta($user->ID, 'viser_city', true));?>">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group ">
                                <label><?php esc_html_e('State', VISERLAB_PLUGIN_NAME);?></label>
                                <input class="form-control" type="text" name="state" value="<?php echo esc_attr( get_user_meta($user->ID, 'viser_state', true));?>">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group ">
                                <label><?php esc_html_e('Zip/Postal', VISERLAB_PLUGIN_NAME);?></label>
                                <input class="form-control" type="text" name="zip" value="<?php echo esc_attr( get_user_meta($user->ID, 'viser_zip', true));?>">
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="form-group ">
                                <label><?php esc_html_e('Country', VISERLAB_PLUGIN_NAME);?></label>
                                <select name="country" class="form-control">
                                    <?php foreach($countries as $key => $country){?>
                                        <option data-mobile_code="<?php echo esc_attr($country->dial_code);?>" value="<?php echo esc_attr($key);?>"><?php echo esc_html($country->country);?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-xl-3 col-md-6">
                            <div class="form-group">
                                <label><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME);?></label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="<?php esc_attr_e('Ban', VISERLAB_PLUGIN_NAME);?>" data-off="<?php esc_attr_e('Unban', VISERLAB_PLUGIN_NAME);?>" name="ban" <?php if(get_user_meta($user->ID, 'viser_ban', true)) echo 'checked';?>>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME);?></button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    jQuery(document).ready(function($){
        "use strict"
        let mobileElement = $('.mobile-code');
        $('select[name=country]').change(function(){
            mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        });

        $('select[name=country]').val('<?php echo get_user_meta($user->ID, "viser_country_code", true);?>');
        let dialCode        = $('select[name=country] :selected').data('mobile_code');
        let mobileNumber    = `<?php echo get_user_meta($user->ID, "viser_mobile", true);?>`;
        mobileNumber        = mobileNumber.replace(dialCode,'');
        $('input[name=mobile]').val(mobileNumber);
        mobileElement.text(`+${dialCode}`);
    });
</script>