<?php

class Config {
	protected $sid = "AC62c895330386650fd7894ecd38c5f20e";
	protected $at = "2a3e9222fa063a6981180bb2b0f5670b";
	protected $db_user = 'root';
	protected $db_pass = '870717ry';
	protected $db_select = 'VM';
	protected $db_server = 'localhost';
	protected $sp_phone_number_start = array(
									//やまね
									'+818014543311' => 'やまねさん、おつかれさまです。いっぱいメッセージがあつまるといいですね。それでは、',
									//おおつる
									'+819058856881' => 'ごけっこんおめでとうございます、たけおさん。あゆみさんへのメッセージをおあずかりしております。',
									//ぐらっちょ
									'+819027009846' => 'ごけっこんおめでとうございます、あゆみさん。たけおさんへのメッセージをおあずかりしております。',
									//たつきさん
									'+819075716426' => 'おつかれさまです、のあみさん。たまにはきちりのあつまりにもいってあげてくださいね。それでは、',
									//みずもと
									'+819085399367' => 'おつかれさまです、みずもとさん。いつもきかくありがとうございます。みなさんかんしゃしていましたよ。それでは、'
									);
	protected $sp_phone_number_end = array(
									//やまね
									'+818014543311' => 'すごくいいメッセージだとおもいます。おふたりによろこんでもらえるといいですね。またごれんらくおまちしています。',
									//おおつる
									'+819058856881'　=> 'すごくいいメッセージだとおもいます。あゆみさんをたいせつにしてくださいね。いつまでもおしあわせに。',
									//ぐらっちょ
									'+819027009846'　=> 'たけおさんがこのメッセージをきくと、きっとおおよろこびするとおもいますよ。いつまでもおしあわせに。'
									);
	
	public function getTwilioId() {
		$config['sid'] = $this->sid;
		$config['at'] = $this->at;
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

