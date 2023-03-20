<?php

require BASE_PATH . 'app/models/class.shop.php';

$shop = new Shop();


$now = new DateTime('now');

var_dump($shop->nextOpening($now));
