<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$digits = $logic->getParam('Digits');

if (!$empty($digits) && $digits === '#') {
	// if(true) {
			
	//db登録
	$_param['phone_number'] = $logic->getParam('From');
	$_param['record_uri'] = $logic->getParam('RecordingUrl');
	$_param['register_flag'] = 0;
	$logic->insertLog($_param);

	//レスポンス作成
	$response = $logic->completedRecordCheack();
	echo $response;
	
} else {

	$response = $logic->error();
	error_log('<error> completed_record');
	echo $response;
	
}