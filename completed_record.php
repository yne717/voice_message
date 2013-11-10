<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
$completed = $logic->getParam('completed');
$digits = $logic->getParam('Digits');

if (empty($completed)) {

	switch ($digits) {
		case 1:
			
			header("HTTP/1.1 301 Moved Permanently");
			header('Location: http://' . $_SERVER['SERVER_NAME'] . '/VM/index.php?again=1');
			break;
		
		case 9:
			
			//db登録、音声ファイルダウンロード
			
			
			$response = $logic->completedRecordEnd();
			echo $response;
			break;
		
		default:
			
			break;
	}
	
} else {
	$response = $logic->completedRecordCheack();
	echo $response;
}