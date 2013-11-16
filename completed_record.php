<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$digits = $logic->getParam('Digits');

if ($digits === '#') {
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
	
	switch ($digits) {
		//もう一度録音
		case 1:
			
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: http://' . $_SERVER['SERVER_NAME'] . '/VM/index.php?again=1');
			break;
		
		//終了
		case 9:
			
			//番号取得
			$from = $logic->getParam('From');
			//lgo_id取得
			$log = $logic->getLogOneByPhoneNumber($from);
			if (!$log) {
				//エラーメッセージ
				$error = $logic->error();
				echo $error;
				break;
			}
			
			//ファイル取得
			$logic->saveRecordFile($log['log_id'], $log['record_uri']);
			//register_flag更新
			$logic->updateRegisterFlagByLogId($log['log_id']);
			
			$response = $logic->completedRecordEnd();
			echo $response;
			break;
		
		//入力がない　タイムアウト
		default:
			
			$response = $logic->timeOut();
			echo $response;
			break;
	}
	
}