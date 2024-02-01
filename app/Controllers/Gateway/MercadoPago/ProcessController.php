<?php

namespace Viserlab\Controllers\Gateway\MercadoPago;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\Gateway;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $gatewayCurrency = $gateway;
        $gatewayAcc      = json_decode($gatewayCurrency->gateway_parameter);
        $user            = get_userdata($deposit->user_id);
        $curl            = curl_init();

        $preferenceData = [
            'items' => [
                [
                    'id'          => $deposit->trx,
                    'title'       => __('Deposit', VISERLAB_PLUGIN_NAME),
                    'description' => __('Deposit from ', VISERLAB_PLUGIN_NAME) . $user->user_login,
                    'quantity'    => 1,
                    'currency_id' => $gatewayCurrency->currency,
                    'unit_price'  => $deposit->final_amo
                ]
            ],
            'payer' => [
                'email' => $user->email,
            ],
            'back_urls' => [
                'success' => viser_route_link('user.deposit.history'),
                'pending' => '',
                'failure' => viser_route_link('user.deposit.index'),
            ],
            'notification_url' => viser_route_link('ipn.mercadopago'),
            'auto_return'      => 'approved',
        ];

        $httpHeader = [
            "Content-Type: application/json",
        ];

        $url  = "https://api.mercadopago.com/checkout/preferences?access_token=" . $gatewayAcc->access_token;
        $opts = [
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($preferenceData, true),
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => $httpHeader
        ];
        curl_setopt_array($curl, $opts);
        $response = curl_exec($curl);
        $result   = json_decode($response, true);
        $err      = curl_error($curl);
        curl_close($curl);

        if (@$result['init_point']) {
            $send['redirect']     = true;
            $send['redirect_url'] = $result['init_point'];
        } else {
            $send['error']   = true;
            $send['message'] = __('Some problem ocurred with api.', VISERLAB_PLUGIN_NAME);
        }
        $send['view'] = '';
        return json_encode($send);
    }

    public function ipn()
    {
        $request   = new Request();
        $paymentId = json_decode(json_encode($request->all()))->data->id;
        $gateway   = Gateway::where('alias', 'MercadoPago')->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        $param      = json_decode($gateway->gateway_parameters);
        $paymentUrl = "https://api.mercadopago.com/v1/payments/" . $paymentId . "?access_token=" . $param->access_token->value;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paymentUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $paymentData = curl_exec($ch);
        curl_close($ch);

        $payment = json_decode($paymentData, true);
        $trx     = $payment['additional_info']['items'][0]['id'];
        $deposit = Deposit::where('trx', $trx)->where('status', 0)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        if ($payment['status'] == 'approved' && $deposit) {
            DepositController::userDataUpdate($deposit);
            $notify[] = ['success', 'Payment captured successfully.'];
            viser_redirect(viser_route_link('user.deposit.history'),$notify);
        }
        $notify[] = ['success', 'Unable to process'];
        viser_redirect(viser_route_link('user.deposit.index'),$notify);
    }
}
