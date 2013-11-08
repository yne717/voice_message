<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();
error_log(print_r($logic->getParam()));

$response = $logic->completedRecord();
echo $response;