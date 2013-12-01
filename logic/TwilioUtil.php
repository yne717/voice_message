<?php

require (dirname(__FILE__) . '/../lib/twilio/Services/Twilio.php');

class TwilioUtil{
	public $_config = null;
	public $_client = null;
	public $_id = array();
	public $_param = array();
	public $_param_get = array();
	public $_param_post = array();
	public $_sp_phone_number_start = array();
	
	function __construct(){
		//param取得
		if (!empty($_GET)) {
			foreach ($_GET as $key => $value) {
				$this->_param[$key] = $value;
				$this->_param_get[$key] = $value;
			}
		}
		if (!empty($_POST)) {
			foreach ($_POST as $key => $value) {
				$this->_param[$key] = $value;
				$this->_param_post[$key] = $value;
			}
		}		
		error_log(print_r($_SERVER['REQUEST_URI'], true));
		error_log(print_r($this->_param_get, true));
		error_log(print_r($this->_param_post, true));
		
		//sid,at取得
		$this->_config = new config();
		$to = $this->getParam('To');
		$this->_id = $this->_config->getTwilioId($to);
		//twilioインスタンス取得
		$this->_client = new Services_Twilio($this->_id['sid'], $this->_id['at']);
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
