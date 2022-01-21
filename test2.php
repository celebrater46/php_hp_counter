<?php

require_once "counter.php";

$date = "2023-01-01";
create_past_count($date);

$count = file("past/" . $date . ".dat");

var_dump($count);