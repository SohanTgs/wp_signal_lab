<?php

namespace Viserlab\Controllers\Gateway\VoguePay;

use Viserlab\Controllers\Controller;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $vogueAcc              = json_decode($gateway->gateway_parameter);
        $send['v_merchant_id'] = $vogueAcc->merchant_id;
        $send['notify_url']    = viser_route_link('ipn.voguepay');
        $send['cur']           = $deposit->method_currency;
        $send['merchant_ref']  = $deposit->trx;
        $send['memo']          = __('Payment', VISERLAB_PLUGIN_NAME);
        $send['store_id']      = $deposit->user_id;
        $send['custom']        = $deposit->trx;
        $send['Buy']           = round($deposit->final_amo, 2);
        $alias                 = $gateway->gateway_alias;
        $send['view']          = 'user/payment/' . $alias;
        $send['deposit']       = $deposit;
        return json_encode($send);
    }

    public function ipn()
    {
        
    }
}
