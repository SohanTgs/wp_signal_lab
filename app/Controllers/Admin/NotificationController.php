<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Models\NotificationTemplate;
use Viserlab\Notify\Sms;

class NotificationController extends Controller
{

    public function global()
    {
        $pageTitle = "Global Template for Notification";
        return $this->view('admin/notification/global_template', compact('pageTitle'));
    }

    public function globalUpdate()
    {
        $request = new Request();
        $request->validate([
            'email_from'     => 'required|email',
            'email_template' => 'required',
            'sms_from'       => 'required',
            'sms_body'       => 'required'
        ]);

        update_option('viser_email_from', sanitize_email($request->email_from));
        update_option('viser_email_template', htmlentities(wpautop(($request->email_template))));
        update_option('viser_sms_from', sanitize_text_field($request->sms_from));
        update_option('viser_sms_body', sanitize_textarea_field($request->sms_body));

        $notify[] = ['success', 'Global notification settings updated successfully'];
        viser_back($notify);
    }

    public function emailSetting()
    {
        $pageTitle  = "Email Notification Settings";
        $mailConfig = get_option('viser_mail_config');
        $mailConfig = viser_to_object($mailConfig);
        return $this->view('admin/notification/email_setting', compact('pageTitle', 'mailConfig'));
    }

    public function emailSettingUpdate()
    {
        $request = new Request();
        $request->validate([
            'email_method' => 'required'
        ]);

        if ($request->email_method == 'php') {
            $data['name'] = 'php';
        } else if ($request->email_method == 'smtp') {
            $data['name']     = 'smtp';
            $data['host']     = sanitize_text_field($request->host);
            $data['port']     = sanitize_text_field($request->port);
            $data['enc']      = sanitize_text_field($request->enc);
            $data['username'] = sanitize_text_field($request->username);
            $data['password'] = sanitize_text_field($request->password);
        } else if ($request->email_method == 'sendgrid') {
            $data['name']   = 'sendgrid';
            $data['appkey'] = sanitize_text_field($request->appkey);
        } else if ($request->email_method == 'mailjet') {
            $data['name']       = 'mailjet';
            $data['public_key'] = sanitize_text_field($request->public_key);
            $data['secret_key'] = sanitize_text_field($request->secret_key);
        }

        update_option('viser_mail_config', $data);
        $notify[] = ['success', 'Email settings updated successfully'];
        viser_back($notify);
    }

    public function smsSetting()
    {
        $pageTitle = "SMS Notification Settings";
        $smsConfig = get_option('viser_sms_config');
        $smsConfig = viser_to_object($smsConfig);
        return $this->view('admin/notification/sms_setting', compact('pageTitle', 'smsConfig'));
    }
    
    public function smsSettingUpdate()
    {
        $request = new Request();
        $request->validate([
            'sms_method' => 'required|in:clickatell,infobip,messageBird,nexmo,smsBroadcast,twilio,textMagic'
        ]);

        $data['name'] = sanitize_text_field($request->sms_method);

        if ($request->sms_method == 'clickatell') {

            $data['clickatell']['api_key'] = sanitize_text_field($request->clickatell_api_key);

        } elseif($request->sms_method == 'infobip'){

            $data['infobip'] = [
                'username' => $request->infobip_username,
                'password' => $request->infobip_password,
            ];

        } elseif($request->sms_method == 'messageBird'){
            
            $data['message_bird'] = [
                'api_key' => $request->message_bird_api_key
            ];

        } elseif($request->sms_method == 'nexmo'){
            
            $data['nexmo'] = [
                'api_key'    => $request->nexmo_api_key,
                'api_secret' => $request->nexmo_api_secret,
            ];

        } elseif($request->sms_method == 'smsBroadcast'){
            
            $data['sms_broadcast'] = [
                'username' => $request->sms_broadcast_username,
                'password' => $request->sms_broadcast_password,
            ];

        } elseif($request->sms_method == 'twilio'){
            
            $data['twilio'] = [
                'account_sid' => $request->account_sid,
                'auth_token'  => $request->auth_token,
                'from'        => $request->from,
            ];

        } elseif($request->sms_method == 'textMagic'){
            
            $data['text_magic'] = [
                'username'  => $request->text_magic_username,
                'apiv2_key' => $request->apiv2_key,
            ];
        }

        update_option('viser_sms_config', $data);
        $notify[] = ['success', 'SMS settings updated successfully'];
        viser_back($notify);
    }

