<?php

require (dirname(__FILE__) . '/../config/config.php');
require ('TwilioUtil.php');
require ('Database.php');

class TwilioLogic extends TwilioUtil{
	
	public $file_type = '.mp3';
	public $save_path = '/var/www/html/VM/record/';
	
	function __construct(){
		parent::__construct();
	}
	
	public function timeOut() {
		$response = $this->getTwiml();
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		
		return $response;
	}

	//index.php　録音開始コンタクト
	public function record() {
		$response = $this->getTwiml();
		$response->say("おでんわありがとうございます。おおつるさん、やなぎもとさんへのメッセージをうけつけしております。
			はっしんおんのあとにおなまえ、メッセージをおねがいいたします。ろくおんがかんりょうしましたらシャープをおしてしゅうりょうしてください。それではどうぞ。", array('language' => 'ja-jp'));
		$response->record(array('maxLength' => '30', 'finishOnKey' => '#', 'action' => '/VM/completed_record.php'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	//index.php　再度録音開始コンタクト
	public function recordAgain() {
		$response = $this->getTwiml();
		$response->say("はっしんおんのあとにおなまえ、メッセージをおねがいいたします。ろくおんがかんりょうしましたらシャープをおしてしゅうりょうしてください。それではどうぞ。", array('language' => 'ja-jp'));
		$response->record(array('maxLength' => '30', 'finishOnKey' => '#', 'action' => '/VM/completed_record.php'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	//completed_record.php　録音完了後の確認コンタクト
	public function completedRecordCheack() {
		$response = $this->getTwiml();
		$gather = $response->gather(array('numDigits' => 1, 'timeout' => '10'));
		$gather->say("ろくおんがかんりょうしました。メッセージをろくおんしなおすばあいは1を、しゅうりょうするばあいは9をおしてください", array('language' => 'ja-jp'));
		return $response;
	}
	
	//completed_record.php　録音完了後の終了コンタクト
	public function completedRecordEnd() {
		$response = $this->getTwiml();
		$response->say("あなたのメッセージはごじつ、おふたりにおとどけいたします。ごきょうりょくありがとうございました。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	//phone_number,record_uri,register_flagが必要
	public function insertLog($_param = array()) {
		$database = new Database();
		
		$param['log_id'] = null;
		$param['phone_number'] = $_param['phone_number'];
		$param['record_uri'] = $_param['record_uri'];
		$param['register_flag'] = $_param['register_flag'];
		$param['create_date'] = date("Y-m-d H:i:s");
		$param['update_date'] = null;
		
		$result = $database->insertLog($param);
	}
	
	//デフォルトはregister_flagが0のデータ
	public function getLogOneByPhoneNumber($phone_number, $register_flag = 0) {
		$database = new Database();
		
		$param['phone_number'] = $phone_number;
		$param['register_flag'] = $register_flag;
		$result = $database->getLogOne($param);
		
		return $result;
	}
	
	
	public function updateRegisterFlagByPhoneNumber($phone_number, $register_flag = 0) {
		$database = new Database();
		
		$param['phone_number'] = $phone_number;
		$param['register_flag'] = $register_flag;
		$result = $database->updateRegisterFlag($param);
		
		return $return;
	}
	
	public function updateRegisterFlagByLogId($log_id) {
		$database = new Database();
		
		$param['log_id'] = $log_id;
		$result = $database->updateRegisterFlag($param);
		
		return $return;
	}
	
	public function saveRecordFile($log_id, $url) {
		//mp3でダウンロード
		$_url = $url . $this->file_type;
		$_path = $this->save_path . $log_id . $this->file_type;
		// $command = 'wget -O ' . $_path . ' ' . $_url . ' >>' . $this->save_path . '.wget.log';
		$command = 'nohup wget -O ' . $_path . ' ' . $_url . ' > /dev/null &';
		
		exec($command);
	}
	
	
}

