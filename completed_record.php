<?php

require ('logic/TwilioLogic.php');

$logic = new TwilioLogic();

$response = $logic->completedRecord();
echo $response;