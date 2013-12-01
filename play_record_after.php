<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$digits = $logic->getParam('Digits');

switch (true) {
	
	//録音しなおし
	case $digits === '9':
		$from = $logic->getParam('From');
		//log取得
		$log = $logic->getLogOneByPhoneNumber($from);
		//register_flag更新
		$logic->updateRegisterFlagByLogId($log['log_id'], 0);
		//ファイル名変更
		$check = $logic->checkFileExist($log['log_id']);
		if ($check) {
			$logic->changeFileName($log['log_id']);
		} else {
			error_log('<error> not file');
		}
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: http://' . $_SERVER['SERVER_NAME'] . '/VM/index.php?again=1');
		break;
	
	//終了
	case $digits === '1':
		$response = $logic->finish();
		echo $response;
		break;
	
	//入力がない　タイムアウト
	default:
		$response = $logic->sayGatherElse(1, 9, '/VM/play_record.php');
		echo $response;
		break;
}
	