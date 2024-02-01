<?php

namespace Viserlab\Notify;

use Viserlab\Notify\NotifyProcess;
use Viserlab\Notify\SmsGateway;
use Viserlab\Notify\Notifiable;


class Sms extends NotifyProcess implements Notifiable{

    /**
    * Mobile number of receiver
    *
    * @var string
    */
	public $mobile;

    /**
    * Assign value to properties
    *
    * @return void
    */
	public function __construct(){
		$this->statusField = 'sms_status';
		$this->body = 'sms_body';
		$this->globalTemplate = 'viser_sms_body';
		$this->notifyConfig = 'sms_config';
	}

    /**
    * Send notification
    *
    * @return void|bool
    */
	public function send(){

		//get message from parent
		$message = $this->getMessage();
		if ( get_option('viser_sms_notification') && $message) {
			try {
                $sms_config = viser_to_object( get_option('viser_sms_config') );
				$gateway = $sms_config->name;
                if($this->mobile){
                    $sendSms = new SmsGateway();
                    $sendSms->to = $this->mobile;
                    $sendSms->from = get_option('viser_sms_from');
                    $sendSms->message = strip_tags($message);
                    $sendSms->config = $sms_config;
                    $sendSms->$gateway();
                    // $this->createLog('sms');
                }
			} catch (\Exception $e) {
				$this->createErrorLog('SMS Error: '.$e->getMessage());
				viser_session()->flash('sms_error','API Error: '.$e->getMessage());
			}
		}

	}

    /**
    * Configure some properties
    *
    * @return void
    */
	public function prevConfiguration(){
		//Check If User
		if ($this->user) {
			$this->mobile = $this->user->mobile;
			$this->receiverName = $this->user->fullname;
		}
		$this->toAddress = $this->mobile;
	}
}
