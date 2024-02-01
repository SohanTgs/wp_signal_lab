<?php

namespace Viserlab\Middleware;

class VerifyNonce{

    protected $exceptVerify = [];

    public function __construct()
    {
        $this->exceptVerify = [
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/stripe',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/authorize',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/blockchain',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/cashmaal',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/coinbasecommerce',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/coingate',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/coinpayments',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/coinpaymentsfiat',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/flutterwave',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/instamojo',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/mercadopago',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/mollie',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/nmi',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/payeer',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/paypal',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/paypalsdk',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/paystack',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/paytm',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/perfectmoney',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/razorpay',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/skrill',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/stripejs',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/stripev3',
            get_option('viser_user_panel_prefix','user-dashboard').'/ipn/voguepay',
        ];
    }

    public function filterRequest()
    {
        if($this->shouldVerify()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nonce = viser_request()->nonce;
               
                if (!$nonce) {
                    viser_abort(404);
                }
                if (get_query_var('viser_page')) {
                    $currentRoute = get_query_var('viser_page');
                }else{
                    $currentRoute = viser_current_route();
                }
                if (!wp_verify_nonce($nonce,$currentRoute)) {
                    viser_abort(404);
                }
            }
        }
    }

    public function shouldVerify(){
        if(in_array(get_query_var('viser_page'), $this->exceptVerify)) return false;
        return true;
    }
}