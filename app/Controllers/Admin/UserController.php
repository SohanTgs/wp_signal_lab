<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Models\Deposit;
use Viserlab\Models\SignalHistory;
use Viserlab\Models\Transaction;
use Viserlab\Models\User;

class UserController extends Controller
{
    public function allUsers()
    {
        $request = new Request();
        $pageTitle = "All Users";
        if($request->search){
            $users = User::where('user_login', urldecode($request->search))->orWhere('user_email', urldecode($request->search))->orderBy('id', 'DESC')->paginate(viser_paginate());
        } else {
            $users = User::orderBy('id', 'DESC')->paginate(viser_paginate());
        }
        $this->view('admin/users/list', compact('pageTitle', 'users'));
    }

    public function userDetail()
    {
        $request = new Request();
        $user = User::find($request->id);
        if (!$user) {
            viser_abort(404);
        } 
        $pageTitle = "User Detail - " . $user->user_login;
        $countries  = json_decode(file_get_contents(VISERLAB_ROOT . 'views/partials/country.json'));
        $totalDeposit = Deposit::where('user_id', $user->ID)->where('status', 1)->sum('amount');
        $totalTransaction = Transaction::where('user_id', $user->ID)->count();
        $totalSignal = SignalHistory::where('user_id', $user->ID)->count();
        $this->view('admin/users/detail', compact('pageTitle', 'user', 'countries', 'totalDeposit', 'totalTransaction', 'totalSignal'));
    }

    public function userUpdate()
    {
        $request = new Request();
        $request->validate([
            'display_name' => 'required',
            'email'        => 'required|email',
            'mobile'       => 'required',
            'country'      => 'required'
        ]);
        $user = User::find($request->id);
        if (!$user) {
            viser_abort(404);
        }

        $countryData  = json_decode(file_get_contents(VISERLAB_ROOT . 'views/partials/country.json'));
        $countryArray = (array)$countryData;
        $countries    = implode(',', array_keys($countryArray));
        $countryCode  = $request->country;
        $country      = $countryData->$countryCode->country;
        $dialCode     = $countryData->$countryCode->dial_code;
        
        $userData = [
            'ID'           => intval($user->ID),
            'display_name' => sanitize_text_field($request->display_name)
        ];

        $user_id = wp_update_user($userData);

        update_user_meta($user_id, 'viser_mobile', sanitize_text_field($dialCode.$request->mobile));
        update_user_meta($user_id, 'viser_country_code', sanitize_text_field($countryCode));
        update_user_meta($user_id, 'viser_country', sanitize_text_field($country));
        update_user_meta($user_id, 'viser_address', sanitize_text_field($request->address));
        update_user_meta($user_id, 'viser_city', sanitize_text_field($request->city));
        update_user_meta($user_id, 'viser_state', sanitize_text_field($request->state));
        update_user_meta($user_id, 'viser_zip', sanitize_text_field($request->zip));

        update_user_meta($user->ID, 'viser_ban', $request->ban ? 1 : 0);

        $notify[] = ['success', 'User details updated successfully'];
        viser_back($notify);
    }

}
