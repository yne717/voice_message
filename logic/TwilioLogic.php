<?php

class TwilioLogic {
	public $_client = '';
	public $_response = '';
	public $_param = array();
	public $_special_number = array();
	
	function __construct($client, $response){
		$this->_client = $client;
		$this->_response = $response;
		
		foreach ($_REQUEST as $key => $value) {
			$this->_param[$key] = $value;
		}
		error_log('********************logic construct**********************');
		error_log(print_r($this->_param, true));
	}
	
	//パラメータ取得
	public function getParam($key = null) {
		$result = null;
		
		if (!empty($key)) {
			$result = $this->_param[$key];
		} else {
			$result = $this->_param;
		}
		
		return $result;
	}
	
	//一番最初のコンタクト
	public function firstContact() {
		$gather = $this->_response->gather(array('numDigits' => 100, 'timeout' => '20'));
		$gather->say("お電話有難うございます。おおつるさん、やなぎもとさんへのメッセージを受付しております。
	            ボイスメッセージを登録する場合は１を、登録したボイスメッセージの確認は２を、もう一度再生する場合は３を押してください。", array('language' => 'ja-jp'));
		return $this->_response;
	}
	
}

