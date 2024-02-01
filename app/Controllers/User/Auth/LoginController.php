<?php

namespace Viserlab\Controllers\User\Auth;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;

class LoginController extends Controller
{

    public function login()
    {
        $request = new Request();
        if (isset($request->action) && $request->action == 'logout') {
            $this->logout();
        }
        $this->showNotify(); 
        $this->pageTitle = 'Login';

        return $this->view('user/auth/login');
    }

    public function logout()
    {
        wp_logout();
        wp_safe_redirect(viser_route_link('user.login') . '?action=loggedout');
        exit();
    }

    private function showNotify()
    {
        $request = new Request();
        $notify = [];

        if (isset($request->login) && $request->login == 'failed') {
            $notify[] = ['error', 'Incorrect Email / Username / Password'];
        } elseif (isset($request->action) && $request->action == 'loggedout') {
            $notify[] = ['success', 'Logged Out Successfully'];
        }

        if (isset($request->pw) && $request->pw == 'reset') {
            $notify[] = ['success', 'Your password has been reset.'];
        }

        if (isset($request->registration) && $request->registration == 'disabled') {
            $notify[] = ['error', 'User registration is currently closed.'];
        }

        if (isset($request->registration) && $request->registration == 'done') {
            $notify[] = ['success', 'To activate account, please check your email for verification link.'];
        }

        if (isset($request->captcha) && $request->captcha == 'failed') {
            $notify[] = ['error', 'Invalid captcha.'];
        }

        if (isset($request->email) && $request->email == 'unverified') {

            $notify[] = ['error', 'Account not activated yet. Please check your email for verification link.'];

        } elseif (isset($request->email) && $request->email == 'verify') {

            $user = get_user_by('login', sanitize_user($request->login));
            $key  = get_user_meta(@$user->ID, '_Verify Email', true);
            if ($key == $request->key) {
                delete_user_meta($user->ID, '_Verify Email', $key);
                $notify[] = ['success', 'Verification success. You may login now.'];
            } else {
                $notify[] = ['error', 'Invalid verification key.'];
            }
        }

        viser_set_notify($notify);
    }
}
