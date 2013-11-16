<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$digits = $logic->getParam('Digits');

switch (true) {
	
	case $digits === '1':
		$from = $logic->getParam('From');
		$log = $logic->getLogOneByPhoneNumber($from);
		$response = $logic->playRecordMessage($log['record_uri']);
		echo $response;
		break;
		
	case $digits === '9':
		$from = $logic->getParam('From');
		$logic->updateRegisterFlagByPhoneNumber($from, 0);
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: http://' . $_SERVER['SERVER_NAME'] . '/VM/index.php?again=1');
		break;
	
	//入力がない　タイムアウト
	default:

		break;
}
	