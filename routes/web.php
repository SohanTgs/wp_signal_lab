<?php

use Viserlab\BackOffice\Router\Router;
use Viserlab\Controllers\ActivationController;
use Viserlab\Controllers\Gateway\Authorize\ProcessController as AuthorizeProcessController;
use Viserlab\Controllers\Gateway\Blockchain\ProcessController as BlockchainProcessController;
use Viserlab\Controllers\Gateway\Cashmaal\ProcessController as CashmaalProcessController;
use Viserlab\Controllers\Gateway\CoinbaseCommerce\ProcessController as CoinbaseCommerceProcessController;
use Viserlab\Controllers\Gateway\Coingate\ProcessController as CoingateProcessController;
use Viserlab\Controllers\Gateway\Coinpayments\ProcessController as CoinpaymentsProcessController;
use Viserlab\Controllers\Gateway\CoinpaymentsFiat\ProcessController as CoinpaymentsFiatProcessController;
use Viserlab\Controllers\Gateway\Flutterwave\ProcessController as FlutterwaveProcessController;
use Viserlab\Controllers\Gateway\Instamojo\ProcessController as InstamojoProcessController;
use Viserlab\Controllers\Gateway\MercadoPago\ProcessController as MercadoPagoProcessController;
use Viserlab\Controllers\Gateway\Mollie\ProcessController as MollieProcessController;
use Viserlab\Controllers\Gateway\NMI\ProcessController as NMIProcessController;
use Viserlab\Controllers\Gateway\Payeer\ProcessController as PayeerProcessController;
use Viserlab\Controllers\Gateway\Paypal\ProcessController as PaypalProcessController;
use Viserlab\Controllers\Gateway\PaypalSdk\ProcessController as PaypalSdkProcessController;
use Viserlab\Controllers\Gateway\Paystack\ProcessController as PaystackProcessController;
use Viserlab\Controllers\Gateway\Paytm\ProcessController as PaytmProcessController;
use Viserlab\Controllers\Gateway\PerfectMoney\ProcessController as PerfectMoneyProcessController;
use Viserlab\Controllers\Gateway\Razorpay\ProcessController as RazorpayProcessController;
use Viserlab\Controllers\Gateway\Skrill\ProcessController as SkrillProcessController;
use Viserlab\Controllers\Gateway\Stripe\ProcessController as StripeProcessController;
use Viserlab\Controllers\Gateway\StripeJs\ProcessController as StripeJsProcessController;
use Viserlab\Controllers\Gateway\StripeV3\ProcessController as StripeV3ProcessController;
use Viserlab\Controllers\Gateway\VoguePay\ProcessController as VoguePayProcessController;
use Viserlab\Controllers\User\Auth\ForgotPasswordController;
use Viserlab\Controllers\User\Auth\LoginController;
use Viserlab\Controllers\User\Auth\RegisterController;
use Viserlab\Controllers\User\DashboardController;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Controllers\User\ProfileController;
use Viserlab\Controllers\User\TicketController;
use Viserlab\Controllers\User\TransactionController;

$router = new Router;

$router->router([
    'user.login'=>[
        'method'     => 'get',
        'uri'        => 'login',
        'middleware' => ['authorized','checkPlugin'],
        'action'     => [LoginController::class,'login'],
    ]
]);

$router->router([
    'user.logout'=>[
        'method'     => 'get',
        'uri'        => 'logout',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [LoginController::class,'logout'],
    ]
]);

$router->router([
    'user.forget.password'=>[
        'method'     => 'any',
        'uri'        => 'forgot',
        'middleware' => ['authorized','checkPlugin'],
        'action'     => [ForgotPasswordController::class,'forgot'],
    ]
]);

$router->router([
    'user.register'=>[
        'method'     => 'any',
        'uri'        => 'register',
        'middleware' => ['authorized','checkPlugin','allow_registration'],
        'action'     => [RegisterController::class,'showRegisterForm'],
    ]
]);

$router->router([ 
    'user.home'=>[
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard'),
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DashboardController::class, 'index'],
    ]
]);

$router->router([ 
    'user.signals'=>[
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/signals',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DashboardController::class, 'signals'],
    ]
]);

$router->router([ 
    'user.packages'=>[
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/packages',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DashboardController::class, 'packages'],
    ]
]);

$router->router([ 
    'user.purchase.package'=>[
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/purchase/package',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DashboardController::class, 'purchasePackage'],
    ]
]);

$router->router([ 
    'user.renew.package'=>[
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/renew/package',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DashboardController::class, 'renewPackage'],
    ]
]);

//deposit
$router->router([
    'user.deposit.index'=>[
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/deposit',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DepositController::class, 'index'],
    ]
]);

$router->router([
    'user.deposit.insert'=>[
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/deposit-insert',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DepositController::class, 'insert'],
    ]
]);

$router->router([
    'user.deposit.manual'=>[
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/deposit-manual',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DepositController::class, 'manual'],
    ]
]);

$router->router([
    'user.deposit.manual.update'=>[
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/deposit-manual-update',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DepositController::class, 'manualUpdate'],
    ]
]);

$router->router([
    'user.deposit.confirm'=>[
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/deposit-confirm',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DepositController::class, 'confirm'],
    ]
]);

$router->router([
    'user.deposit.history'=>[
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/deposit-history',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [DepositController::class, 'history'],
    ]
]);

