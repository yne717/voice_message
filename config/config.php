<?php

class Config {
	protected $sid = "AC62c895330386650fd7894ecd38c5f20e";
	protected $at = "2a3e9222fa063a6981180bb2b0f5670b";
	
	public function getTwilioId() {
		$config['sid'] = $this->sid;
		$config['at'] = $this->at;
		return $config;
	}
	
}
