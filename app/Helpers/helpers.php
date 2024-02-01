<?php

use Viserlab\BackOffice\Abort;
use Viserlab\BackOffice\Facade\DB;
use Viserlab\BackOffice\Facade\Session as FacadeSession;
use Viserlab\Lib\FileManager;
use Viserlab\BackOffice\Request;
use Viserlab\BackOffice\Session;
use Viserlab\BackOffice\System;
use Viserlab\Lib\Captcha;
use Viserlab\Lib\ClientInfo;
use Viserlab\Lib\ViserDate;
use Viserlab\Models\Deposit;
use Viserlab\Models\Package;
use Viserlab\Models\Form;
use Viserlab\Models\Gateway;
use Viserlab\Models\Signal;
use Viserlab\Models\GatewayCurrency;
use Viserlab\Models\SupportAttachment;
use Viserlab\Models\SupportTicket;
use Viserlab\Notify\Notify;

if (!function_exists('viser_system_details')) {
    function viser_system_details()
    {
        $system['prefix'] = 'wp_';
        $system['real_name'] = 'viserlab';
        $system['name'] = $system['prefix'].'viserlab';
        $system['version'] = '1.0';
        $system['build_version'] = '1.1.3';
        return $system;
    }
}

if (!function_exists('viser_system_instance')) {
    function viser_system_instance()
    {
        return System::getInstance();
    }
}

if (!function_exists('dd')) {
    function dd(...$data)
    {
        foreach ($data as $item) {
            echo "<pre style='background: #001140;color: #00ff4e;padding: 20px;'>";
            print_r($item);
            echo "</pre>";
        }
        exit;
    }
}

if (!function_exists('dump')) {
    function dump(...$data)
    {
        foreach ($data as $item) {
            echo "<pre style='background: #001140;color: #00ff4e;padding: 20px;'>";
            print_r($item);
            echo "</pre>";
        }
    }
}

if (!function_exists('viser_layout')) {
    function viser_layout($viser_layout)
    {
        global $systemLayout;
        $systemLayout = $viser_layout;
    }
}

if (!function_exists('viser_route')) {
    function viser_route($routeName)
    {
        $route = viser_system_instance()->route($routeName);
        return viser_to_object($route);
    }
}

if (!function_exists('viser_to_object')) {
    function viser_to_object($args)
    {
        if (is_array($args)) {
            return (object) array_map(__FUNCTION__, $args);
        } else {
            return $args;
        }
    }
}

if (!function_exists('viser_to_array')) {
    function viser_to_array($args)
    {
        if (is_object($args)) {
            $args = get_object_vars($args);
        }

        if (is_array($args)) {
            return array_map(__FUNCTION__, $args);
        } else {
            return $args;
        }
    }
}


if (!function_exists('viser_redirect')) {
    function viser_redirect($url,$notify = null)
    {
        if ($notify) {
            viser_set_notify($notify);
        }
        wp_redirect($url);
        exit;
    }
}

if (!function_exists('viser_key_to_title')) {
    function viser_key_to_title($text)
    {
        return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
    }
}

if (!function_exists('viser_request')) {
    function viser_request()
    {
        return new Request();
    }
}

if (!function_exists('viser_session')) {
    function viser_session()
    {
        return new Session();
    }
}

if (!function_exists('viser_back')) {
    function viser_back($notify = null)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = home_url();
        }
        viser_redirect($url,$notify);
    }
}

if (!function_exists('viser_old')) {
    function viser_old($key)
    {
        return FacadeSession::get('old_input_value_' . $key);
    }
}

if (!function_exists('viser_abort')) {
    function viser_abort($code = 404, $message = null)
    {
        $abort = new Abort($code,$message);
        $abort->abort();
    }
}

if (!function_exists('viser_query_to_url')) {
    function viser_query_to_url($arr)
    {
        return esc_url(add_query_arg($arr, $_SERVER['REQUEST_URI']));
    }
}

if (!function_exists('viser_set_notify')) {
    function viser_set_notify($data)
    {
        FacadeSession::flash('notify', $data);
    }
}

if (!function_exists('viser_include')) {
    function viser_include($view, $data = [])
    {
        extract($data);
        include VISERLAB_ROOT . 'views/' . $view . '.php';
    }
}

if (!function_exists('viser_ip_info')) {
    function viser_ip_info()
    {
        $ipInfo = ClientInfo::ipInfo();
        return $ipInfo;
    }
}

if (!function_exists('viser_real_ip')) {
    function viser_real_ip()
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        //Deep detect ip
        if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        }
        if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }
}

