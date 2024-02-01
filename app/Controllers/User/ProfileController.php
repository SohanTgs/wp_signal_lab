<?php

namespace Viserlab\Controllers\User;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;

class ProfileController extends Controller
{
    public function changePassword()
    {
        $pageTitle = 'Change Password';
        $this->pageTitle = $pageTitle;

        $this->view('user/change_password', compact('pageTitle'));
    }

    public function changePasswordUpdate()
    {
        global $user_ID;
        $request = new Request();
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required',
            'password_confirmation' => 'required',
        ]);

        $user = get_userdata($user_ID);

        if (!wp_check_password(sanitize_text_field($request->current_password), $user->user_pass, $user->ID)) {
            $notify[] = ['error', 'Current password doesn\'t match'];
            viser_back($notify);
        }

        if (strlen(sanitize_text_field($request->password)) < 6) {
            $notify[] = ['error', 'Passwords must be at least 6 characters long'];
            viser_back($notify);
        }

        if (sanitize_text_field($request->password) != sanitize_text_field($request->password_confirmation)) {
            $notify[] = ['error', 'Please enter the same password in the two password fields.'];
            viser_back($notify);
        }

        $userData = [
            'ID'        => intval($user->ID),
            'user_pass' => sanitize_text_field($request->password)
        ];

        $user_id = wp_update_user($userData);

        if ($user_id) {
            $notify[] = ['success', 'Password changes successfully'];
            viser_back($notify);
        }

        $notify[] = ['error', 'Something went wrong'];
        viser_back($notify);
    }

    public function profileSetting()
    {
        $pageTitle = 'Profile Setting';
        $this->pageTitle = $pageTitle;

        global $user_ID;
        $user = get_userdata($user_ID);

        $telegramConfig = get_option('viser_telegram_config');
        $telegramConfig = viser_to_object($telegramConfig);

        $this->view('user/profile_setting', compact('user', 'pageTitle', 'telegramConfig'));
    }

    public function profileSettingUpdate()
    {
        global $user_ID;
        $request = new Request();
        $request->validate([
            'display_name' => 'required'
        ]);

        $userData = [
            'ID'           => intval($user_ID),
            'display_name' => sanitize_text_field($request->display_name)
        ];

        $user_id = wp_update_user($userData);

        if ($user_id) {
            update_user_meta($user_id, 'viser_address', sanitize_text_field($request->address));
            update_user_meta($user_id, 'viser_zip', sanitize_text_field($request->zip));
            update_user_meta($user_id, 'viser_city', sanitize_text_field($request->city));
            update_user_meta($user_id, 'viser_state', sanitize_text_field($request->state));
            update_user_meta($user_id, 'viser_telegram_username', sanitize_text_field($request->telegram_username));

            $notify[] = ['success', 'Profile updated successfully'];
            viser_back($notify);
        }

        $notify[] = ['error', 'Something went wrong'];
        viser_back($notify);
    }
}
