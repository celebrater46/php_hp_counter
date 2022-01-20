<?php

$ip = $_SERVER["REMOTE_ADDR"];
date_default_timezone_set('Asia/Tokyo');
$access_date = date("Y-m-d_H:i:s"); // 2021-01-12 09:45:31
$access_date_unix = time(); // UNIX

var_dump($ip);
var_dump($access_date);
var_dump($access_date_unix);

$path = "log/" . substr($access_date, 0, 10) . ".log";
$logmessages = $access_date . "|" . $ip;
error_log($logmessages . "\n", 3, $path);

var_dump($path);
var_dump($logmessages);

//add_log($ip, $access_date);
//function  add_log($ip, $date){
//    $path = "log/" . substr($date, 0, 10) . ".log";
//    $logmessages = $date . "|" . $ip;
//    error_log($logmessages . "\n", 3, $path);
//}