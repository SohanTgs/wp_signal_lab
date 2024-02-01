<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\Lib\SignalLab;
use Viserlab\Models\Signal;
use Viserlab\Models\Package;
use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
 
class SignalController extends Controller{

    public function all(){ 
        $pageTitle = 'Manage Signals';
        $signals = $this->signalData();
        return $this->view('admin/signal/all', compact('pageTitle', 'signals'));
    }

    public function sent(){  
        $pageTitle = 'Sent Signals';
        $signals = $this->signalData('sent');
        return $this->view('admin/signal/all', compact('pageTitle', 'signals'));
    }

    public function notSent(){ 
        $pageTitle = 'Not Sent Signals';
        $signals = $this->signalData('notSent');
        return $this->view('admin/signal/all', compact('pageTitle', 'signals'));
    }

    public function addPage(){ 
        $pageTitle = 'Add New Signal';
        $packages = Package::orderBy('id', 'DESC')->get(); 
        $sendVia = sendVia(); 
        return $this->view('admin/signal/add', compact('pageTitle', 'packages', 'sendVia'));
    }

    public function add(){ 

        $request = new Request(); 
        $request->validate([
            'name'=> 'required|max:250',
            'signal'=> 'required',
            'set_time'=> 'required|in:0,1',
        ]);

        if($request->set_time == 1 && $request->minute < 0){
            $notify[] = ['error', 'The minute field must be an integer and greater than zero'];
            viser_back($notify);
        }

        if(!$request->packages){
            $notify[] = ['error', 'The package field is required'];
            viser_back($notify);
        }

        if(count($request->packages) != Package::whereIn('id', $request->packages)->count()){
            $notify[] = ['error', 'Invalid package id'];
            viser_back($notify);
        }

        if(!$request->send_via){
            $notify[] = ['error', 'The send via field is required'];
            viser_back($notify);
        }

        $send = 1;
        $setTime = 0;
        $sendSignalAt = null;

        // When set minute / time
        if($request->set_time == 1){
            $setTime = $request->minute;
            $sendSignalAt = viser_date()->addMinutes($request->minute)->toDateTime();
            $send = 0;
        }

        $signal = new Signal();
        $signal->package_id = json_encode($request->packages);
        $signal->send_via = json_encode($request->send_via);
        $signal->name = $request->name;
        $signal->signal = $request->signal;
        $signal->minute = $setTime;
        $signal->send = $send;
        $signal->status = $request->status ? 1 : 0;
        $signal->send_signal_at = $sendSignalAt;
        $signal->created_at = current_time('mysql');
        $signal->updated_at = current_time('mysql');
        $signal->save();

        // When send now
        if($request->set_time == 0){ 
            SignalLab::send($signal);
        }

        $contact = $request->set_time == 0 ? 'sent' : 'added';

        $notify[] = ['success', 'Signal '.$contact.' successfully'];
        viser_redirect(viser_route_link('admin.signal.edit', false).'&id='.intval($signal->id), $notify); 
    }

    public function edit(){    
        $request = new Request();      
        $signal = Signal::findOrFail($request->id);
        $pageTitle = 'Edit Signal';
        $packages = Package::orderBy('id', 'DESC')->get(['id', 'name']); 
        $sendVia = sendVia(); 
        return $this->view('admin/signal/edit', compact('pageTitle', 'signal', 'packages', 'sendVia'));
    }

    public function update(){
        
        $request = new Request();        
        $request->validate([
            'id'=> 'required|integer',
            'name'=> 'required|max:250',
            'signal'=> 'required',
            'set_time'=> 'required|in:0,1',
        ]);

        $signal = Signal::findOrFail($request->id);
        $setTime = $request->minute ?? 0;

        if($request->set_time == 1 && $request->minute < 0){
            $notify[] = ['error', 'The minute field must be an integer and greater than zero'];
            viser_back($notify);
        }

        if(!$request->packages){
            $notify[] = ['error', 'The package field is required'];
            viser_back($notify);
        }

        if(count($request->packages) != Package::whereIn('id', $request->packages)->count()){
            $notify[] = ['error', 'Invalid package id'];
            viser_back($notify);
        }

        if(!$request->send_via){
            $notify[] = ['error', 'The send via field is required'];
            viser_back($notify);
        }

        $signal->package_id = json_encode($request->packages);
        $signal->send_via = json_encode($request->send_via);
        $signal->name = $request->name;
        $signal->signal = $request->signal;
        $signal->minute = $setTime;
        $signal->status = $request->status ? 1 : 0;
        $signal->send = 1;

        // When send now
        if($request->set_time == 0 && !$signal->send){ 
            SignalLab::send($signal);
        }elseif($request->resend && $signal->send){ 
            SignalLab::send($signal, true);
        }
        
        // When set minute / time
        if($request->set_time == 1 && !$signal->send){
            $signal->send_signal_at = viser_date()->addMinutes($request->minute)->toDateTime();
        }

        $signal->updated_at = current_time('mysql');
        $signal->save(); 
    
        $contact = $request->set_time == 0 ? 'sent' : 'updated';

        $notify[] = ['success', 'Signal '.$contact.' successfully'];
        viser_back($notify);
    }

    public function delete(){
 
        $request = new Request();      
        $signal = Signal::findOrFail($request->id);
        $signal->delete();

        $notify[] = ['success', 'Signal deleted Successfully'];
        viser_back($notify);
    }

    protected function signalData($scope = null){
      
        if($scope){    
            $status = ['notSent'=> 0, 'sent'=> 1];
            $status = $status[$scope];
            $signals = Signal::where('send', $status)->orderBy('id', 'DESC')->paginate(viser_paginate());
        }else{ 
            $signals = Signal::orderBy('id', 'DESC')->paginate(viser_paginate());
        }
        
        return $signals;
    }

}
