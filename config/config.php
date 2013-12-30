<?php

class Config {
	//test 815031595818
	protected $test_my_phone_number = '';
	protected $test_sid = "";
	protected $test_at = "";
	//production 815031596185
	protected $production_my_phone_number = '';
	protected $production_sid = "";
	protected $production_at = "";
		
	protected $db_user = '';
	protected $db_pass = '';
	protected $db_select = '';
	protected $db_server = '';
	protected $sp_phone_number_start = array(
									);
	protected $sp_phone_number_end = array(
									);
	
	public function getTwilioId($to) {
		//test以外はproductionでわたす
		if ($to === $this->test_my_phone_number) {
			$config['sid'] = $this->test_sid;
			$config['at'] = $this->test_at;
			error_log('test!!');
		} else {
			$config['sid'] = $this->production_sid;
			$config['at'] = $this->production_at;
		}
		return $config;
	}
	public function getDbParam() {
		$db_param['user'] = $this->db_user;
		$db_param['pass'] = $this->db_pass;
		$db_param['select'] = $this->db_select;
		$db_param['server'] = $this->db_server;
		
		return $db_param;
	}
	public function getSpPhoneNumber() {
		$sp_phone_number['start'] = $this->sp_phone_number_start;
		$sp_phone_number['end'] = $this->sp_phone_number_end;
		
		return $sp_phone_number;
		
	}
}

