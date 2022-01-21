<?php

function get_div($str, $class){
    $array = str_split($str);
    $div = "<div class=''" . $class . "'>";
    foreach ($array as $char){
        $div .= "<div>" . $char . "</div>";
    }
    $div .= "</div>";
    return $div;
}

//function get_count_div($ip, $length){
//    $count = get_count($ip, $length);
//    $array = str_split($count);
//    $div = "<div class='counter'>";
//    foreach ($array as $char){
//        $div .= "<div>" . $char . "</div>";
//    }
//    $div .= "</div>";
//    return $div;
//}

function get_count($ip, $length){
    date_default_timezone_set('Asia/Tokyo');
    $access_date = date("Y-m-d_H:i:s"); // 2021-01-12 09:45:31
    $count = check_log($ip, "log/" . substr($access_date, 0, 10) . ".log");
    update_log($ip, $access_date);
    return add_zeros($count, $length);
//    if($length > 0){
//        return add_zeros($count, $length);
//    } else {
//        return $count;
//    }
}

function get_count_today($length){
    date_default_timezone_set ('Asia/Tokyo');
    $now = file("counter.dat");
    $d = date('Y-m-d', strtotime('-1 day'));
    $path = "past/" . $d . ".dat";
    $y = open_past_dat($d);
    $count = (int)$now[0] - $y;
    return add_zeros($count, $length);
//    if(file_exists($path)){
//        $now = file("counter.dat");
//        $y = file($path);
//        $count_y = (int)$now - (int)$y;
//        return $count_y;
//    } else {
//        return 0;
//    }
}

function get_count_yesterday($length){
    date_default_timezone_set ('Asia/Tokyo');
    $d1 = date('Y-m-d', strtotime('-1 day'));
    $d2 = date('Y-m-d', strtotime('-2 day'));
    $y = open_past_dat($d1);
    $yy = open_past_dat($d2);
    $count = $y - $yy;
//    var_dump($count);
    return add_zeros($count, $length);
//    $path1 = "past/" . $d1 . ".dat";
//    $path2 = "past/" . $d2 . ".dat";
//    if(file_exists($path1)){
//        $count_y = file($path1);
//        $count_yy = [0];
//        if(file_exists($path2)){
//            $count_yy
//        }
//        $count_y = (int)$now - (int)$y;
//        return $count_y;
//    } else {
//        return 0;
//    }
}

function open_past_dat($date){
    $path = "past/" . $date . ".dat";
    if(file_exists($path)){
        $count = file($path);
//        var_dump($count);
        return (int)$count[0];
    } else {
        return 0;
    }
}

function check_log($ip, $log){
    if(file_exists($log)){
        $log_array = file($log);
        $same_ip_exists = same_ip_exists($ip, $log_array);
        if($same_ip_exists) {
            $count = file("counter.dat");
            return $count[0];
        }
    }
    return update_counter();
}

function update_counter(){
    $fp = fopen("counter.dat", "r+");
    $count = fgets($fp,32);
    $count++;
    fseek($fp, 0);
    fputs($fp, $count);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $count;
}

function update_log($ip, $date){
    $path = "log/" . substr($date, 0, 10) . ".log";
    $msg = $ip . "|" . $date;
    if(file_exists($path) !== true){
        create_past_count($date);
    }
    error_log($msg . "\n", 3, $path);
//    file_put_contents($path, $msg . "\n");
}

function create_past_count($date){
    $count = file("counter.dat");
    file_put_contents( "past/" . $date . ".dat", $count[0]);
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
    if($length > 0){
        $zeros = "";
        $num = 10 ** ($length - 1);
        $temp_num = $count;
        if($count < 1){
            $temp_num = 1;
        }
        while($temp_num < $num){
            $zeros .= "0";
            $num /= 10;
        }
        return $zeros . (string)$count;
    } else {
        return (string)$count;
    }
}