<?php

include 'ChcXmppClient.php';

$conn = new ChcXmppClient();
$conn->init('115.28.231.132', 13000, '111111', '123456', 'ay140222164105110546z');
//$conn->register("dasb", "2222");
//$conn->createRoom("dasb");
//$ret = $conn->destroyRoom("dasb@conference.ay140222164105110546z");
$conn->messageRoom("42_1@conference.ay140222164105110546z", "hello");
