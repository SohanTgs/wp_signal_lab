<?php

namespace Viserlab\Controllers\User\Auth;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use PasswordHash;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {   $this->pageTitle = 'Account Recovery';
        $this->checkFallback();
        $this->view('user/auth/forgot');
    }

    private function checkFallBack()
    {
        $request = new Request();
        $this->checkResetKey();
        if (isset($request->action) && $request->action == 'pwreset') {
            $this->retrievePassword();
        }
    }

    private function checkResetKey()
    {
        $request = new Request();
        if (isset($request->action) && $request->action == 'rp' && @$_POST['action'] != 'rp') {
            $user = check_password_reset_key($request->key, $request->login);
            if (is_wp_error($user)) {
                $notify[] = ['error', 'Sorry, that key does not appear to be valid.'];
                viser_redirect(viser_route_link('user.forget.password'),$notify);
            }
        }
    }

    private function retrievePassword()
    {
        global $wpdb, $wp_hasher;
        $request = new Request();
        $notify  = [];
        if (empty($request->user_login)) {
            $notify[] = ['error', 'Enter a username or e-mail address.'];
            viser_back($notify);
        } else if (strpos($request->user_login, '@')) {
            $user_data = get_user_by('email', sanitize_email($request->user_login));
            if (empty($user_data)) {
                $notify[] = ['error', 'There is no user registered with that email address.'];
                viser_back($notify);
            }
        } else {
            $login     = sanitize_user($request->user_login);
            $user_data = get_user_by('login', $login);
        }

        if (!$user_data) {
            $notify[] = ['error', 'Invalid username or e-mail.'];
            viser_back($notify);
        }
        $user_login = $user_data->user_login;
        $key = wp_generate_password(20, false);
        if (empty($wp_hasher)) {
            require_once ABSPATH . WPINC . '/class-phpass.php';
            $wp_hasher = new PasswordHash(8, true);
        }
        $hashed = time() . ':' . $wp_hasher->HashPassword($key);
        $wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));

        $verify_link = viser_route_link('user.forget.password') . "?action=rp&key=$key&login=" . rawurlencode($user_login);

        viser_notify($user_data, 'PASSWORD_RESET', [
            'verify_link' => esc_url( $verify_link )
        ]);

        $notify[] = ['success', 'Check your e-mail for the confirmation link.'];
        viser_back($notify);
    }
}
