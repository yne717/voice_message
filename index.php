<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();

//録音されているかチェック

//されていなければ録音
$again = $logic->getParam('again');
if (empty($again)) {
	$response = $logic->record();
	echo $response;
} else {
	$response = $logic->recordAgain();
	echo $response;
}
