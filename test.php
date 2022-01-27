<?php

require_once "counter/counter.php";
//
//$str = "<div>333</div>";
//$str2 = "33d3";
//$num = (int)$str2;
//var_dump($num);
//
//var_dump(get_setting_array());
$ip = $_SERVER['REMOTE_ADDR'];
//create_past_count("2022-01-22", "counter/");
//update_log($ip, "2022-01-22", "counter/");
$dir = search_current_directory();
$count = update_counter($dir);
var_dump($count);