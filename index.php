<?php
require('lib/twilio/Services/Twilio.php');

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
           $gather->say("お電話有難うございます。おおつるさん、やなぎもとさんへのメッセージを受付しております。
                    ぴーっと音がなった後にメッセージをお願い致します。それではどうぞ", array('language' => 'ja-jp'));
}
   
print $response;