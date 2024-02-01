<?php

namespace Viserlab\Controllers\User;

use Viserlab\Controllers\Controller;
use Viserlab\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $this->pageTitle = 'Transactions';

        global $user_ID;
        $transactions = Transaction::where('user_id', $user_ID)->orderBy('id', 'DESC')->paginate(20);
        $this->view('user/transactions', compact('transactions'));
    }
}
