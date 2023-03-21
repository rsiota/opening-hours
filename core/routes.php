<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
case '/test-one' :
    require BASE_PATH . '/app/views/testOne.php';
    break;
}
