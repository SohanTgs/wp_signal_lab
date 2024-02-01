<?php

namespace Viserlab\Controllers;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Lib\CurlRequest;
use Viserlab\Lib\VerifiedPlugin;

class ActivationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $current_user = wp_get_current_user();
        if (!user_can( $current_user, 'administrator' )) {
            viser_back();
        }
    }

    public function activate()
    {
        if (VerifiedPlugin::check()) {
            viser_redirect(admin_url('/admin.php?page='.VISERLAB_PLUGIN_NAME));
        }
        $this->view('activation');
    }

    public function activationSubmit()
    {
        $request = new Request;
        $param['code'] = $request->purchase_code;
        $param['url'] = home_url();
        $param['user'] = $request->envato_username;
        $param['email'] = $request->email;
        $param['product'] = viser_system_details()['name'];
        $url = str_rot13('uggcf://yvprafr.ivfreyno.pbz/npgvingr');
        $response = CurlRequest::curlPostContent($url, $param);
        $response = json_decode($response);

        if ($response->error == 'error') {
            wp_send_json(['type'=>'error','message'=>$response->message]);
            die;
        }

        $viser = fopen(VISERLAB_ROOT.'/viser.json', "w");
        $txt = '{
            "installcode":'.'"'.$response->installcode.'",'.'
            "license_type":'.'"'.$response->license_type.'"'.'
        }';
        fwrite($viser, $txt);
        fclose($viser);

        update_option(VISERLAB_PLUGIN_NAME.'_activated',1);
        update_option(VISERLAB_PLUGIN_NAME.'_maintenance_mode',0);

        wp_send_json(['type'=>'success']);
        die;
    }


}