<?php

// activate full error reporting
//error_reporting(E_ALL & E_STRICT);

include 'XMPP.php';

#Use XMPPHP_Log::LEVEL_VERBOSE to get more logging for error reports
#If this doesn't work, are you running 64-bit PHP with < 5.2.6?
$conn = new XMPPHP_XMPP('115.28.231.132', 13000, '111111', '123456', 'xmpphp', 'ay140222164105110546z', true, $loglevel=XMPPHP_Log::LEVEL_VERBOSE);

try {
    $conn->connect();
    $conn->processUntil('session_start');
    //$conn->presence();
    $conn->messageRoom('111111_2@conference.ay140222164105110546z', 
                       'ay140222164105110546z', "hello");
    //$conn->createRoomEx('nidaye', 'ay140222164105110546z');
    //$conn->destroyRoom('ay140222164105110546z');
    //$conn->message('test3@AY140222164105110546Z', 'This is a test message!');
    //$conn->registerNewUser("test41", "test41", '', '', "ay140222164105110546z");
} catch(XMPPHP_Exception $e) {
    die($e->getMessage());
}
