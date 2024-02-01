<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Controllers\User\DepositController as UserDepositController;
use Viserlab\Models\Deposit;
use Viserlab\Models\Gateway;
use Viserlab\Models\GatewayCurrency;
use Viserlab\Models\User;

class DepositController extends Controller
{

    public function pending()
    {
        $pageTitle = 'Pending Deposits';
        $deposits = Deposit::where('status', 2)->orderBy('id', 'desc')->paginate(viser_paginate());
        return $this->view('admin/deposit/log', compact('pageTitle', 'deposits'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Deposits';
        $deposits = Deposit::where('status', 1)->where('method_code', '>=', 1000)->orderBy('id', 'desc')->paginate(viser_paginate());
        return $this->view('admin/deposit/log', compact('pageTitle', 'deposits'));
    }

    public function successful()
    {
        $pageTitle = 'Successful Deposits';
        $deposits = Deposit::where('status', 1)->orderBy('id', 'desc')->paginate(viser_paginate());
        return $this->view('admin/deposit/log', compact('pageTitle', 'deposits'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Deposits';
        $deposits = Deposit::where('status', 3)->orderBy('id', 'desc')->paginate(viser_paginate());
        return $this->view('admin/deposit/log', compact('pageTitle', 'deposits'));
    }

    public function initiated()
    {
        $pageTitle = 'Initiated Deposits';
        $deposits = Deposit::where('status', 0)->orderBy('id', 'desc')->paginate(viser_paginate());
        return $this->view('admin/deposit/log', compact('pageTitle', 'deposits'));
    }

    public function deposit()
    {
        $request = new Request();
        if ($request->username) {
            $user = get_user_by('login', $request->username);
            if (!$user) {
                viser_abort(404);
            }
            $pageTitle = 'Deposit History - ' . $user->user_login;
            $deposits  = Deposit::where('user_id', $user->ID)->orderBy('id', 'desc')->paginate(viser_paginate());
        } else {
            $pageTitle = 'Deposit History';
            $deposits  = Deposit::orderBy('id', 'desc')->paginate(viser_paginate());
        }
        return $this->view('admin/deposit/log', compact('pageTitle', 'deposits'));
    }

    public function detail()
    {
        $request = new Request();
        $deposit = Deposit::findOrFail($request->id);
        $gateway = viser_gateway($deposit->method_code);
        $user = get_userdata($deposit->user_id);
        $pageTitle = $user->user_login . ' requested ' . viser_show_amount($deposit->amount) . ' ' . viser_currency('text');
        return $this->view('admin/deposit/detail', compact('pageTitle', 'deposit', 'gateway', 'user'));
    }

    public function approve()
    {
        $request = new Request();
        $deposit = Deposit::where('id', $request->id)->where('status', 2)->first();
        $deposit->updated_at = current_time('mysql');
        $deposit->save();
        UserDepositController::userDataUpdate($deposit, true);
        $notify[] = ['success', 'Deposit request approved successfully'];
        viser_back($notify);
    }

    public function reject()
    {
        $request = new Request();

        $deposit = Deposit::where('id', $request->id)->where('status', 2)->first();
        $data['admin_feedback'] = sanitize_textarea_field($request->message);
        $data['status']         = 3;
        $data['updated_at']     = current_time('mysql');
        Deposit::where('id', $deposit->id)->update($data);

        $gateway = GatewayCurrency::where('method_code', $deposit->method_code)->where('currency', $deposit->method_currency)->first();
        $user = get_userdata($deposit->user_id);

        viser_notify($user, 'DEPOSIT_REJECT', [
            'method_name'       => $gateway->name,
            'method_currency'   => $deposit->method_currency,
            'method_amount'     => viser_show_amount($deposit->final_amo),
            'amount'            => viser_show_amount($deposit->amount),
            'charge'            => viser_show_amount($deposit->charge),
            'rate'              => viser_show_amount($deposit->rate),
            'trx'               => $deposit->trx,
            'rejection_message' => $request->message,
        ]);

        $notify[] = ['success', 'Deposit request rejected successfully'];
        viser_back($notify);
    }
}
