<?php viser_layout('user/layouts/master'); ?>

<section class="pt-120 pb-100 bg-light">
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="custom--card">
                    <div class="card-header">
                        <h5 class="card-title text-center"><?php echo esc_html($pageTitle); ?></h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo viser_route_link('user.change.password.update'); ?>" method="post">
                            <?php viser_nonce_field('user.change.password.update'); ?>
                            <div class="form-group">
                                <label class="form-label" for="current_password"><?php esc_html_e('Current Password', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="password" class="form-control form--control" name="current_password" autocomplete="current-password" id="current_password" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password"><?php esc_html_e('Password', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="password" class="form-control form--control" name="password" autocomplete="current-password" id="password" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation"><?php esc_html_e('Confirm Password', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="password" class="form-control form--control" name="password_confirmation" autocomplete="current-password" id="password_confirmation" required>
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn--base btn-primary w-100"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>