<?php

require_once "counter.php";
require_once "decorater.php";

$div = decorate_count("114514", "counter total", true);

echo "document.write('" . $div . "');";
