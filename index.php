<?php

require_once "counter.php";

$ip = $_SERVER["REMOTE_ADDR"];

$total = get_count($ip, 6); // 第2引数は表示するカウンターの桁数。ゼロにすると数字をそのまま表示
$today = get_count_today(2); // 引数は表示桁数
$yesterday = get_count_yesterday(2); // 引数は表示桁数

echo "total: " . $total . ", ";
echo "today: " . $today . ", ";
echo "yesterday: " . $yesterday . ", ";

echo get_div($total, "counter total");