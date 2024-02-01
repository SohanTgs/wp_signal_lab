<?php

namespace Viserlab\Controllers;

use Viserlab\Lib\SignalLab; 
use Viserlab\Models\Signal;

class CronController extends Controller{

    public function cron(){
        
        $signals = Signal::where('status', 1)->where('send', 0)->where('send_signal_at', '<=', viser_date()->now())->limit(50)->get();
     
        foreach($signals as $signal){ 
            SignalLab::send($signal); 
            $signal->send = 1;
            $signal->save();
        }

    }

}


