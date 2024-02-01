<?php

namespace Viserlab\Controllers\User;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Lib\FormProcessor;
use Viserlab\Models\Deposit;
use Viserlab\Models\Form;
use Viserlab\Models\Gateway;
use Viserlab\Models\GatewayCurrency;
use Viserlab\Models\Transaction;

class DepositController extends Controller
{
    public function index()
    {
        $gatewayCurrency = GatewayCurrency::get();
        $pageTitle = 'Deposit Methods';
        $this->pageTitle = $pageTitle;
        return $this->view('user/payment/deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function history()
    {
        $pageTitle = 'Deposit History';
        $this->pageTitle = $pageTitle;

        global $user_ID;
        $deposits = Deposit::where('user_id', $user_ID)->where('status', '!=', 0)->orderBy('id', 'desc')->paginate(20);
        $this->view('user/deposit_history', compact('deposits', 'pageTitle'));
    }

    public function insert()
    {
        $request = new Request();
        $request->validate([
            'amount'      => 'required|numeric',
            'gateway'     => 'required',
            'currency'    => 'required'
        ]);

        if ($request->amount <= 0) {
            $notify[] = ['error', 'Amount must be greater than zero'];
            viser_back($notify);
        }

        $gatewayCurrency = GatewayCurrency::where('method_code', sanitize_text_field($request->gateway))->where('currency', sanitize_text_field($request->currency))->first();
        if (!$gatewayCurrency) {
            $notify[] = ['error', 'Gateway currency not found'];
            viser_back($notify);
        }

        if ($gatewayCurrency->min_amount > $request->amount || $gatewayCurrency->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            viser_back($notify);
        }

        $data = self::insertDeposit($gatewayCurrency, $request->amount);
        viser_session()->put('trx', $data->trx);
        return viser_redirect(viser_route_link('user.deposit.confirm'));
    }

    public static function insertDeposit($gateway, $amount)
    {
        $charge    = $gateway->fixed_charge + ($amount * $gateway->percent_charge / 100);
        $payable   = $amount + $charge;
        $final_amo = $payable * $gateway->rate;

        $deposit                  = new Deposit();
        $deposit->user_id         = viser_auth()->user->ID;
        $deposit->method_code     = $gateway->method_code;
        $deposit->method_currency = strtoupper($gateway->currency);
        $deposit->amount          = $amount;
        $deposit->charge          = $charge;
        $deposit->rate            = $gateway->rate;
        $deposit->final_amo       = $final_amo;
        $deposit->btc_amo         = 0;
        $deposit->btc_wallet      = "";
        $deposit->trx             = viser_trx();
        $deposit->payment_try     = 0;
        $deposit->status          = 0;
        $deposit->created_at      = current_time('mysql');
        $deposit->updated_at      = current_time('mysql');
        $deposit->save();
        return $deposit;
    }

    public function confirm()
    {   
        $pageTitle = 'Payment Confirm';
        $this->pageTitle = $pageTitle;

        $trx = viser_session()->get('trx');
        if (!$trx) {
            $notify[] = ['error', 'Invalid session'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $deposit = Deposit::where('trx', $trx)->where('status', 0)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Invalid request'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        if ($deposit->method_code >= 1000) {
            viser_redirect(viser_route_link('user.deposit.manual'));
        }

        $dirName = $gateway->gateway_alias;
        $new     = 'Viserlab\\Controllers\\Gateway\\' . $dirName . '\\ProcessController';
        $data = $new::process($deposit, $gateway);
        $data = json_decode($data);

        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        if (isset($data->redirect)) {
            viser_redirect($data->redirect_url);
        }

        if (@$data->session) {
            $depositData['btc_wallet'] = $data->session->id;
            Deposit::where('id', $deposit->id)->update($depositData);
        }   
        
        $this->view($data->view, compact('data', 'deposit', 'pageTitle'));
    }

    public static function userDataUpdate($deposit, $isManual = null)
    {
        if ($deposit->status == 0 || $deposit->status == 2) {
            $data['status'] = 1;
            Deposit::where('id', $deposit->id)->update($data);
            $afterBalance = viser_balance($deposit->user_id) + $deposit->amount;
            update_user_meta($deposit->user_id, "viser_balance", $afterBalance);

            $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();

            $transactions = [
                'user_id'      => $deposit->user_id,
                'amount'       => $deposit->amount,
                'post_balance' => $afterBalance,
                'charge'       => $deposit->charge,
                'trx_type'     => '+',
                'details'      => __("Deposited via ", VISERLAB_PLUGIN_NAME) . $gateway->name,
                'trx'          => $deposit->trx,
                'remark'       => 'deposit',
                'created_at'   => current_time('mysql')
            ];

            $transaction = new Transaction();
            $transaction->insert($transactions);

            $user = get_userdata($deposit->user_id);

            viser_notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name'     => $gateway->name,
                'method_currency' => $deposit->method_currency,
                'method_amount'   => viser_show_amount($deposit->final_amo),
                'amount'          => viser_show_amount($deposit->amount),
                'charge'          => viser_show_amount($deposit->charge),
                'rate'            => viser_show_amount($deposit->rate),
                'trx'             => $deposit->trx,
                'post_balance'    => viser_show_amount($afterBalance)
            ]);
        }
    }

    public function manual()
    {
        $pageTitle = 'Deposit Confirm';
        $this->pageTitle = $pageTitle;

        $trx     = viser_session()->get('trx');
        $deposit = Deposit::where('trx', $trx)->where('status', 0)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Invalid request'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $method = Gateway::where('code', $deposit->method_code)->first();

        if ($deposit->method_code > 999) {
            return $this->view('user/payment/manual', compact('deposit', 'method', 'gateway', 'pageTitle'));
        }
        viser_redirect(viser_route_link('user.deposit.index'));
    }

    public function manualUpdate()
    {
        $request = new Request();
        $trx     = viser_session()->get('trx');
        $deposit = Deposit::where('trx', $trx)->where('status', 0)->orderBy('id', 'DESC')->first();
        if (!$deposit) {
            $notify[] = ['error', 'Invalid request'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }
        
        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        if (!$gateway) {
            $notify[] = ['error', 'Invalid gateway'];
            viser_redirect(viser_route_link('user.deposit.index'),$notify);
        }

        $method = Gateway::where('code', $deposit->method_code)->first();

        $form          = Form::find($method->form_id);
        $formData      = json_decode(json_encode(maybe_unserialize($form->form_data)));
        $formProcessor = new FormProcessor();
        $userData      = $formProcessor->processFormData($request, $formData);

        $data['detail'] = maybe_serialize($userData);
        $data['status'] = 2;

        Deposit::where('id', $deposit->id)->update($data);

        $user = get_userdata($deposit->user_id);

        viser_notify($user, 'DEPOSIT_REQUEST', [
            'method_name'     => $gateway->name,
            'method_currency' => $deposit->method_currency,
            'method_amount'   => viser_show_amount($deposit->final_amo),
            'amount'          => viser_show_amount($deposit->amount),
            'charge'          => viser_show_amount($deposit->charge),
            'rate'            => viser_show_amount($deposit->rate),
            'trx'             => $deposit->trx
        ]);

        $notify[] = ['success', 'Your deposit request has been taken'];
        viser_redirect(viser_route_link('user.deposit.history'),$notify);
    }
}