    public function templates()
    {
        $pageTitle = "Notification Templates";
        $templates = NotificationTemplate::orderBy('name', 'asc')->get();
        return $this->view('admin/notification/templates', compact('pageTitle', 'templates'));
    }

    public function templateEdit()
    {
        $request  = new Request();
        $template = NotificationTemplate::find($request->id);
        if (!$template) {
            viser_abort(404);
        }
        $pageTitle = $template->name;
        return $this->view('admin/notification/edit', compact('pageTitle', 'template'));
    }

    public function templateUpdate()
    {
        $request = new Request();
        $request->validate([
            'subject'    => 'required',
            'email_body' => 'required',
            'sms_body'   => 'required'
        ]);

        $template                  = NotificationTemplate::find($request->id);
        $template->subj            = sanitize_text_field($request->subject);
        $template->email_body      = balanceTags(wp_kses($request->email_body, viser_allowed_html()));
        $template->email_status    = $request->email_status ? 1 : 0;
        $template->sms_body        = sanitize_textarea_field($request->sms_body);
        $template->sms_status      = $request->sms_status ? 1 : 0;

        $template->telegram_body   = sanitize_textarea_field($request->telegram_body);
        $template->telegram_status = $request->telegram_status ? 1 : 0;
        $template->save();

        $notify[] = ['success', 'Notification template updated successfully'];
        viser_back($notify);
    }

    public function emailTest()
    {
        $request = new Request();
        $request->validate([
            'email' => 'required'
        ]);

        $receiverName = explode('@', $request->email)[0];
        $subject      = __('Email Configuration Success', VISERLAB_PLUGIN_NAME);
        $message      = __('Your email notification setting is configured successfully for ', VISERLAB_PLUGIN_NAME) . get_bloginfo('name');
        $user         = [
            'user_login'   => $request->email,
            'user_email'   => $request->email,
            'display_name' => $receiverName,
        ];

        $user = viser_to_object($user);
        
        viser_notify($user, 'DEFAULT', [
            'subject' => $subject,
            'message' => $message,
        ]);

        $notify[] = ['success', 'Email sent successfully to ' . sanitize_email($request->email)];
        viser_back($notify);
    }

    public function smsTest()
    {
        $request = new Request();
        $request->validate(['mobile' => 'required']);

        if ( get_option('viser_sms_notification')) {

            $sendSms = new Sms;
            $sendSms->mobile = sanitize_text_field($request->mobile);
            $sendSms->receiverName = ' ';
            $sendSms->message = 'Your sms notification setting is configured successfully for ' . get_bloginfo('name');
            $sendSms->subject = ' ';
            $sendSms->send();

        } else {
            $notify[] = ['error', 'Please enable from system configuration'];
            $notify[] = ['error', 'Your sms notification is disabled'];
            viser_back($notify);
        }

        if (viser_session()->has('sms_error')) {
            $notify[] = ['error', viser_session()->get('sms_error')];
        }else{
            $notify[] = ['success', 'SMS sent to ' . $request->mobile . 'successfully'];
        }
        return viser_back($notify);
    }

    public function telegramSetting()
    {   
        $pageTitle  = "Telegram Settings";
        $telegramConfig = get_option('viser_telegram_config');
        $telegramConfig = viser_to_object($telegramConfig);
        return $this->view('admin/notification/telegram_setting', compact('pageTitle', 'telegramConfig'));
    }

    public function telegramSettingUpdate()
    {    
        $request = new Request(); 
        $request->validate([
            'bot_api_token' => 'required',
            'bot_username' => 'required'
        ]);

        $data['bot_api_token'] = sanitize_text_field($request->bot_api_token);
        $data['bot_username'] = sanitize_text_field($request->bot_username);
    
        update_option('viser_telegram_config', $data);

        $notify[] = ['success', 'Telegram settings updated successfully'];
        viser_back($notify);
    }

}
