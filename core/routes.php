<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
case '/paris-shop' :
    require BASE_PATH . '/app/views/shopTimes.php';
    break;
}