if (!function_exists('viser_route_link')) {
    function viser_route_link($name,$format = true)
    {
        $route = viser_to_array(viser_route($name));
        if (array_key_exists('query_string',$route)) {
            $link = menu_page_url(VISERLAB_PLUGIN_NAME,false).'&module='.$route['query_string'];
        }else{
            $link = home_url( $route['uri'] );
        }
        if ($format) {
            return esc_url($link);
        }
        return $link;
    }
}

if (!function_exists('viser_menu_active')) {
    function viser_menu_active($routeName, $type = null, $param = null,$dashboard = false)
    {
        if ($type == 3) $class = 'side-menu--open';
        elseif ($type == 2) $class = 'sidebar-submenu__open';
        else $class = 'active';
        if (!is_array($routeName)) {
            $routeName = [$routeName];
        }
        foreach ($routeName as $key => $value) {
            $route = viser_route($value);
            $queryString = $route->query_string;
            $uri = @$route->uri;
            if ($queryString) {
                if (isset(viser_request()->module) && viser_request()->module == $queryString){
                    echo sanitize_html_class($class);
                }
                if (isset(viser_request()->page) && viser_request()->page == VISERLAB_PLUGIN_NAME && !isset(viser_request()->module) && $dashboard) {
                    echo sanitize_html_class($class);
                }
            }else{
                $currentUri = get_query_var('viser_page');
                if ($currentUri == $uri) {
                    echo sanitize_html_class($class);
                }
            }
        }
    }
}

if (!function_exists('viser_nonce_field')) {
    function viser_nonce_field($routeName, $isPrint = true)
    {
        $nonce = viser_nonce($routeName);
        if ($isPrint) {
            echo '<input type="hidden" name="nonce" value="' . $nonce . '">';
        } else {
            return '<input type="hidden" name="nonce" value="' . $nonce . '">';
        }
    }
}


if (!function_exists('viser_nonce')) {
    function viser_nonce($routeName)
    {
        $route = viser_to_array(viser_route($routeName));
        if (array_key_exists('query_string', $route)) {
            $nonceName = $route['query_string'];
        } else {
            $nonceName = $route['uri'];
        }
        return wp_create_nonce($nonceName);
    }
}

if (!function_exists('viser_current_route')) {
    function viser_current_route(){
        if (isset(viser_request()->page)) {
            if (isset(viser_request()->module)) {
                return viser_request()->module;
            }else{
                return viser_request()->page;
            }
        }else{
            return home_url(get_query_var('viser_page'));
        }
    }
}

if (!function_exists('viser_assets')) {
    function viser_assets($path)
    {
        $path = VISERLAB_PLUGIN_NAME . '/assets/' . $path;
        $path = str_replace('//', '/', $path);
        return plugins_url($path);
    }
}

if (!function_exists('viser_get_image')) {
    function viser_get_image($image)
    {
        $checkPath = str_replace(plugin_dir_url(dirname(dirname(__FILE__))),plugin_dir_path(dirname(dirname(__FILE__))),$image);
        if (file_exists($checkPath) && is_file($checkPath)) {
            return $image;
        }
        return viser_assets('images/default.png');
    }
}

if (!function_exists('viser_file_uploader')) {
    function viser_file_uploader($file, $location, $size = null, $old = null, $thumb = null)
    {
        $fileManager = new FileManager($file);
        $fileManager->path = $location;
        $fileManager->size = $size;
        $fileManager->old = $old;
        $fileManager->thumb = $thumb;
        $fileManager->upload();
        return $fileManager->filename;
    }
}

if (!function_exists('viser_file_manager')) {
    function viser_file_manager()
    {
        return new FileManager();
    }
}


if (!function_exists('viser_file_path')) {
    function viser_file_path($key)
    {
        $dir = plugin_dir_url(dirname(dirname(__FILE__)));
        if (!empty($_FILES)) {
            $dir = plugin_dir_path(dirname(dirname(__FILE__)));
        }
        return $dir . 'assets/' . viser_file_manager()->$key()->path;
    }
}

if (!function_exists('viser_file_size')) {
    function viser_file_size($key)
    {
        return viser_file_manager()->$key()->size;
    }
}

if (!function_exists('viser_file_ext')) {
    function viser_file_ext($key)
    {
        return viser_file_manager()->$key()->extensions;
    }
}

if (!function_exists('viser_push_breadcrumb')) {
    function viser_push_breadcrumb($html)
    {
        add_action('viser_breadcrumb_plugins',function () use ($html){
            echo $html;
        });
    }
}

if (!function_exists('viser_check_empty')) {
    function viser_check_empty($data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        return empty($data);
    }
}

