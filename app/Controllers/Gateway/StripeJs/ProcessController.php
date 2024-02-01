<?php

namespace Viserlab\Controllers\Gateway\StripeJs;

use Viserlab\Controllers\Controller;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Viserlab\BackOffice\Request;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $StripeJSAcc        = json_decode($gateway->gateway_parameter);
        $user               = get_userdata($deposit->user_id);
        $val['key']         = $StripeJSAcc->publishable_key;
        $val['name']        = $user->user_login;
        $val['description'] = __("Payment with Stripe", VISERLAB_PLUGIN_NAME);
        $val['amount']      = $deposit->final_amo * 100;
        $val['currency']    = $deposit->method_currency;
        $send['val']        = $val;
        $send['src']        = "https://checkout.stripe.com/checkout.js";
        $send['view']       = 'user/payment/StripeJs';
        $send['method']     = 'post';
        $send['url']        = viser_route_link('ipn.stripejs');
        $send['deposit']    = $deposit;
        return json_encode($send);
    }

    public function ipn()
    {
        $request = new Request();
        $trx     = viser_session()->get('trx');
        $deposit = Deposit::where('status', 0)->where('trx', $trx)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $StripeJSAcc = json_decode($gateway->gateway_parameter);

        Stripe::setApiKey($StripeJSAcc->secret_key);
        Stripe::setApiVersion("2020-03-02");

        try {
            $customer =  Customer::create([
                'email'  => $request->stripeEmail,
                'source' => $request->stripeToken,
            ]);
        } catch (\Exception $e) {
            $notify[] = ['error', esc_html($e->getMessage())];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        try {
            $charge = Charge::create([
                'customer'    => $customer->id,
                'description' => __('Payment with Stripe', VISERLAB_PLUGIN_NAME),
                'amount'      => $deposit->final_amo * 100,
                'currency'    => $deposit->method_currency,
            ]);
        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        if ($charge['status'] == 'succeeded') {
            DepositController::userDataUpdate($deposit);
            $notify[] = ['success', 'Payment captured successfully'];
            viser_redirect(viser_route_link('user.deposit.history'),$notify);
        } else {
            $notify[] = ['error', 'Failed to process'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
    }
}
