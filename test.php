<?php

date_default_timezone_set('Asia/Tokyo');
$temp = date("Y-m-d_H:i:s"); // 2021-01-12 09:45:31
$access_date = substr($temp, 0, 10);
$dat = "past/" . $access_date . ".dat";
$daycount = 0;

if(file_exists($dat)){
    $fp = fopen($dat, "r+");
    $count = fgets($fp,32);
    $count++;
    fseek($fp, 0);
    fputs($fp, $count);
    flock($fp, LOCK_UN);
    fclose($fp);
    $daycount = $count;
} else {
    file_put_contents( $dat, 0);
}

var_dump($daycount);