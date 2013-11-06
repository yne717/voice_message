<?php

require ('TwilioUtil.php');

class TwilioLogic extends TwilioUtil{
	
	function __construct(){
		parent::__construct();
	}

	//一番最初のコンタクト
	public function firstContact() {
		$gather = $this->_response->gather(array('numDigits' => 1, 'timeout' => '20'));
		$gather->say("お電話有難うございます。おおつるさん、やなぎもとさんへのメッセージを受付しております。
	            ボイスメッセージを登録する場合は１を、登録したボイスメッセージの確認は２を、もう一度再生する場合は３を押してください。", array('language' => 'ja-jp'));
		return $this->_response;
	}
}

