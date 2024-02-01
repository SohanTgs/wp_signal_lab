<?php

namespace Viserlab\Controllers\Gateway\Coinpayments;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $coinPayAcc = json_decode($gateway->gateway_parameter);
        $user       = get_userdata($deposit->user_id);

        if ($deposit->btc_amo == 0 || $deposit->btc_wallet == "") {
            try {
                $cps = new CoinPaymentHosted();
            } catch (\Exception $e) {
                $send['error']   = true;
                $send['message'] = $e->getMessage();
                return json_encode($send);
            }

            $cps->Setup($coinPayAcc->private_key, $coinPayAcc->public_key);
            $callbackUrl = viser_route_link('ipn.coinpayments');

            $req = array(
                'amount'      => $deposit->final_amo,
                'currency1'   => __('USD', VISERLAB_PLUGIN_NAME),
                'currency2'   => $deposit->method_currency,
                'custom'      => $deposit->trx,
                'buyer_email' => $user->user_email,
                'ipn_url'     => $callbackUrl,
            );

            $result = $cps->CreateTransaction($req);
            if ($result['error'] == 'ok') {
                $bcoin                 = sprintf('%.08f', $result['result']['amount']);
                $sendadd               = $result['result']['address'];
                $deposit->btc_amo    = $bcoin;
                $deposit->btc_wallet = $sendadd;
                $deposit->save();
            } else {
                $send['error']   = true;
                $send['message'] = $result['error'];
            }
        }

        $send['amount']   = $deposit->btc_amo;
        $send['sendto']   = $deposit->btc_wallet;
        $send['img']      = viser_crypto_qr($deposit->btc_wallet);
        $send['currency'] = "$deposit->method_currency";
        $send['view']     = 'user/payment/crypto';
        return json_encode($send);
    }

    public function ipn()
    {
        $request = new Request();
        $track   = $request->custom;
        $status  = $request->status;
        $amount2 = floatval($request->amount2);
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
            if ($deposit->method_currency == $request->currency2 && $deposit->btc_amo <= $amount2  && $coinPayAcc->merchant_id == $request->merchant && $deposit->status == '0') {
                DepositController::userDataUpdate($deposit);
            }
        }
    }
}
