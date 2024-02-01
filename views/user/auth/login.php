<?php
define("DONOTCACHEPAGE", true);
viser_layout('user/layouts/app')
?>
<!-- Account Section -->
<div class="account-section pt-60 pb-60">
    <div class="account-wrapper">
        <a href="<?php echo home_url('/'); ?>" class="logo mb-4">
            <img src="<?php echo viser_get_image(viser_file_path('logoIcon').'/dark_logo.png'); ?>" alt="<?php esc_html_e('Logo', VISERLAB_PLUGIN_NAME); ?>">
        </a>
        <form class="account-form verify-gcaptcha" name="loginform" id="loginform" action="<?php echo site_url('wp-login.php', 'login_post'); ?>" method="post">
            <div class="form-group mb-3">
                <label class="form-label" for="log"><?php esc_html_e('Username or Email', VISERLAB_PLUGIN_NAME); ?></label>
                <input class="form-control form--control" type="text" name="log" id="log" value="" required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="pwd"><?php esc_html_e('Password', VISERLAB_PLUGIN_NAME); ?></label>
                <input class="form-control form--control" type="password" name="pwd" id="pwd" value="" required />
            </div>

            <div class="col-lg-12 form-group">
                <?php viser_include('partials/captcha') ?>
            </div>

            <div class="form-group custom--checkbox d-flex justify-content-between flex-wrap">
                <div>
                    <input type="checkbox" name="rememberme" id="rememberme" value="forever" class="form-check-input">
                    <label class="form-check-label" for="rememberme">
                        <?php esc_html_e('Remember Me', VISERLAB_PLUGIN_NAME); ?>
                    </label>
                </div>
                <a href="<?php echo esc_url(home_url('/forgot')); ?>" class="text--base">
                    <?php esc_html_e('Forgot Password?', VISERLAB_PLUGIN_NAME); ?>
                </a>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn--base w-100" name="wp-submit" id="wp-submit" value="<?php esc_html_e('Login', VISERLAB_PLUGIN_NAME); ?>" />
            </div>

            <div class="mt-3 mt-sm-4">
                <div class="text-center">
                    <?php esc_html_e('Don\'t have any account?', VISERLAB_PLUGIN_NAME); ?> 
                    <a href="<?php echo esc_url(viser_route_link('user.register')); ?>" class="text-decoration-underline text--base">
                        <?php esc_html_e('Create Account', VISERLAB_PLUGIN_NAME); ?>    
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Account Section -->