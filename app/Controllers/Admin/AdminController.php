<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request as BackOfficeRequest;
use Viserlab\Controllers\Controller;
use Viserlab\Lib\CurlRequest;
use Viserlab\Models\Deposit;
use Viserlab\Models\Package;
use Viserlab\Models\Signal;
use Viserlab\Models\Transaction;
class AdminController extends Controller{

    public function dashboard()
    {
        global $wpdb;
        $pageTitle = 'Dashboard';

        $deposit['total'] = Deposit::where('status',1)->sum('amount');
        $deposit['pending'] = Deposit::where('status', 2)->count();
        $deposit['rejected'] = Deposit::where('status', 3)->count();
        $deposit['charge'] = Deposit::where('status',1)->sum('charge');

        $totalPackage = Package::where('status',1)->count();

        $signalStatistics['total'] = Signal::count();
        $signalStatistics['sent'] = Signal::where('send', 1)->count();
        $signalStatistics['notSent'] = Signal::where('send', 0)->count();

        $table_prefix = $wpdb->base_prefix;
        $date = viser_date()->subDays(30)->toDate();
        $plusTrx = Transaction::selectRaw("select SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date from `" . $table_prefix . "viser_transactions` where `trx_type` = '+' and `created_at` >= '" . $date . "' group by `date` order by `created_at` asc");
        $minusTrx = Transaction::selectRaw("select SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date from `" . $table_prefix . "viser_transactions` where `trx_type` = '-' and `created_at` >= '" . $date . "' group by `date` order by `created_at` asc");
        $this->view('admin/dashboard', compact('pageTitle', 'deposit', 'plusTrx', 'minusTrx', 'totalPackage', 'signalStatistics'));
    }

    public function requestReport()
    {
        $pageTitle = 'Your Listed Report & Request';
        $arr['app_name'] = viser_system_details()['name'];
        $arr['app_url'] = home_url();
        $arr['purchase_code'] = get_option('viser_purchase_code','VISERLAB');
        $url = "https://license.viserlab.com/issue/get?".http_build_query($arr);
        $response = CurlRequest::curlContent($url);
        $response = json_decode($response);
        if ($response->status == 'error') {
            $notify[] = ['error','Something went wrong'];
            viser_redirect(menu_page_url('viserlab',false),$notify);
        }
        $reports = $response->message[0];
        $this->view('admin/reports',compact('pageTitle','reports'));
    }

    public function requestReportSubmit()
    {
        $request = new BackOfficeRequest;
        $request->validate([
            'type'=>'required|in:bug,feature',
            'message'=>'required'
        ]);

        $url = 'https://license.viserlab.com/issue/add';
        $arr['app_name'] = viser_system_details()['name'];
        $arr['app_url'] = home_url();
        $arr['purchase_code'] = get_option('viser_purchase_code',VISERLAB_PLUGIN_NAME);
        $arr['req_type'] = $request->type;
        $arr['message'] = $request->message;
        $response = CurlRequest::curlPostContent($url,$arr);
        $response = json_decode($response);
        if ($response->status == 'error') {
            $notify[] = ['error','Something went wrong'];
            viser_back($notify);
        }
        $notify[] = ['success', $response->message];
        viser_back($notify);
    }

    public function download()
    {
        $file = viser_request()->file_path;
        $file = viser_decrypt($file);
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $title     = viser_title_to_key(get_bloginfo('name')) . '_attachments.' . $extension;
        $mimetype  = mime_content_type($file);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        ob_clean();
        flush();
        return readfile($file);
    }

}