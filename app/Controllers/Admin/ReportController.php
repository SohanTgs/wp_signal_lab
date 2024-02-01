<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Models\Transaction;
use Viserlab\Models\SignalHistory;

class ReportController extends Controller
{

    public function transaction()
    {
        $request = new Request();
        if ($request->username) {
            $user = get_user_by('login', $request->username);
            if (!$user) {
                viser_abort(404);
            }
            $pageTitle    = 'Transaction Logs - ' . $user->user_login;
            $transactions = Transaction::where('user_id', $user->ID)->orderBy('id', 'desc')->paginate(20);
        } else {
            $pageTitle    = 'Transaction Logs';
            $transactions = Transaction::orderBy('id', 'desc')->paginate(20);
        }
        $this->view('admin/report/transactions', compact('pageTitle', 'transactions'));
    }

    public function signalHistory(){

        $request = new Request();

        if ($request->username) {
            $user = get_user_by('login', $request->username);

            if (!$user) {
                viser_abort(404);
            }
           
            $pageTitle    = 'Signal Logs - ' . $user->user_login;
            $signals = SignalHistory::where('user_id', $user->ID)->orderBy('id', 'desc')->paginate(viser_paginate());
        }else{
            $pageTitle    = 'Signal Logs';
            $signals = SignalHistory::orderBy('id', 'desc')->paginate(viser_paginate());
        }

        $this->view('admin/report/signals', compact('pageTitle', 'signals'));
    }
    
}
