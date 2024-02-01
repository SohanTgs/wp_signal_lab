<?php

namespace Viserlab\Controllers\Gateway\PaypalSdk;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Gateway\PaypalSdk\Core\PayPalHttpClient;
use Viserlab\Controllers\Gateway\PaypalSdk\Core\ProductionEnvironment;
use Viserlab\Controllers\Gateway\PaypalSdk\Orders\OrdersCaptureRequest;
use Viserlab\Controllers\Gateway\PaypalSdk\Orders\OrdersCreateRequest;
use Viserlab\Controllers\Gateway\PaypalSdk\PayPalHttp\HttpException;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\GatewayCurrency;

class ProcessController
{
    public static function process($deposit, $gateway)
    {
        $paypalAcc = json_decode($gateway->gateway_parameter);
          // Creating an environment
        $clientId     = $paypalAcc->clientId;
        $clientSecret = $paypalAcc->clientSecret;
        $environment  = new ProductionEnvironment($clientId, $clientSecret);
        $client       = new PayPalHttpClient($environment);
        $request      = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent"         => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $deposit->trx,
                "amount"       => [
                    "value"         => round($deposit->final_amo, 2),
                    "currency_code" => $deposit->method_currency
                ]
            ]],
            "application_context" => [
                "cancel_url" => viser_route_link('user.deposit.index'),
                "return_url" => viser_route_link('ipn.paypalsdk')
            ]
        ];

        try {
            $response            = $client->execute($request);
            $deposit->btc_wallet = $response->result->id;
            $deposit->save();

            $send['redirect']     = true;
            $send['redirect_url'] = $response->result->links[1]->href;
        } catch (HttpException $ex) {
            $send['error']   = true;
            $send['message'] = __('Failed to process with api', VISERLAB_PLUGIN_NAME);
        }
        return json_encode($send);
    }

    public function ipn()
    {
        $req     = new Request();
        $request = new OrdersCaptureRequest($req->token);
        $request->prefer('return=representation');
        try {
            $deposit = Deposit::where('btc_wallet', $req->token)->where('status', 0)->first();
            if (!$deposit) {
                $notify[] = ['error', 'Deposit not found'];
                viser_redirect(viser_route_link('user.deposit.index'),$notify);
            }
            $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
            if (!$gateway) {
                $notify[] = ['error', 'Gateway not found'];
                viser_redirect(viser_route_link('user.deposit.index'),$notify);
            }
            $paypalAcc    = json_decode($gateway->gateway_parameter);
            $clientId     = $paypalAcc->clientId;
            $clientSecret = $paypalAcc->clientSecret;
            $environment  = new ProductionEnvironment($clientId, $clientSecret);
            $client       = new PayPalHttpClient($environment);

            $response = $client->execute($request);

            if (@$response->result->status == 'COMPLETED') {

                $data['detail'] = json_encode($response->result->payer);
                Deposit::where('id', $deposit->id)->update($data);
                DepositController::userDataUpdate($deposit);
                $notify[] = ['success', 'Payment captured successfully'];
                viser_redirect(viser_route_link('user.deposit.history'),$notify);
            } else {
                $notify[] = ['error', 'Payment captured failed'];
                viser_redirect(viser_route_link('user.deposit.index'),$notify);
            }
        } catch (HttpException $ex) {
            viser_redirect(viser_route_link('user.deposit.index'));
        }
    }
}
