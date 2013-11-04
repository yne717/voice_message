<?php
require('lib/twilio/Services/Twilio.php');
test
$response = new Services_Twilio_Twiml();

if (isset($_REQUEST['Digits'])){
   $input = $_REQUEST['Digits'];
   switch ($input) {
       case '1':
           $gather = $response->gather(array('numDigits' => 1, 'timeout' => '10'));
           $gather->say('1 を押しやがりましたね、今月の請求額は、わかりません。', array('language' => 'ja-jp'));
           break;
       case '2':
           $gather = $response->gather(array('numDigits' => 1, 'timeout' => '10'));
           $gather->say('2 を押しやがりましたね、先月の請求額は、わかりません。', array('language' => 'ja-jp'));
           break;
       case '9':
           $response->say('さようなら', array('language' => 'ja-jp'));
           break;
       default:
           $gather = $response->gather(array('numDigits' => 1, 'timeout' => '10'));
           $gather->say('1か2か9を押せって言ったじゃないの。やりなおし。', array('language' => 'ja-jp'));
           break ;
   }
} else {   
           $gather = $response->gather(array('numDigits' => 1, 'timeout' => '10'));
           $gather->say("請求金額の確認をします。今月のご利用料金は 1 を、
                    先月のご利用 料金は 2 を、終わるときは 9 を押しなさい。", array('language' => 'ja-jp'));
}
   
print $response;