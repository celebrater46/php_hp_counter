<?php

$length = 5; // 桁数

$filename = "counter.dat";

$fp = fopen($filename, "r+");
$count = fgets($fp,32);
$count++;
fseek($fp, 0);
fputs($fp, $count);
flock($fp, LOCK_UN);
fclose($fp);
echo add_zeros2($count, $length);

function add_zeros($count){
    switch(true){
        case $count < 10:
            return "0000" . (string)$count;
        case $count < 100:
            return "000" . (string)$count;
        case $count < 1000:
            return "00" . (string)$count;
        case $count < 10000:
            return "0" . (string)$count;
        default:
            return $count;
    }
}

function add_zeros2($count, $length){
    $zeros = "";
    $num = 10 ** ($length - 1);
    while($count < $num){
        $zeros .= "0";
        $num /= 10;
    }
    return $zeros . (string)$count;
//    for($i = 0; $i < $length; $i++){
//
//    }
}