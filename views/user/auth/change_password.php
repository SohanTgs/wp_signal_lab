<form class="account-form" action="<?php echo viser_route_link('user.forget.password'); ?>?action=rp" method="post">
    <div class="mb-4"> 
        <p>
            <?php esc_html_e('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.', VISERLAB_PLUGIN_NAME); ?>
        </p>
    </div>
    <div class="form-group">
        <label class="form-label" for="pass1"><?php esc_html_e('Password', VISERLAB_PLUGIN_NAME) ?></label>
        <input id="pass1" class="form-control form--control" type="password" name="pass1" value="" autocomplete="off" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="pass2"><?php esc_html_e('Confirm Password', VISERLAB_PLUGIN_NAME) ?></label>
        <input id="pass2" class="form-control form--control" type="password" name="pass2" value="" autocomplete="off" required>
    </div>
    <div class="form-group">
        <input id="wp-submit" class="btn btn--base w-100" type="submit" name="wp-submit" value="<?php esc_attr_e('Submit', VISERLAB_PLUGIN_NAME); ?>" />
    </div>
    <input type="hidden" name="user_login" id="user_login" value="<?php echo esc_attr(@$_GET['login'] ? @$_GET['login'] : @$_POST['user_login']); ?>" />
    <input type="hidden" name="action" id="action" value="rp" />
    <input type="hidden" name="nonce" id="nonce" value="<?php echo wp_create_nonce('forgot'); ?>" />
    <div class="mt-3 mt-sm-4">
        <div class="text-center">
            <?php esc_html_e('Login into your', VISERLAB_PLUGIN_NAME); ?>
            <a href="<?php echo esc_url(viser_route_link('user.login')); ?>" class="text-decoration-underline">
                <?php esc_html_e('account', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
</form>