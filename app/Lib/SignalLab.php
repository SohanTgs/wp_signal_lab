<?php

namespace Viserlab\Lib;

use Viserlab\Models\User;
use Viserlab\Models\SignalHistory;

class SignalLab{

    public static function send($signal, $update = false){
      
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        if($signal->package_id == null || $signal->package_id == 'null'){ 
            return false;
        }else{
            $packagesId = json_decode($signal->package_id);

            $users = User::whereIn('package_id', $packagesId)->where('validity', '>=', viser_date()->now())->get();
            $signal->send_signal_at = viser_date()->now();
            $signal->save();
         
            foreach($users as $user){
                
                if(!$update){
                    $signalHistory = new SignalHistory();
                    $signalHistory->user_id = $user->ID;
                    $signalHistory->signal_id = $signal->id;
                    $signalHistory->created_at = current_time('mysql');
                    $signalHistory->updated_at = current_time('mysql');
                    $signalHistory->save();
                }
                
                $package = viser_package($user->package_id);

                viser_notify($user, 'SIGNAL_NOTIFICATION', [
                    'package'=> $package ? $package->name : 'N/A',
                    'validity'=> $user->validity ? viser_show_date_time($user->validity) : 'N/A',
                    'signal_name'=> $signal->name,
                    'signal_details'=> $signal->signal,
                ],json_decode($signal->send_via));
            }
        }
    }

}
