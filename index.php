<?php

require_once "counter.php";

$ip = $_SERVER["REMOTE_ADDR"];

echo get_count($ip, 6); // 表示するカウンターの桁数。ゼロにすると数字をそのまま表示