<?php

require_once "counter.php";

$setting = get_setting_array();

$today = get_count_today((int)$setting[2]); // 引数は桁数

$div = get_div((string)$today, "counter today");

$var_class = "counter today";

echo "document.write('" . $div . "');";