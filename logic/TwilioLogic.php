<?php

require ('TwilioUtil.php');

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
		$response->say("あなたのメッセージはごじつおふたりにおとどけいたします。ごきょうりょくありがとうございました。", array('language' => 'ja-jp'));
		$response->hangup();
		return $response;
	}
	
	
}

