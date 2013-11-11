<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$digits = $logic->getParam('Digits');

if (!empty($digits) && $digits === '#') {
	
	//db登録
	$_param['phone_number'] = $logic->getParam('From');
	$_param['record_uri'] = $logic->getParam('RecordingUrl');
	$_param['register_flag'] = 1;
	$logic->insertLog($_param);
	
	//レスポンス作成
	$response = $logic->completedRecordCheack();
	echo $response;
	
} else {
	
	switch ($digits) {
		//もう一度録音
		case 1:
			
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: http://' . $_SERVER['SERVER_NAME'] . '/VM/index.php?again=1');
			break;
		
		//終了
		case 9:
			
			$response = $logic->completedRecordEnd();
			echo $response;
			break;
		
		default:
			
			break;
	}
	
}