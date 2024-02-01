<?php viser_layout('user/layouts/master'); ?>

<section class="pt-120 pb-100 bg-light">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-10">
                <div class="custom--card">
                    <div class="card-header">
                        <h5 class="card-title text-center"><?php echo esc_html($pageTitle); ?></h5>
                    </div>
                    <div class="card-body"> 
                        <form class="register" action="<?php echo viser_route_link('user.profile.setting.update'); ?>" method="post">
                            <?php viser_nonce_field('user.profile.setting.update'); ?>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="form-label" for="display_name"><?php esc_html_e('Full Name', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="text" class="form-control form--control" name="display_name" value="<?php echo esc_html($user->display_name); ?>" id="display_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="form-label"><?php esc_html_e('E-mail Address', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input class="form-control form--control" value="<?php echo esc_attr($user->user_email); ?>" readonly>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label"><?php esc_html_e('Mobile Number', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input class="form-control form--control" value="<?php echo esc_attr(get_user_meta($user->ID, 'viser_mobile', true)); ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="address"><?php esc_html_e('Address', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="text" class="form-control form--control" name="address" value="<?php echo esc_attr(get_user_meta($user->ID, 'viser_address', true)); ?>" id="address">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label" for="state"><?php esc_html_e('State', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="text" class="form-control form--control" name="state" value="<?php echo esc_attr(get_user_meta($user->ID, 'viser_state', true)); ?>" id="state">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label class="form-label" for="zip"><?php esc_html_e('Zip Code', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="text" class="form-control form--control" name="zip" value="<?php echo esc_attr(get_user_meta($user->ID, 'viser_zip', true)); ?>" id="zip">
                                </div>

                                <div class="form-group col-sm-4">
                                    <label class="form-label" for="city"><?php esc_html_e('City', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="text" class="form-control form--control" name="city" value="<?php echo esc_attr(get_user_meta($user->ID, 'viser_city', true)); ?>" id="city">
                                </div>

                                <div class="form-group col-sm-4">
                                    <label class="form-label"><?php esc_html_e('Country', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input class="form-control form--control" value="<?php echo esc_attr(get_user_meta($user->ID, 'viser_country', true)); ?>" disabled>
                                </div>
 
                                <div class="col-md-12">
                                    <label class="d-flex justify-content-between flex-wrap form-label"><?php esc_html_e('Telegram Username', VISERLAB_PLUGIN_NAME); ?>
                                        <?php if($telegramConfig->bot_username){  ?> 
                                            <a href="http://t.me/<?php echo esc_attr($telegramConfig->bot_username); ?>" target="_blank" class="text--base">
                                                <?php esc_html_e('Get Telegram Notification', VISERLAB_PLUGIN_NAME); ?>
                                            </a> 
                                        <?php } ?>  
                                    </label>
                                    <input class="form--control form-control" value="<?php echo esc_attr(get_user_meta($user->ID, 'viser_telegram_username', true)); ?>" name="telegram_username">
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn--base btn-primary w-100"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>