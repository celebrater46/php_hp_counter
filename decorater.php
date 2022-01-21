<?php

require_once "counter.php";

function decorate_count($count, $class){
    $length = strlen($count); // 桁数
    $lucky_nums = get_lucky_num_array();
    $kiri_nums = get_kiri_nums($length);
    $zorome_nums = get_zorome_nums($length);
    $array = array_merge($lucky_nums, $kiri_nums, $zorome_nums);
    $is_kiriban = is_kiriban($count, $array);
    if($is_kiriban){
        return get_div((string)$count, $class . " kiriban");
    } else {
        return get_div((string)$count, $class);
    }
}

function is_kiriban($count, $array){
    foreach ($array as $num){
        if((int)$count === (int)$num) {
            return true;
        }
    }
    return false;
}

function get_lucky_num_array(){
    $path = "lucky_number.txt";
    if(file_exists($path)){
        $nums = file($path);
        return $nums;
    } else {
        return [""];
    }
}

//function get_kiriban_array($length){
//    $kiri_nums = get_kiri_nums($length);
//    $zorome_nums = get_zorome_nums($length);
//    return array_merge($kiri_nums, $zorome_nums);
//}

function get_kiri_nums($length){
    // 10000, 20000, 30000 ...
    $str = "";
    $array = [];
    for($i = 1; $i < $length; $i++){
        // $length == 5, $str == "0000"
        $str .= "0";
    }
    for($j = 1; $j < 10; $j++){
        // 10000, 20000, 30000 ...
        $temp = (string)$j . $str;
        array_push($array, (int)$temp);
    }
    return $array;
}

function get_zorome_nums($length){
    // 11111, 22222, 33333 ...
    $array = [];
    for($k = 1; $k < 10; $k++){
        if($k === 4 || $k === 6 || $k === 9){
            continue;
        }
        $temp2 = "";
        for($m = 0; $m < $length; $m++){
            $temp2 .= (string)$k;
        }
        array_push($array, (int)$temp2);
    }
    return $array;
}