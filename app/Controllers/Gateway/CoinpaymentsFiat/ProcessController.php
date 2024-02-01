<?php

namespace Viserlab\Controllers\Gateway\CoinpaymentsFiat;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $coinpayAcc           = json_decode($gateway->gateway_parameter);
        $val['merchant']      = $coinpayAcc->merchant_id;
        $val['item_name']     = __('Payment to ', VISERLAB_PLUGIN_NAME) . get_bloginfo('name');
        $val['currency']      = $deposit->method_currency;
        $val['currency_code'] = "$deposit->method_currency";
        $val['amountf']       = round($deposit->final_amo, 2);
        $val['ipn_url']       = viser_route_link('ipn.coinpaymentsfiat');
        $val['custom']        = "$deposit->trx";
        $val['amount']        = round($deposit->final_amo, 2);
        $val['return']        = viser_route_link('user.deposit.history');
        $val['cancel_return'] = viser_route_link('user.deposit.index');
        $val['notify_url']    = viser_route_link('ipn.coinpaymentsfiat');
        $val['success_url']   = viser_route_link('user.deposit.history');
        $val['cancel_url']    = viser_route_link('user.deposit.index');
        $val['custom']        = $deposit->trx;
        $val['cmd']           = '_pay_simple';
        $val['want_shipping'] = 0;
        $send['val']          = $val;
        $send['view']         = 'user/payment/redirect';
        $send['method']       = 'post';
        $send['url']          = 'https://www.coinpayments.net/index.php';
        return json_encode($send);
    }

    public function ipn()
    {
        $request = new Request();
        $track   = sanitize_text_field($request->custom);
        $status  = sanitize_text_field($request->status);
        $amount1 = floatval($request->amount1);
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        if ($status >= 100 || $status == 2) {
            $coinPayAcc = json_decode($gateway->gateway_parameter);
            if ($deposit->method_currency == $request->currency1 && round($deposit->final_amo, 2) <= $amount1  && $coinPayAcc->merchant_id == $request->merchant && $deposit->status == '0') {
                DepositController::userDataUpdate($deposit);
            }
        }
    }
}
