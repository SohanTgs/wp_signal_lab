<?php

namespace Viserlab\Controllers\Gateway\Stripe;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;
use Viserlab\Controllers\User\DepositController;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $send['track']  = $deposit->trx;
        $send['view']   = 'user/payment/' . $gateway->gateway_alias;
        $send['method'] = 'post';
        $send['url']    = viser_route_link('ipn.stripe');
        return json_encode($send);
    }

    public function ipn()
    {
        $request = new Request();
        $request->validate([
            'cardNumber' => 'required',
            'cardExpiry' => 'required',
            'cardCVC'    => 'required',
        ]);
        $trx     = viser_session()->get('trx');
        $deposit = Deposit::where('status', 0)->where('trx', $trx)->orderby('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_back($notify);
        }

        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_back($notify);
        }

        $credentials = json_decode($gateway->gateway_parameter);
        $cc          = sanitize_text_field($request->cardNumber);
        $exp         = sanitize_text_field($request->cardExpiry);
        $cvc         = sanitize_text_field($request->cardCVC);

        $exp  = explode("/", $request->cardExpiry);
        $emo  = trim($exp[0]);
        $eyr  = trim($exp[1]);
        $cnts = round($deposit->final_amo, 2) * 100;

        Stripe::setApiKey($credentials->secret_key);
        Stripe::setApiVersion("2020-03-02");
        
        try {
            $token = Token::create(array(
                "card" => array(
                    "number"    => "$cc",
                    "exp_month" => $emo,
                    "exp_year"  => $eyr,
                    "cvc"       => "$cvc"
                )
            ));
            try {
                $charge = Charge::create(array(
                    'card'        => $token['id'],
                    'currency'    => $deposit->method_currency,
                    'amount'      => $cnts,
                    'description' => 'item',
                ));

                if ($charge['status'] == 'succeeded') {
                    DepositController::userDataUpdate($deposit);
                    $notify[] = ['success', 'Payment captured successfully'];
                    viser_redirect(viser_route_link('user.deposit.history'),$notify);
                }
            } catch (\Exception $e) {
                $notify[] = ['error', esc_html($e->getMessage())];
                viser_set_notify($notify);
            }
        } catch (\Exception $e) {
            $notify[] = ['error', esc_html($e->getMessage())];
            viser_set_notify($notify);
        }
        viser_redirect(viser_route_link('user.deposit.history'));
    }
}