// ======================================================= IPN =======================================================
$router->router([
    'ipn.stripe'=>[
        'method'     => 'post',
        'uri'        => 'ipn/stripe',
        'action'     => [StripeProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.authorize'=>[
        'method'     => 'post',
        'uri'        => 'ipn/authorize',
        'action'     => [AuthorizeProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.blockchain'=>[
        'method'     => 'any',
        'uri'        => 'ipn/blockchain',
        'action'     => [BlockchainProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.cashmaal'=>[
        'method'     => 'any',
        'uri'        => 'ipn/cashmaal',
        'action'     => [CashmaalProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.coinbasecommerce'=>[
        'method'     => 'any',
        'uri'        => 'ipn/coinbasecommerce',
        'action'     => [CoinbaseCommerceProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.coingate'=>[
        'method'     => 'any',
        'uri'        => 'ipn/coingate',
        'action'     => [CoingateProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.coinpayments'=>[
        'method'     => 'any',
        'uri'        => 'ipn/coinpayments',
        'action'     => [CoinpaymentsProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.coinpaymentsfiat'=>[
        'method'     => 'any',
        'uri'        => 'ipn/coinpaymentsfiat',
        'action'     => [CoinpaymentsFiatProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.flutterwave'=>[
        'method'     => 'any',
        'uri'        => 'ipn/flutterwave',
        'action'     => [FlutterwaveProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.instamojo'=>[
        'method'     => 'any',
        'uri'        => 'ipn/instamojo',
        'action'     => [InstamojoProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.mercadopago'=>[
        'method'     => 'any',
        'uri'        => 'ipn/mercadopago',
        'action'     => [MercadoPagoProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.mollie'=>[
        'method'     => 'any',
        'uri'        => 'ipn/mollie',
        'action'     => [MollieProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.nmi'=>[
        'method'     => 'any',
        'uri'        => 'ipn/nmi',
        'action'     => [NMIProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.payeer'=>[
        'method'     => 'any',
        'uri'        => 'ipn/payeer',
        'action'     => [PayeerProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.paypal'=>[
        'method'     => 'any',
        'uri'        => 'ipn/paypal',
        'action'     => [PaypalProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.paypalsdk'=>[
        'method'     => 'any',
        'uri'        => 'ipn/paypalsdk',
        'action'     => [PaypalSdkProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.paystack'=>[
        'method'     => 'any',
        'uri'        => 'ipn/paystack',
        'action'     => [PaystackProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.paytm'=>[
        'method'     => 'any',
        'uri'        => 'ipn/paytm',
        'action'     => [PaytmProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.perfectmoney'=>[
        'method'     => 'any',
        'uri'        => 'ipn/perfectmoney',
        'action'     => [PerfectMoneyProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.razorpay'=>[
        'method'     => 'any',
        'uri'        => 'ipn/razorpay',
        'action'     => [RazorpayProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.skrill'=>[
        'method'     => 'any',
        'uri'        => 'ipn/skrill',
        'action'     => [SkrillProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.stripejs'=>[
        'method'     => 'any',
        'uri'        => 'ipn/stripejs',
        'action'     => [StripeJsProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.stripev3'=>[
        'method'     => 'any',
        'uri'        => 'ipn/stripev3',
        'action'     => [StripeV3ProcessController::class, 'ipn']
    ]
]);
$router->router([
    'ipn.voguepay'=>[
        'method'     => 'any',
        'uri'        => 'ipn/voguepay',
        'action'     => [VoguePayProcessController::class, 'ipn']
    ]
]);

$router->router([
    'user.transaction.index'=> [
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/transactions',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TransactionController::class, 'index'],
    ]
]);

$router->router([
    'user.change.password'=> [
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/change-password',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [ProfileController::class, 'changePassword'],
    ]
]);

$router->router([
    'user.change.password.update'=> [
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/change-password-update',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [ProfileController::class, 'changePasswordUpdate'],
    ]
]);

$router->router([
    'user.profile.setting'=> [
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/profile-setting',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [ProfileController::class, 'profileSetting'],
    ]
]);

$router->router([
    'user.profile.setting.update'=> [
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/profile-setting-update',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [ProfileController::class, 'profileSettingUpdate'],
    ]
]);

$router->router([
    'user.ticket.index'=> [
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/tickets',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TicketController::class, 'myTicket'],
    ]
]);

$router->router([
    'user.ticket.create'=> [
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/ticket-create',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TicketController::class, 'createTicket'],
    ]
]);

$router->router([
    'user.ticket.store'=> [
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/ticket-store',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TicketController::class, 'storeTicket'],
    ]
]);

$router->router([
    'user.ticket.view'=> [
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/ticket-view',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TicketController::class, 'viewTicket'],
    ]
]);

$router->router([
    'user.ticket.close'=> [
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/ticket-close',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TicketController::class, 'closeTicket'],
    ]
]);

$router->router([
    'user.ticket.reply'=> [
        'method'     => 'post',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/ticket-reply',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TicketController::class, 'replyTicket'],
    ]
]);

$router->router([
    'user.ticket.download'=> [
        'method'     => 'get',
        'uri'        => get_option('viser_user_panel_prefix', 'user-dashboard').'/ticket-download',
        'middleware' => ['auth','checkPlugin'],
        'action'     => [TicketController::class, 'downloadTicket'],
    ]
]);



// activation routes
$router->router([
    'plugin.activation'=> [
        'method'     => 'get',
        'uri'        => VISERLAB_PLUGIN_NAME.'-activation',
        'action'     => [ActivationController::class, 'activate'],
    ]
]);