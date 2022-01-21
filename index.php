<?php

require_once "counter/counter.php";
require_once "counter/decorater.php";

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Author" content="Enin Fujimi">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title>PHP HP COUNTER</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <div><?php echo "total: " . php_hp_counter(0); ?></div>
    <div><?php echo "today: " . php_hp_counter(1); ?></div>
    <div><?php echo "yesterday: " . php_hp_counter(2); ?></div>

    <?php echo decorate_count("77777", "counter total", true); ?>
    <?php echo decorate_count("100000", "counter total", true); ?>
    <?php echo decorate_count("114514", "counter total", true); ?>

</body>
</html>