if (!function_exists('viser_gateway_currency_count')) {
    function viser_gateway_currency_count($code)
    {
        $result = GatewayCurrency::where('method_code', $code)->count();
        return $result;
    }
}

if(!function_exists('viser_allowed_html')){
    function viser_allowed_html() {
        $arr = array(
            'span' => array(
                'class' => []
            ),
            'br' => [],
            'a' => array(
                'href' => true,
                'class' => [],  
            ),
            'em' => array(),
            'b' => array(),
            'bold' => array(),
            'blockquote' => array(),
            'p' => array(),
            'li' => array(
                'class' => [],
                'id' => []
            ),
            'ol' => array(),
            'strong' => array(),
            'ul' => array(
                'id' => [],
                'class' => [],1
            ),
            'div' => array(
                'id' => [],
                'class' => [],1
            ),
            'img' => array(
                'src' => true
            ),
            'table' => [],
            'tr' => [],
            'td' => [],
            'i' => array(
                'class' => []
            )
        );
        return $arr;
    }
}

if (!function_exists('viser_currency')) {
    function viser_currency($type = 'text')
    {
        return get_option("viser_cur_$type");
    }
}

if (!function_exists('viser_get_amount')) {
    function viser_get_amount($amount, $length = 2)
    {
        $amount = round($amount, $length);
        return $amount + 0;
    }
}

if (!function_exists('viser_show_amount')) {
    function viser_show_amount($amount, $decimal = 2, $separate = true, $exceptZeros = false)
    {
        $separator = '';
        if ($separate) {
            $separator = ',';
        }
        $printAmount = number_format($amount, $decimal, '.', $separator);
        if ($exceptZeros) {
            $exp = explode('.', $printAmount);
            if ($exp[1] * 1 == 0) {
                $printAmount = $exp[0];
            } else {
                $printAmount = rtrim($printAmount, '0');
            }
        }
        return $printAmount;
    }
}

if (!function_exists('viser_global_notify_short_codes')) {
    function viser_global_notify_short_codes()
    {
        $data['site_name'] = 'Name of your site';
        $data['site_currency'] = 'Currency of your site';
        $data['currency_symbol'] = 'Symbol of currency';
        return $data;
    }
}

if (!function_exists('viser_gateway')) {
    function viser_gateway($code)
    {
        $result = Gateway::where('code', $code)->first();
        return $result;
    }
}

if (!function_exists('viser_package')) {
    function viser_package($id)
    {
        $result = Package::where('id', $id)->first();
        return $result;
    }
}

if (!function_exists('viser_signal')) {
    function viser_signal($id)
    {
        $result = Signal::where('id', $id)->first();
        return $result;
    }
}

if (!function_exists('viser_show_date_time')) {
    function viser_show_date_time($date, $format = 'Y-m-d h:i A')
    {   if(!$date){
            return false;
        }
        return viser_date()->parse($date)->toDateTime($format);
    }
}

if (!function_exists('sendVia')) {
    function sendVia($implode = false){
        $via = ['Email', 'SMS', 'Telegram'];
        if($implode){
            $via = strtolower(implode(',', $via));
        }
        return $via;
    }
}

if (!function_exists('viser_diff_for_humans')) {
    function viser_diff_for_humans($date, $to = '')
    {
        if (empty($to)) {
            $to = current_time('timestamp');
        }
        $from = strtotime($date);
        return human_time_diff($from, $to) . " ago";
    }
}

if (!function_exists('viser_notify')) {
    function viser_notify($user, $templateName, $shortCodes = null, $sendVia = null, $createLog = true)
    {
        if(!$sendVia){
            $sendVia = ['email', 'sms'];
        }

        $globalShortCodes = [
            'site_name' => get_bloginfo('name'),
            'site_currency' => viser_currency('text'),
            'currency_symbol' => viser_currency('sym'),
        ];

        if (gettype($user) == 'array') {
            $user = (object) $user;
        }

        $userInfo = [
            'email' => $user->user_email,
            'fullname' => $user->display_name,
            'username' => $user->user_login,
            'telegram_username' => get_user_meta($user->ID, 'viser_telegram_username', true),
            'mobile' => get_user_meta($user->ID, 'viser_mobile', true),
        ];

        $userInfo = viser_to_object($userInfo);

        $shortCodes = array_merge($shortCodes ?? [], $globalShortCodes);
        $notify = new Notify($sendVia);
        $notify->templateName = $templateName;
        $notify->shortCodes = $shortCodes;
        $notify->user = $userInfo;
        $notify->createLog = $createLog;
        $notify->send();
    }
}

