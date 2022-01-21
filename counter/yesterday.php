<?php

require_once "counter.php";

$setting = get_setting_array();

$y = get_count_yesterday((int)$setting[3]); // 引数は桁数

$div = get_div((string)$y, "counter yesterday");

echo "document.write('" . $div . "');";
