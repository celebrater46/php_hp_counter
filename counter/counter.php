<?php

// Copyright (C) Enin Fujimi All Rights Reserved.

require_once "decorater.php";

function php_hp_counter($mode){
    $ip = $_SERVER['REMOTE_ADDR'];
    $directory = search_current_directory();
    if($directory === null) {
        return '<div>setting.txt が読み込めません。<br>
            php_hp_counter() 関数を呼び出す PHP ファイルを <br>
            php_hp_counter フォルダ内に置くことで解決するかもしれません。</div>';
    }
    $setting = get_setting_array($directory);
//    var_dump($setting[4]);
    switch ($mode){
        case 0:
            return decorate_count(
                get_count($ip, (int)$setting[0], (int)$setting[1], $setting[4], $directory),
                "counter total",
                false
            );
        case 1:
            return get_div(
                get_count_today((int)$setting[2], $directory),
                "counter today"
            );
        case 2:
            return get_div(
                get_count_yesterday((int)$setting[3], $directory),
                "counter yesterday"
            );
        default:
            return '<div>php_hp_counter() の引数の値が不正です。</div>';
    }
}

function get_div($str, $class){
    $array = str_split($str);
    $div = '<div class="' . $class . '">';
    foreach ($array as $char){
        $div .= '<div>' . $char . '</div>';
    }
    $div .= '</div>';
    return $div;
}

function get_count($ip, $default, $length, $do_check, $dir){
    date_default_timezone_set('Asia/Tokyo');
    $access_date = date("Y-m-d_H:i:s"); // 2021-01-12 09:45:31
    $count = check_log($ip, $dir . "log/" . substr($access_date, 0, 10) . ".log", $do_check, $dir);
    update_log($ip, $access_date, $dir);
    return add_zeros((int)$count + (int)$default, $length);
}

function get_count_today($length, $dir){
    date_default_timezone_set ('Asia/Tokyo');
    $now = file($dir . "counter.dat");
    $d = date('Y-m-d', strtotime('-1 day'));
    $y = open_past_dat($d, $dir);
    $count = (int)$now[0] - $y;
    return add_zeros($count, $length);
}

function get_count_yesterday($length, $dir){
    date_default_timezone_set ('Asia/Tokyo');
    $d1 = date('Y-m-d', strtotime('-1 day'));
    $d2 = date('Y-m-d', strtotime('-2 day'));
    $y = open_past_dat($d1, $dir);
    $yy = open_past_dat($d2, $dir);
    $count = $y - $yy;
    return add_zeros($count, $length);
}

function open_past_dat($date, $dir){
    $path = $dir . "past/" . $date . ".dat";
    if(file_exists($path)){
        $count = file($path);
        return (int)$count[0];
    } else {
        return 0;
    }
}

function check_log($ip, $log, $do_check, $dir){
    if($do_check !== "false"){
        if(file_exists($log)){
            $log_array = file($log);
            $same_ip_exists = same_ip_exists($ip, $log_array);
            if($same_ip_exists) {
                $count = file($dir . "counter.dat");
                return $count[0];
            }
        }
    }
    return update_counter($dir);
}

function update_counter($dir){
    $fp = fopen($dir . "counter.dat", "r+");
    $count = fgets($fp,32);
    $count++;
    fseek($fp, 0);
    fputs($fp, $count);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $count;
}

function search_current_directory(){
    $file_name = "counter.dat";
    if(file_exists($file_name)){
        return "";
    } elseif (file_exists("counter/" . $file_name)){
        return "counter/";
    } elseif (file_exists("php_hp_counter/counter/" . $file_name)){
        return "php_hp_counter/counter/";
    } else {
        return null;
    }
}

function update_log($ip, $date, $dir){
    $path = $dir . "log/" . substr($date, 0, 10) . ".log";
    $msg = $ip . "|" . $date;
    if(file_exists($path) !== true){
        create_past_count($dir);
    }
    error_log($msg . "\n", 3, $path);
}

function create_past_count($dir){
    date_default_timezone_set ('Asia/Tokyo');
    $date = date('Y-m-d', strtotime('-1 day'));
    $count = file($dir . "counter.dat");
    var_dump($date);
    file_put_contents( $dir . "past/" . $date . ".dat", $count[0]);
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

function get_setting_array($dir){
    /*
    default:0
    digit_total:6
    digit_today:2
    digit_yesterday:2
    ip_check:true
    */
    $array = file($dir . "setting.txt");
    $array = str_replace([
        "default:",
        "digit_total:",
        "digit_today:",
        "digit_yesterday:",
        "ip_check:",
        "\n",
        "\r",
        "\r\n"
    ], "", $array);
    return $array;
}