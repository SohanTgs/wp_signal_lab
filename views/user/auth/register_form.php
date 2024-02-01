<a href="<?php echo home_url('/'); ?>" class="logo mb-4">
    <img src="<?php echo viser_get_image(viser_file_path('logoIcon').'/dark_logo.png'); ?>" alt="<?php esc_html_e('Logo', VISERLAB_PLUGIN_NAME); ?>">
</a>
<form class="account-form verify-gcaptcha" action="<?php echo esc_url(viser_route_link('user.register')); ?>" method="post">
    <?php viser_nonce_field('user.register');?>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label" for="username"><?php esc_html_e('Username', VISERLAB_PLUGIN_NAME); ?></label>
                <input class="form-control" type="text" name="username" id="username" value="" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label" for="email"><?php esc_html_e('E-Mail Address', VISERLAB_PLUGIN_NAME); ?></label>
                <input class="form-control" type="email" name="email" id="email" value="" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label"><?php esc_html_e('Country', VISERLAB_PLUGIN_NAME); ?></label>
                <select name="country" class="form--control form-select">
                    <?php foreach ($countries as $key => $country) { ?>
                        <option data-mobile_code="<?php echo esc_attr($country->dial_code); ?>" value="<?php echo esc_attr($country->country); ?>" data-code="<?php echo esc_attr($key); ?>">
                            <?php echo esc_html($country->country); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label"><?php esc_html_e('Mobile', VISERLAB_PLUGIN_NAME); ?></label>
                <div class="input-group ">
                    <span class="input-group-text mobile-code bg--base border-0 text-white"></span>
                    </span>
                    <input type="hidden" name="mobile_code">
                    <input type="hidden" name="country_code">
                    <input type="number" name="mobile" value="" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3">
                <label class="form-label" for="password"><?php esc_html_e('Password', VISERLAB_PLUGIN_NAME) ?></label>
                <input class="form-control" type="password" name="password" id="password" size="20" value="" autocomplete="off" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label" for="password_confirmation"><?php esc_html_e('Confirm Password', VISERLAB_PLUGIN_NAME) ?></label>
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" size="20" value="" autocomplete="off" required>
            </div>
        </div>

        <div class="col-lg-12 form-group">
            <?php viser_include('partials/captcha') ?>
        </div>

        <div class="col-sm-12">
            <input class="btn btn--base w-100" type="submit" value="<?php esc_html_e('Register', VISERLAB_PLUGIN_NAME); ?>">
        </div>
    </div>
    <div class="mt-3 mt-sm-4">
        <div class="text-center">
            <?php esc_html_e('Already you have an account?', VISERLAB_PLUGIN_NAME); ?> 
            <a href="<?php echo esc_url( viser_route_link('user.login') );?>?redirect_to=/" class="text--base"><?php esc_html_e('Login Here', VISERLAB_PLUGIN_NAME); ?>
        </div>
    </div>
</form>

<script>
jQuery(document).ready(function($) {
    "use strict";
    <?php if ($mobileCode) { ?>
        $(`option[data-code=<?php echo esc_attr($mobileCode); ?>]`).attr('selected', '');
    <?php } ?>
    $('select[name=country]').on('change', function() {
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
    });
    $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
    $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
    $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
});
</script>