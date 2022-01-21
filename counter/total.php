<?php

require_once "counter.php";
require_once "decorater.php";

$ip = $_SERVER["REMOTE_ADDR"];

$setting = get_setting_array();

$total = get_count($ip, (int)$setting[1]); // 引数は桁数

$div = decorate_count((string)$total, "counter total", false);

echo "document.write('" . $div . "');";
