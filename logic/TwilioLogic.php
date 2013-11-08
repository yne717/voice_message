<?php

require ('TwilioUtil.php');

class TwilioLogic extends TwilioUtil{
	
	function __construct(){
		parent::__construct();
	}

	//一番最初のコンタクト
	public function firstRecordContact() {
		// $gather = $this->_response->gather(array('numDigits' => 1, 'timeout' => '20'));
		// $gather->say("お電話有難うございます。おおつるさん、やなぎもとさんへのメッセージを受付しております。
	            // 発信音の後にメッセージ、お名前をお願い致します。それではどうぞ。", array('language' => 'ja-jp'));
		// return $this->_response;
		$response = $this->getTwiml();
		$response->say("お電話有難うございます。おおつるさん、やなぎもとさんへのメッセージを受付しております。
			発信音の後にメッセージ、お名前をお願い致します。終了したい場合は9を押してください。それではどうぞ。", array('language' => 'ja-jp'));
		$response->record(array('maxLength' => '10', 'finishOnKey' => '9', 'action' => ''));
		return $response;
	}
}

