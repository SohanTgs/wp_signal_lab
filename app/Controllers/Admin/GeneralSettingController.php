<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Intervention\Image\ImageManager as Image;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $pageTitle = "General Setting";
        $this->view('admin/setting/index', compact('pageTitle'));
    }

    public function store()
    {   
        $request = new Request();
        $request->validate([
            'viser_cur_text' => 'required',
            'viser_cur_sym' => 'required',
            'viser_user_panel_prefix' => 'required',
        ]);
        
        update_option('viser_cur_text', sanitize_text_field($request->viser_cur_text));
        update_option('viser_cur_sym', sanitize_text_field($request->viser_cur_sym));
        update_option('viser_user_panel_prefix', sanitize_text_field($request->viser_user_panel_prefix));

        $notify[] = ['success', 'General setting updated successfully'];
        viser_back($notify);
    }

    public function systemConfiguration()
    {
        $pageTitle = "System Configuration";
        return $this->view('admin/setting/configuration', compact('pageTitle'));
    }

    public function systemConfigurationStore()
    {
        $request = viser_request();


        update_option('viser_agree', $request->viser_agree ? 1 : 0);
        update_option('viser_email_notification', $request->viser_email_notification ? 1 : 0);
        update_option('viser_sms_notification', $request->viser_sms_notification ? 1 : 0);

        $notify[] = ['success', 'System configuration update successfully'];
        viser_back($notify);
    }

    public function logoIcon()
    {
        $pageTitle = 'Logo & Favicon';
        $this->view('admin/setting/logo_icon', compact('pageTitle'));
    }

    public function logoIconSubmit()
    {   
        $request = new Request();
        $request->validate([
            'logo' => 'image|mimes:jpg,jpeg,png',
            'dark_logo' => 'image|mimes:jpg,jpeg,png',
            'favicon' => 'image|mimes:png',
        ]);

        $path = VISERLAB_ROOT . 'assets/images/logoIcon';
        $image = new Image();

        if ($request->hasFile('logo')) {
            try {
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $image->make($request->logo['tmp_name'])->save($path . '/logo.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                viser_back($notify);
            }
        }

        if ($request->hasFile('dark_logo')) {
            try {
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $image->make($request->dark_logo['tmp_name'])->save($path . '/dark_logo.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the dark logo'];
                viser_back($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $size = explode('x', viser_file_size('favicon'));
                $image->make($request->favicon['tmp_name'])->resize($size[0], $size[1])->save($path . '/favicon.png');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the favicon'];
                viser_back($notify);
            }
        }

        $notify[] = ['success', 'Logo & favicon updated successfully'];
        viser_back($notify);
    }
}
