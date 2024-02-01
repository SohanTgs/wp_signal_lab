<form class="account-form" action="<?php echo viser_route_link('user.forget.password'); ?>" method="post">
    <div class="mb-4"> 
        <p><?php esc_html_e('Please provide your email username to find your account.', VISERLAB_PLUGIN_NAME); ?></p>
    </div>
    <div class="form-group">
        <label class="form-label" for="user_login"><?php esc_html_e('Email or Username', VISERLAB_PLUGIN_NAME); ?></label>
        <input class="form-control form--control" type="text" name="user_login" id="user_login" value="" required>
        <input type="hidden" name="action" value="pwreset" />
        <input type="hidden" name="nonce" id="nonce" value="<?php echo wp_create_nonce('forgot'); ?>" />
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn--base w-100 mt-2" name="wp-submit" id="wp-submit" value="<?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?>" />
    </div>
    <div class="mt-3 mt-sm-4">
        <p class="mt-3"><?php esc_html_e('You will receive a link to create a new password via email.', VISERLAB_PLUGIN_NAME); ?></p>
        <div class="">
            <?php esc_html_e('Login into your', VISERLAB_PLUGIN_NAME); ?>
            <a href="<?php echo esc_url(viser_route_link('user.register')); ?>" class="text-decoration-underline">
                <?php esc_html_e('account', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
</form>