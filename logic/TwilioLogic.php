<?php

require (dirname(__FILE__) . '/../config/config.php');
require ('TwilioUtil.php');
require ('Database.php');

class TwilioLogic extends TwilioUtil{
	
	function __construct(){
		parent::__construct();
	}

	//index.php　録音開始コンタクト
	public function record() {
		$response = $this->getTwiml();
		$response->say("おでんわありがとうございます。おおつるさん、やなぎもとさんへのメッセージをうけつけしております。
			はっしんおんのあとにおなまえ、メッセージをおねがいいたします。ろくおんをとちゅうでしゅうりょうするばあいはシャープをおしてください。それではどうぞ。", array('language' => 'ja-jp'));
		$response->record(array('maxLength' => '60', 'finishOnKey' => '#', 'action' => '/VM/completed_record.php'));
		return $response;
	}
	
	//index.php　再度録音開始コンタクト
	public function recordAgain() {
		$response = $this->getTwiml();
		$response->say("はっしんおんのあとにおなまえ、メッセージをおねがいいたします。ろくおんをとちゅうでしゅうりょうするばあいはシャープをおしてください。それではどうぞ。", array('language' => 'ja-jp'));
		$response->record(array('maxLength' => '60', 'finishOnKey' => '#', 'action' => '/VM/completed_record.php'));
		return $response;
	}
	
	//completed_record.php　録音完了後の確認コンタクト
	public function completedRecordCheack() {
		$response = $this->getTwiml();
		$gather = $response->gather(array('numDigits' => 1, 'timeout' => '20'));
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
	
	public function saveRecordMp3($uri) {
		
	}
	
	
}

