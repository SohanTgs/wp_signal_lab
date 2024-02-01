<?php

namespace Viserlab\Controllers\Gateway\Cashmaal;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $user                = get_userdata($deposit->user_id);
        $param               = json_decode($gateway->gateway_parameter);
        $val['pay_method']   = " ";
        $val['amount']       = viser_get_amount($deposit->final_amo);
        $val['currency']     = $gateway->currency;
        $val['succes_url']   = viser_route_link('ipn.cashmaal');
        $val['cancel_url']   = viser_route_link('user.deposit.index');
        $val['client_email'] = $user->user_email;
        $val['web_id']       = $param->web_id;
        $val['order_id']     = $deposit->trx;
        $val['addi_info']    = __("Deposit", VISERLAB_PLUGIN_NAME);
        $send['url']         = 'https://www.cashmaal.com/Pay/';
        $send['method']      = 'post';
        $send['view']        = 'user/payment/redirect';
        $send['val']         = $val;
        return json_encode($send);
    }

    public function ipn()
    {
        $request = new Request();
        $gateway = GatewayCurrency::where('gateway_alias', 'Cashmaal')->where('currency', sanitize_text_field($request->currency))->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $IPN_key = json_decode($gateway->gateway_parameter)->ipn_key;
        $web_id  = json_decode($gateway->gateway_parameter)->web_id;

        $deposit = Deposit::where('trx', sanitize_text_field($request->order_id))->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        if (sanitize_text_field($request->ipn_key) != $IPN_key && $web_id != sanitize_text_field($request->web_id)) {
            $notify[] = ['error', 'Data invalid'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        if ($request->status == 2) {
            $notify[] = ['info', 'Payment in pending'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        if ($request->status != 1) {
            $notify[] = ['error', 'Data invalid'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        if ($request->status == 1 && $deposit->status == 0 && $request->currency == $deposit->method_currency) {
            DepositController::userDataUpdate($deposit);
            $notify[] = ['success', 'Transaction is successful'];
            viser_redirect(viser_route_link('user.deposit.history'),$notify);
        } else {
            $notify[] = ['error', 'Payment failed'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        viser_redirect(viser_route_link('user.deposit.index'));
    }
}
