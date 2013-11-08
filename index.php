<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();

//録音されているかチェック

//されていなければ録音
$result = $logic->firstRecordContact();
echo $result;
