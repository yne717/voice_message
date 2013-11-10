<?php

require (dirname(__FILE__) . '/../lib/twilio/Services/Twilio.php');
require (dirname(__FILE__) . '/../config/config.php');

class TwilioUtil{
	public $_config = null;
	public $_client = null;
	public $_id = array();
	public $_param = array();
	public $_special_phone_number = array();
	
	function __construct(){
		//sid,at取得
		$this->_config = new config();
		$this->_id = $this->_config->getTwilioId();
		//twilioインスタンス取得
		$this->_client = new Services_Twilio($this->_id['sid'], $this->_id['at']);
		//param取得
		foreach ($_REQUEST as $key => $value) {
			$this->_param[$key] = $value;
		}
		error_log(print_r($this->_param, true));
	}
		
	//パラメータ取得
	public function getParam($key = null) {
		$result = null;
		if (!empty($key)) {
			if (!empty($this->_param[$key])) {
				$result = $this->_param[$key];
			}
		} else {
			$result = $this->_param;
		}
		return $result;
	}
	
	public function getTwiml() {
		return new Services_Twilio_Twiml();
	}
	
	
}
