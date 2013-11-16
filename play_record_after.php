<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$digits = $logic->getParam('Digits');

switch (true) {
	
	//録音しなおし
	case $digits === '1':
		$from = $logic->getParam('From');
		$logic->updateRegisterFlagByPhoneNumber($from, 0);
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: http://' . $_SERVER['SERVER_NAME'] . '/VM/index.php?again=1');
		break;
	
	//終了
	case $digits === '9':
		$response = $logic->finish();
		echo $response;
		break;
	
	//入力がない　タイムアウト
	default:

		break;
}
	