if (!function_exists('after_login_redirect')) {
    function after_login_redirect( $user_login, $user ) {
        add_filter('login_redirect', function() use ($user) {

            $redirect = admin_url();

            if (!in_array('administrator', $user->roles)) {
                $redirect = viser_route_link('user.home');
            }

            return $redirect;
        });
    }
}

if (!function_exists('viser_auth')) {
    function viser_auth()
    {
        include_once(ABSPATH . 'wp-includes/pluggable.php');
        if (is_user_logged_in()) {
            return (object)[
                'user' => wp_get_current_user(),
                'meta' => get_user_meta(wp_get_current_user()->ID)
            ];
        }
        return false;
    }
}

if (!function_exists('viser_trx')) {
    function viser_trx($length = 12)
    {
        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('viser_asset')) {
    function viser_asset($path)
    {
        $path = VISERLAB_PLUGIN_NAME . '/assets/' . $path;
        $path = str_replace('//', '/', $path);
        return plugins_url($path);
    }
}

if (!function_exists('viser_balance')) {
    function viser_balance($userId)
    {
        $balance = get_user_meta($userId, 'viser_balance', true);
        if ($balance > 0) {
            return viser_get_amount($balance);
        } else {
            return 0;
        }
    }
}

if (!function_exists('viser_get_form')) {
    function viser_get_form($formId)
    {
        $form = Form::find( $formId );
        $formData = [];
        if ($form) {
            $formData = maybe_unserialize($form->form_data);
        }
        extract($formData);
        include VISERLAB_ROOT . 'views/form/form.php';
    }
}

if (!function_exists('viser_title_to_key')) {
    function viser_title_to_key($text)
    {
        return strtolower(str_replace(' ', '_', $text));
    }
}

if (!function_exists('viser_encrypt')) {
    function viser_encrypt($string)
    {
        return base64_encode($string);
    }
}

if (!function_exists('viser_decrypt')) {
    function viser_decrypt($string)
    {
        return base64_decode($string);
    }
}

if (!function_exists('viser_crypto_qr')) {
    function viser_crypto_qr($wallet)
    {
        return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8";
    }
}

if (!function_exists('viser_support_ticket')) {
    function viser_support_ticket($id){
        $ticket = SupportTicket::find( $id );
        return $ticket;
    }
}

if (!function_exists('viser_support_ticket_attachments')) {
    function viser_support_ticket_attachments($id){
        $attachments = SupportAttachment::where('support_message_id', $id)->get();
        return $attachments;
    }
}

if (!function_exists('viser_gateway_base_symbol')) {
    function viser_gateway_base_symbol($gatewayCurrency, $gateway)
    {
        return $gateway->crypto == 1 ? '$' : $gatewayCurrency->symbol;
    }
}

if (!function_exists('viser_paginate')) {
    function viser_paginate($num = 20)
    {
        return intval($num);
    }
}

if (!function_exists('pending_deposit_count')) {
    function pending_deposit_count()
    {
        $result = Deposit::where('status', 2)->count();
        return intval($result);
    }
}

if (!function_exists('pending_ticket_count')) {
    function pending_ticket_count()
    {
        $result = SupportTicket::where('status', 2)->count();
        return intval($result);
    }
}

if (!function_exists('viser_date')) {
    function viser_date()
    {
        return new ViserDate();
    }
}

if (!function_exists('viser_re_captcha')) {
    function viser_re_captcha()
    {
        return Captcha::reCaptcha();
    }
}

if (!function_exists('viser_custom_captcha')) {
    function viser_custom_captcha($width = '100%', $height = 46, $bgColor = '#003')
    {
        return Captcha::customCaptcha($width, $height, $bgColor);
    }
}

if (!function_exists('viser_verify_captcha')) {
    function viser_verify_captcha()
    {
        return Captcha::verify();
    }
}

if (!function_exists('viser_str_limit')) {
    function viser_str_limit($str, $length = 100, $end = '...')
    {

        if (mb_strwidth($str, 'UTF-8') <= $length) {
            return $str;
        }

        return rtrim(mb_strimwidth($str, 0, $length, '', 'UTF-8')).$end;
    }
}

if (!function_exists('viser_db_prefix')) {
    function viser_db_prefix()
    {
        return DB::tablePrefix();
    }
}

if (!function_exists('viser_db_wpdb')) {
    function viser_db_wpdb()
    {
        return DB::wpdb();
    }
}

if (!function_exists('viser_active_user')) {
    function viser_active_user($userId)
    {
        $active = get_user_meta($userId, 'viser_ban');
        if ($active == 0) {
            return false;
        }
        return 1;

    } 
}