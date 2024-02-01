<?php

namespace Viserlab\Controllers\User;

use Viserlab\Controllers\Controller;
use Viserlab\Models\Deposit;
use Viserlab\Models\Package;
use Viserlab\Models\SignalHistory;
use Viserlab\Models\Transaction;
use Viserlab\Models\SupportTicket;
use Viserlab\Models\User;
use Viserlab\BackOffice\Request;

class DashboardController extends Controller
{ 
    public function index()
    {   
        $pageTitle = 'Dashboard';
        $this->pageTitle = $pageTitle;

        $user = viser_auth()->user;
        
        $totalDeposit = Deposit::where('user_id', $user->ID)->where('status', 1)->sum('amount');
        $totalSignal = SignalHistory::where('user_id', $user->ID)->count();
        $totalTrx = Transaction::where('user_id', $user->ID)->count();
        $totalTicket = SupportTicket::where('user_id', $user->ID)->count();
        $latestTrx = Transaction::where('user_id', $user->id)->orderBy('id', 'DESC')->limit(10)->get();

        $package = '';
        if($user->package_id){
            $package = viser_package($user->package_id)->data;
        }

        return $this->view('user/dashboard', compact('user', 'totalDeposit', 'totalSignal', 'totalTrx', 'totalTicket', 'latestTrx', 'package'));
    }

    public function signals(){  

        $pageTitle = 'Signals';
        $this->pageTitle = $pageTitle;

        $user = viser_auth()->user;
        $signals = SignalHistory::where('user_id', $user->ID)->orderBy('id','DESC')->paginate(20);

        return $this->view('user/signals', compact('pageTitle', 'signals'));
    }

    public function purchasePackage(){

        $request = new Request();

        $request->validate([
            'id' => 'required|integer'
        ]);

        $package = Package::where('status', 1)->findOrFail($request->id);

        $user = viser_auth()->user; 
        $user = User::find($user->ID); 
        $currentBalance = viser_balance($user->ID);
        
        if($package->price > $currentBalance){
            $notify[] = ['info', 'Sorry, Insufficient balance'];
            viser_back($notify);
        }

        $user->package_id = $package->id;

        $user->validity = viser_date()->addDays($package->validity)->toDateTime();
        $user->save();

        $afterBalance = $currentBalance - $package->price;
        update_user_meta($user->ID, "viser_balance", $afterBalance);

        $user->save();
       
        $transactions = [
            'user_id'      => $user->ID,
            'amount'       => $package->price,
            'post_balance' => $afterBalance,
            'charge'       => 0,
            'trx_type'     => '-',
            'details'      => __("Purchased ", VISERLAB_PLUGIN_NAME) . $package->name,
            'trx'          => viser_trx(),
            'remark'       => 'purchase',
            'created_at'   => current_time('mysql'),
            'updated_at'   => current_time('mysql')
        ];

        $transaction = new Transaction();
        $transaction->insert($transactions);

        viser_notify($user, 'PURCHASE_COMPLETE', [
            'trx' => $transaction->trx,
            'package' => $package->name,
            'amount' => viser_show_amount($package->price),
            'post_balance' => viser_show_amount($afterBalance),
            'validity' => $package->validity.' Days',
            'expired_validity' => viser_show_date_time($user->validity),
            'purchased_at' => viser_show_date_time($transaction->created_at),
        ]);

        $notify[] = ['success', 'You have purchased '.$package->name.' successfully'];
        viser_back($notify);
    } 

    public function renewPackage(){
        
        $request = new Request();

        $request->validate([
            'id' => 'required|integer'
        ]);

        $package = Package::findOrFail($request->id);

        if(!$package->status){
            $notify[] = ['info', 'Sorry, '.$package->name .' is not available to renew right now'];
            viser_back($notify);
        }

        $user = viser_auth()->user;
        $user = User::find($user->ID); 
        $currentBalance = viser_balance($user->ID);

        if($user->package_id != $package->id){
            $notify[] = ['error', 'Sorry, There is no package to renew'];
            viser_back($notify);
        }

        if($package->price > $currentBalance){
            $notify[] = ['info', 'Sorry, Insufficient balance'];
            viser_back($notify);
        }
 
        $user->validity = viser_date()->parse($user->validity)->addDays($package->validity)->toDateTime();

        $afterBalance = $currentBalance - $package->price;
        update_user_meta($user->ID, "viser_balance", $afterBalance);

        $user->save();

        $transactions = [
            'user_id'      => $user->ID,
            'amount'       => $package->price,
            'post_balance' => $afterBalance,
            'charge'       => 0,
            'trx_type'     => '-',
            'details'      => __("Renewed ", VISERLAB_PLUGIN_NAME) . $package->name,
            'trx'          => viser_trx(),
            'remark'       => 'renew',
            'created_at'   => current_time('mysql'),
            'updated_at'   => current_time('mysql')
        ];

        $transaction = new Transaction();
        $transaction->insert($transactions);

        viser_notify($user, 'RENEW_COMPLETE', [
            'trx' => $transaction->trx,
            'package' => $package->name,
            'amount' => viser_show_amount($package->price),
            'post_balance' => viser_show_amount($afterBalance),
            'validity' => $package->validity.' Days',
            'expired_validity' => viser_show_date_time($user->validity),
            'renew_at' => viser_show_date_time($transaction->created_at),
        ]);

        $notify[] = ['success', 'You have renewed '.$package->name.' successfully'];
        viser_back($notify);
    }

    public function packages(){
        $this->pageTitle = 'Packages';
        return $this->view('user/packages');
    }
 
}
