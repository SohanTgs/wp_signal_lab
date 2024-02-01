<?php

namespace Viserlab\Controllers\Gateway\Mollie;

use Viserlab\Controllers\Controller;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $mollieAcc = json_decode($gateway->gateway_parameter);
        $mollie    = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($mollieAcc->api_key);

        try {
            $siteName = get_bloginfo('name');
            $payment  = $mollie->payments->create([
                "amount" => [
                    'currency' => "$deposit->method_currency",
                    'value'    => '' . sprintf('%0.2f', round($deposit->final_amo, 2)) . '',
                ],
                "description" => __("Pay To", VISERLAB_PLUGIN_NAME) . ' ' . $siteName . __(' Account', VISERLAB_PLUGIN_NAME),
                "redirectUrl" => viser_route_link('ipn.mollie'),
            ]);
        } catch (\Exception $e) {
            $send['error']   = true;
            $send['message'] = $e->getMessage();
            return json_encode($send);
        }

        viser_session()->put('payment_id', $payment->id);

        $send['redirect']     = true;
        $send['redirect_url'] = $payment->getCheckoutUrl();
        return json_encode($send);
    }

    public function ipn()
    {
        $trx        = viser_session()->get('trx');
        $payment_id = viser_session()->get('payment_id');
        $deposit = Deposit::where('trx', $trx)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Gateway not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $mollieAcc = json_decode($gateway->gateway_parameter);
        $mollie    = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($mollieAcc->api_key);
        $payment = $mollie->payments->get($payment_id);

        $data['detail'] = json_encode($payment->details);
        Deposit::where('id', $deposit->id)->update($data);

        if ($payment->status == "paid") {
            DepositController::userDataUpdate($deposit);
            $notify[] = ['success', 'Transaction was successful'];
            viser_redirect(viser_route_link('user.deposit.history'),$notify);
        }
        $notify[] = ['error', 'Invalid request'];
        viser_redirect(viser_route_link('user.deposit.index'),$notify);
    }
}
