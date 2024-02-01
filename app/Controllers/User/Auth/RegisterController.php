<?php

namespace Viserlab\Controllers\User\Auth;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $this->pageTitle = 'Register';
        $info       = json_decode(json_encode(viser_ip_info()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(VISERLAB_ROOT . 'views/partials/country.json'));
        $this->registrationAction();
        $this->view('user/auth/register', compact('countries', 'mobileCode'));
    }

    public function registrationAction()
    {
        if (isset(viser_request()->action) && viser_request()->action == 'resend') {
            $this->emailResend();
        } else {
            $this->registerUser();
        }
    }

    private function emailResend()
    {
        $http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
        $request   = new Request();

        if ($http_post) {
            $request->validate([
                'user_email' => 'required'
            ]);

            if (username_exists($request->user_email)) {
                $user = get_user_by('login', sanitize_user($request->user_email));
            } elseif (email_exists($request->user_email)) {
                $user = get_user_by('email', sanitize_email($request->user_email));
            }

            if (empty($user)) {
                $notify[] = ['error', 'Email or Username not found'];
                viser_back($notify);
            }
            $verify_email = get_user_meta($user->ID, '_Verify Email', true);
            if (!$verify_email) {
                $notify[] = ['success', 'Account is already activated.'];
                viser_back($notify);
            }

            $verify_link = sprintf('%s?email=verify&login=%s&key=%s', viser_route_link('user.login'), rawurlencode($user->user_login), $verify_email);

            viser_notify($user, 'REGISTER', [
                'verify_link' => esc_url($verify_link)
            ]);

            $notify[] = ['success', 'Please check your email for activation.'];
            viser_back($notify);
        }
    }


    private function registerUser()
    {
        $http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
        $request   = new Request();
        if ($http_post) {
            $request->validate([
                'username' => 'required|min:6',
                'email'    => 'required|email',
                'password' => 'required|confirmed|min:6',
                'country'  => 'required',
                'mobile'   => 'required|integer'
            ]);

            if(!viser_verify_captcha()){
                $notify[] = ['error','Invalid captcha provided'];
                viser_back($notify);
            }

            $this->verifyUser();

            $user_login = sanitize_text_field($request->username);
            $user_email = sanitize_email($request->email);
            $pass1      = sanitize_text_field($request->password);

            $sanitized_user_login = sanitize_user($user_login);

            $user_pass = trim($pass1);
            $user_id   = wp_create_user($sanitized_user_login, $user_pass, $user_email);

            if (!$user_id || is_wp_error($user_id)) {
                $notify[] = ['error', 'Couldn&#8217;t register you&hellip; please contact the Admin'];
                viser_back($notify);
            }

            update_user_meta($user_id, 'viser_mobile', $request->mobile_code . $request->mobile);
            update_user_meta($user_id, 'viser_country', $request->country);
            update_user_meta($user_id, 'viser_country_code', $request->country_code);

            update_user_meta($user_id, 'viser_balance', 0);

            $verify_email = wp_generate_password(20, false);

            update_user_meta($user_id, '_Verify Email', $verify_email);

            $user = get_userdata($user_id);

            $verify_link = sprintf('%s?email=verify&login=%s&key=%s', viser_route_link('user.login'), rawurlencode($sanitized_user_login), $verify_email);

            viser_notify($user, 'REGISTER', [
                'verify_link' => $verify_link
            ]);

            $redirect_to = home_url('/login/?registration=done');
            wp_safe_redirect($redirect_to);
            exit();
        }
    }

    private function verifyUser()
    {

        $request              = new Request();
        $user_login           = sanitize_text_field($request->username);
        $user_email           = sanitize_email($request->email);
        $sanitized_user_login = sanitize_user($user_login);

        if (!validate_username($user_login)) {
            $notify[] = ['error', 'This username is invalid because it uses illegal characters. Please enter a valid username.'];
            viser_back($notify);
        } elseif (username_exists($sanitized_user_login)) {
            $notify[] = ['error', 'This username is already registered. Please choose another one.'];
            viser_back($notify);
        }

        if (email_exists($user_email)) {
            $notify[] = ['error', 'This email is already registered, please choose another one.'];
            viser_back($notify);
        }
    }
}
