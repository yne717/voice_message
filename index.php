<?php
require ('lib/twilio/Services/Twilio.php');
require ('config/config.php');
require ('logic/TwilioLogic.php');

$config = new config();
$id = $config->getTwilioId();

$client = new Services_Twilio($id['sid'], $id['at']);
$response = new Services_Twilio_Twiml();

$logic = new TwilioLogic($client, $response);

if (isset($_REQUEST['Digits'])) {
	// error_log(print_r($logic->getParam()));
	$input = $_REQUEST['Digits'];
	switch ($input) {
		//録音
		case '1' :
			$gather = $response -> gather(array('numDigits' => 1, 'timeout' => '10'));
			$gather -> say('1 を押しやがりましたね、今月の請求額は、わかりません。', array('language' => 'ja-jp'));
			break;
			
		//確認
		case '2' :
			$gather = $response -> gather(array('numDigits' => 1, 'timeout' => '10'));
			$gather -> say('2 を押しやがりましたね、先月の請求額は、わかりません。', array('language' => 'ja-jp'));
			break;

		default :
			$gather = $response -> gather(array('numDigits' => 1, 'timeout' => '10'));
			$gather -> say('おおつるさん、やなぎもとさんへのメッセージを受付しております。
            ボイスメッセージを登録する場合は１を、登録したボイスメッセージの確認は２を、もう一度再生する場合は３を押してください。', array('language' => 'ja-jp'));
			break;
	}
	print $response;
	
} else {
	$result = $logic->firstContact();
	echo $result;
}
