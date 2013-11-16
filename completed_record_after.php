<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$digits = $logic->getParam('Digits');

switch (true) {
	//もう一度録音
	case $digits === '1':
		
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: http://' . $_SERVER['SERVER_NAME'] . '/VM/index.php?again=1');
		break;
	
	//終了
	case $digits === '9':
		
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
		$logic->updateRegisterFlagByLogId($log['log_id'], 1);
		
		$response = $logic->completedRecordEnd();
		echo $response;
		break;
	
	//入力がない　タイムアウト
	default:

		break;
}