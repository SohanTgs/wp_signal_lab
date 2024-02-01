<?php

namespace Viserlab\Controllers\Gateway\Razorpay;

use Viserlab\Controllers\Controller;
use Razorpay\Api\Api;
use Viserlab\BackOffice\Request;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $razorAcc   = json_decode($gateway->gateway_parameter);
        $api_key    = $razorAcc->key_id;
        $api_secret = $razorAcc->key_secret;
        $user       = get_userdata($deposit->user_id);

        try {
            $api   = new Api($api_key, $api_secret);
            $order = $api->order->create(
                array(
                    'receipt'         => $deposit->trx,
                    'amount'          => round($deposit->final_amo * 100),
                    'currency'        => $deposit->method_currency,
                    'payment_capture' => '0'
                )
            );
        } catch (\Exception $e) {
            $send['error']   = true;
            $send['message'] = esc_html($e->getMessage());
            return json_encode($send);
        }

        $data['btc_wallet'] = $order->id;
        Deposit::where('id', $deposit->id)->update($data);

        $val['key']           = $razorAcc->key_id;
        $val['amount']        = round($deposit->final_amo * 100);
        $val['currency']      = $deposit->method_currency;
        $val['order_id']      = $order['id'];
        $val['buttontext']    = __("Pay with Razorpay", VISERLAB_PLUGIN_NAME);
        $val['name']          = $user->user_login;
        $val['description']   = __("Payment By Razorpay", VISERLAB_PLUGIN_NAME);
        $val['prefill.name']  = $user->display_name;
        $val['prefill.email'] = $user->user_email;
        $val['theme.color']   = "#2ecc71";
        $send['val']          = $val;
        $send['method']       = 'POST';

        $alias = $gateway->gateway_alias;

        $send['url']         = viser_route_link('ipn.razorpay');
        $send['custom']      = $deposit->trx;
        $send['checkout_js'] = "https://checkout.razorpay.com/v1/checkout.js";
        $send['view']        = 'user/payment/' . $alias;
        $send['deposit']     = $deposit;

        return json_encode($send);
    }

    public function ipn()
    {
        $request = new Request();
        $deposit = Deposit::where('btc_wallet', $request->razorpay_order_id)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $razorAcc = json_decode($gateway->gateway_parameter);
        $sig      = hash_hmac('sha256', $request->razorpay_order_id . "|" . $request->razorpay_payment_id, $razorAcc->key_secret);

        $data['detail'] = json_encode($request->all());
        Deposit::where('id', $deposit->id)->update($data);

        if ($sig == $request->razorpay_signature && $deposit->status == '0') {
            DepositController::userDataUpdate($deposit);
            $notify[] = ['success', 'Transaction was successful'];
            viser_redirect(viser_route_link('user.deposit.history'),$notify);
        } else {
            $notify[] = ['error', "Invalid Request"];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
    }
}
