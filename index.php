<?php

require_once "counter.php";
require_once "decorater.php";

$ip = $_SERVER["REMOTE_ADDR"];

$total = get_count($ip, 6); // 第2引数は表示するカウンターの桁数。ゼロにすると数字をそのまま表示
$today = get_count_today(2); // 引数は表示桁数
$yesterday = get_count_yesterday(2); // 引数は表示桁数
$class = "counter total";

//echo "total: " . $total . ", ";
//echo "today: " . $today . ", ";
//echo "yesterday: " . $yesterday . ", ";
//
//echo get_div($total, $class);

?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Author" content="Enin (Eito) Fujimi - 富士見永人">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title>Shining Font</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <p><?php echo "total: " . $total; ?></p>
    <p><?php echo "today: " . $today; ?></p>
    <p><?php echo "yesterday: " . $yesterday; ?></p>

    <?php echo get_div($total, $class); ?>

    <?php echo decorate_count(77777, $class); ?>
</body>
</html>
