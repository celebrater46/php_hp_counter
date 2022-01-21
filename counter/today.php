<?php

require_once "counter.php";

$setting = get_setting_array();

$today = get_count_today((int)$setting[2]); // 引数は桁数

$div = get_div((string)$today, "counter today");
//$div = "Hello World";
//$div = $today;
//$div = $setting[2];
//$div = "<div class='counter today'>Hello world</div>";
//$div = '<div class="counter today">Hello world</div>';
//$div = "<div>Hello world</div>";

$var_class = "counter today";

echo "document.write('" . $div . "');";

//echo "let msg = '" . $div . "';";
//echo "let var_class = '" . $var_class . "';";
//echo "let var_class = " . $var_class . "; let msg = '" . $div . "';";