<?php

namespace Viserlab\Controllers\Gateway\Paytm;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Controllers\User\DepositController;
use Viserlab\Models\Deposit;

class ProcessController extends Controller
{
    public static function process($deposit, $gateway)
    {
        $PayTmAcc                = json_decode($gateway->gateway_parameter);
        $val['MID']              = trim($PayTmAcc->MID);
        $val['WEBSITE']          = trim($PayTmAcc->WEBSITE);
        $val['CHANNEL_ID']       = trim($PayTmAcc->CHANNEL_ID);
        $val['INDUSTRY_TYPE_ID'] = trim($PayTmAcc->INDUSTRY_TYPE_ID);

        try {
            $checkSumHash = (new PayTM())->getChecksumFromArray($val, $PayTmAcc->merchant_key);
        } catch (\Exception $e) {
            $send['error']   = true;
            $send['message'] = $e->getMessage();
            return json_encode($send);
        }

        $val['ORDER_ID']     = $deposit->trx;
        $val['TXN_AMOUNT']   = round($deposit->final_amo, 2);
        $val['CUST_ID']      = $deposit->user_id;
        $val['CALLBACK_URL'] = viser_route_link('ipn.paytm');
        $val['CHECKSUMHASH'] = $checkSumHash;

        $send['val']    = $val;
        $send['view']   = 'user/payment/redirect';
        $send['method'] = 'post';
        $send['url']    = $PayTmAcc->transaction_url . "?orderid=" . $deposit->trx;
        return json_encode($send);
    }

    public function ipn()
    {
        $request = new Request();
        $deposit = Deposit::where('trx', sanitize_text_field($request->ORDERID))->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Deposit not found'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $gateway = Deposit::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $PayTmAcc = json_decode($gateway->gateway_parameter);
        $ptm      = new PayTM();

        if ($ptm->verifychecksum_e($_POST, $PayTmAcc->merchant_key, $request->CHECKSUMHASH) === "TRUE") {

            if ($request->RESPCODE == "01") {
                $requestParamList                 = array("MID" => $PayTmAcc->MID, "ORDERID" => $request->ORDERID);
                $StatusCheckSum                   = $ptm->getChecksumFromArray($requestParamList, $PayTmAcc->merchant_key);
                $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
                $responseParamList                = $ptm->callNewAPI($PayTmAcc->transaction_status_url, $requestParamList);
                if ($responseParamList['STATUS'] == 'TXN_SUCCESS' && $responseParamList['TXNAMOUNT'] == $_POST['TXNAMOUNT']) {
                    DepositController::userDataUpdate($deposit);
                    $notify[] = ['success', 'Transaction is successful'];
                    viser_redirect(viser_route_link('user.deposit.history'),$notify);
                } else {
                    $notify[] = ['error', 'It seems some issue in server to server communication. Kindly connect with administrator'];
                }
            } else {
                $notify[] = ['error',  $request->RESPMSG];
            }
        } else {
            $notify[] = ['error', 'Security error!'];
        }
        viser_redirect(viser_route_link('user.deposit.index'),$notify);
    }
}
