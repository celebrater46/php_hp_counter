<?php

$ip = $_SERVER['REMOTE_ADDR'];

echo "document.write('IP from PHP: " . $ip . "');";
echo "let num = '" . $ip . "';";