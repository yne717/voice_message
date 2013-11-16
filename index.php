<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();

//log取得
$phone_number = $logic->getParam('From');
$log = $logic->getLogOneByPhoneNumber($phone_number);
//既にメッセージが登録されているか
$exist = $logic->checkFileExist($log['log_id']);

//録音されているかチェック
if (!empty($log) && $log['register_flag'] === '1' && $exist) {
	$response = $logic->indexRecordPlayCheck();
	echo $response;
	
} else {
	//されていなければ録音
	$again = $logic->getParam('again');
	if (empty($again)) {
		$response = $logic->index();
		echo $response;
	} else {
		$response = $logic->indexAgain();
		echo $response;
	}
}