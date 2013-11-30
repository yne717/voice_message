<?php

require (dirname(__FILE__) . '/../config/config.php');
require ('TwilioUtil.php');
require ('Database.php');

class TwilioLogic extends TwilioUtil{
	
	public $file_type = '.mp3';
	public $save_path = '/var/www/html/VM/record/';
	public $default_start_message = 'おでんわありがとうございます。おおつるさんたちへのメッセージをうけつけしております。';
	public $default_end_message = 'あなたのメッセージはごじつ、おふたりにおとどけいたします。ごきょうりょくありがとうございました。';
	public $sp_phone_number_start = array();
	public $sp_phone_number_end = array();

	
	function __construct(){
		parent::__construct();
		$sp_phone_number = $this->_config->getSpPhoneNumber();
		$this->sp_phone_number_start = $sp_phone_number['start'];
		$this->sp_phone_number_end = $sp_phone_number['end'];
	}
	
	public function timeOut() {
		$response = $this->getTwiml();
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		
		return $response;
	}
	
	public function error() {
		$response = $this->getTwiml();
		$response->say("エラーがはっせいしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		error_log('<error> function error');
		
		return $response;
	}
	
	public function finish() {
		$response = $this->getTwiml();
		$response->hangup();
		
		return $response;
	}
	
	public function sayGatherElse($number1, $number2, $url) {
		$response = $this->getTwiml();
		$gather = $response->gather(array('numDigits' => 1, 'timeout' => '10', 'action' => $url));
		$gather->say($number1 . "、か、" . $number2 . "、をおしてください。しゅうりょうするばあいはそのままでんわをおきりください。", array('language' => 'ja-jp'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		
		return $response;
	}

	//index.php　録音開始コンタクト
	public function index() {
		$response = $this->getTwiml();
		
		
		
		$response->say("はっしんおんのあとに、おなまえ、メッセージをおねがいします。かんりょうしましたらシャープをおしてしゅうりょうしてくださいね。ではどうぞ。", array('language' => 'ja-jp'));
		$response->record(array('maxLength' => '30', 'finishOnKey' => '#', 'action' => '/VM/completed_record.php'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	//index.php　再度録音開始コンタクト
	public function indexAgain() {
		$response = $this->getTwiml();
		$response->say("はっしんおんのあとに、おなまえ、メッセージをおねがいします。ろくおんがかんりょうしましたらシャープをおしてしゅうりょうしてくださいね。それではどうぞ。", array('language' => 'ja-jp'));
		$response->record(array('maxLength' => '30', 'finishOnKey' => '#', 'action' => '/VM/completed_record.php'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	public function indexRecordPlayCheck() {
		$response = $this->getTwiml();
		$gather = $response->gather(array('numDigits' => 1, 'timeout' => '10', 'action' => "/VM/play_record.php"));
		$gather->say("おでんわありがとうございます。おあずかりしているメッセージをかくにんするばあいは1を、ろくおんしなおすばあいは9をおしてください。しゅうりょうするばあいはそのままでんわをおきりください。", array('language' => 'ja-jp'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	public function playRecordMessage($url) {
		$response = $this->getTwiml();
		$response->play($url);
		$gather = $response->gather(array('numDigits' => 1, 'timeout' => '10', 'action' => "/VM/play_record_after.php"));
		$gather->say("メッセージをろくおんしなおすばあいは1を、しゅうりょうするばあいは9をおしてください。", array('language' => 'ja-jp'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}

	
	//completed_record.php　録音完了後の確認コンタクト
	public function completedRecordCheack() {
		$response = $this->getTwiml();
		$gather = $response->gather(array('numDigits' => 1, 'timeout' => '10', 'action' => "/VM/completed_record_after.php"));
		$gather->say("ろくおんがかんりょうしました。メッセージをろくおんしなおすばあいは1を、とうろくするばあいは9をおしてください", array('language' => 'ja-jp'));
		$response->say("タイムアウトしました。もういちどさいしょからおねがいいたします。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	//completed_record.php　録音完了後の終了コンタクト
	public function completedRecordEnd() {
		$response = $this->getTwiml();
		
		
		
		
		$response->say("あなたのメッセージはごじつ、おふたりにおとどけいたします。ごきょうりょくありがとうございました。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	//*************************************************
	
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
	public function getLogOneByPhoneNumber($phone_number, $register_flag = null) {
		$database = new Database();
		
		$param['phone_number'] = $phone_number;
		if (!is_null($register_flag)){
			$param['register_flag'] = $register_flag;
		}
		$result = $database->getLogOne($param);
		
		return $result;
	}
	
	
	public function updateRegisterFlagByPhoneNumber($phone_number, $register_flag = null) {
		$database = new Database();
		
		$param['phone_number'] = $phone_number;
		if (!is_null($register_flag)){
			$param['register_flag'] = $register_flag;
		}
		$database->updateRegisterFlag($param);
	}
	
	public function updateRegisterFlagByLogId($log_id, $register_flag = null) {
		$database = new Database();
		
		$param['log_id'] = $log_id;
		if (!is_null($register_flag)){
			$param['register_flag'] = $register_flag;
		}
		$database->updateRegisterFlag($param);
	}
	
	public function saveRecordFile($log_id, $url) {
		//mp3でダウンロード
		$_url = $url . $this->file_type;
		$_path = $this->save_path . $log_id . $this->file_type;
		// $command = 'wget -O ' . $_path . ' ' . $_url . ' >>' . $this->save_path . '.wget.log';
		$command = 'nohup wget -O ' . $_path . ' ' . $_url . ' > /dev/null &';
		
		exec($command);
	}
	
	public function checkFileExist($log_id) {
		$_path = $this->save_path . $log_id . $this->file_type;
		return file_exists($_path);
	}
	
	public function changeFileName($log_id) {
		$_path = $this->save_path . $log_id . $this->file_type;
		$_parh_after = $_path . '.' . date("mdGi");
		$result = rename($_path, $_parh_after);
		if (!$result) {
			error_log('<error> failure file name change');
		}
		return $result;
	}
	
	
}

