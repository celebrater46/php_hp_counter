<?php

echo get_count(6); // 表示するカウンターの桁数。ゼロにすると数字をそのまま表示

function get_count($length){
//    $length = 6; //
    $ip = $_SERVER["REMOTE_ADDR"];
    date_default_timezone_set('Asia/Tokyo');
    $access_date = date("Y-m-d_H:i:s"); // 2021-01-12 09:45:31
    $count = check_log($ip, "log/" . substr($access_date, 0, 10) . ".log");
//    var_dump($count);
    update_log($ip, $access_date);
//    $fp = fopen("counter.dat", "r+");
//    $count = fgets($fp,32);
    if($length > 0){
        return add_zeros($count, $length);
//        return $count;
    } else {
        return $count;
    }
}

function check_log($ip, $log){
    if(file_exists($log)){
        $log_array = file($log);
        $same_ip_exists = same_ip_exists($ip, $log_array);
//        var_dump($same_ip_exists);
        if($same_ip_exists === false) {
            return update_counter();
        } else {
            $fp = fopen("counter.dat", "r+");
            return fgets($fp,32);
        }
    } else {
         return update_counter();
    }
}

function update_counter(){
    $fp = fopen("counter.dat", "r+");
    $count = fgets($fp,32);
    $count++;
    fseek($fp, 0);
    fputs($fp, $count);
    flock($fp, LOCK_UN);
    fclose($fp);
//    var_dump($count);
    return $count;
}

function update_log($ip, $date){
    $path = "log/" . substr($date, 0, 10) . ".log";
    $msg = $ip . "|" . $date;
    error_log($msg . "\n", 3, $path);
}

function same_ip_exists($ip, $array){
    foreach ($array as $line){
        $temp = explode("|", $line);
        if($ip == $temp[0]){
            return true;
        }
    }
    return false;
}

function add_zeros($count, $length){
    $zeros = "";
    $num = 10 ** ($length - 1);
    while($count < $num){
        $zeros .= "0";
        $num /= 10;
    }
    return $zeros . (string)$count;
}