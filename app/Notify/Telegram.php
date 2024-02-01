<?php

namespace Viserlab\Notify;

use Viserlab\Lib\CurlRequest;
use Viserlab\Notify\NotifyProcess;
use Viserlab\Notify\Notifiable;

class Telegram extends NotifyProcess implements Notifiable{

    /**
    * telegram Username of receiver
    *
    * @var string
    */
	public $telegramUsername;


    /**
    * Assign value to properties
    *
    * @return void
    */
	public function __construct(){
		$this->statusField = 'telegram_status';
		$this->body = 'telegram_body';
		$this->globalTemplate = 'viser_telegram_template';
		$this->notifyConfig = 'telegram_config';
	}

    public function send(){
		$setting = viser_to_object( get_option('viser_telegram_config') );
		
        //get message from parent
		$message = $this->getMessage(); 
		if ($message && $this->telegramUsername) {
            try{
				$telegramUserUrl = "https://api.telegram.org/bot". $setting->bot_api_token ."/getUpdates";
	            $results = CurlRequest::curlContent($telegramUserUrl);
	            $jsonUser = json_decode($results);
	            $teleUsers = array();
				
	            foreach($jsonUser->result as $rs){
	                $username =  @$rs->message->from->username;
	                $chat_id =  @$rs->message->from->id;
	                $teleUsers[$username] = $chat_id;
	            }
				
	            if (!array_key_exists($this->telegramUsername, $teleUsers)) {
	            	throw new \Exception("$this->telegramUsername not found in telegram subscribers list");
	            }

	            $chatId = $teleUsers[$this->telegramUsername];
				$sendUrl = "https://api.telegram.org/bot". $setting->bot_api_token ."/sendMessage?chat_id=". $chatId .'&text='. urlencode(strip_tags($message));
				
				CurlRequest::curlContent($sendUrl); 
			}catch(\Exception $e){
				$this->createErrorLog('Telegram Error: '.$e->getMessage());
				viser_session()->flash('telegram_error','Telegram Error: '.$e->getMessage());
			}
        }
    }


    /**
    * Configure some properties
    *
    * @return void
    */
	public function prevConfiguration(){ 
		if ($this->user) {
            $this->telegramUsername = $this->user->telegram_username;
			$this->receiverName = $this->user->fullname;
		}
		$this->toAddress = $this->telegramUsername;
	}

}
