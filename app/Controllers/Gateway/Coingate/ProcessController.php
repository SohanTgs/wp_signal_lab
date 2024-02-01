<?php

namespace Viserlab\Controllers\Gateway\Coingate;

use Viserlab\Controllers\Controller;
use CoinGate\CoinGate;
use CoinGate\Merchant\Order;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Lib\CurlRequest;
use Viserlab\Models\Deposit;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $coingateAcc = json_decode($gateway->gateway_parameter);
        try {
            CoinGate::config(array(
                'environment' => 'live',                // sandbox OR live
                'auth_token'  => $coingateAcc->api_key
            ));
        } catch (\Exception $e) {
            $send['error']   = true;
            $send['message'] = $e->getMessage();
            return json_encode($send);
        }

        $post_params = array(
            'order_id'         => $deposit->trx,
            'price_amount'     => round($deposit->final_amo, 2),
            'price_currency'   => $deposit->method_currency,
            'receive_currency' => $deposit->method_currency,
            'callback_url'     => viser_route_link('ipn.coingate'),
            'cancel_url'       => viser_route_link('user.deposit.index'),
            'success_url'      => viser_route_link('user.deposit.history'),
            'title'            => __('Payment to ', VISERLAB_PLUGIN_NAME) . get_bloginfo('name'),
            'token'            => $deposit->trx
        );

        try {
            $order = Order::create($post_params);
        } catch (\Exception $e) {
            $send['error']   = true;
            $send['message'] = esc_html($e->getMessage());
            return json_encode($send);
        }
        if ($order) {
            $send['redirect']     = true;
            $send['redirect_url'] = esc_url($order->payment_url);
        } else {
            $send['error']   = true;
            $send['message'] = __('Unexpected Error! Please Try Again', VISERLAB_PLUGIN_NAME);
        }
        $send['view'] = '';
        return json_encode($send);
    }

    public function ipn()
    {
        $ip       = $_SERVER['REMOTE_ADDR'];
        $url      = 'https://api.coingate.com/v2/ips-v4';
        $response = CurlRequest::curlContent($url);
        if (strpos($response, $ip) !== false) {
            $deposit = Deposit::where('trx', sanitize_text_field($_POST['token']))->orderBy('id', 'DESC')->first();
            if ($_POST['status'] == 'paid' && $_POST['price_amount'] == $deposit->final_amo && $deposit->status == '0') {
                DepositController::userDataUpdate($deposit);
            }
        }
    }
}
