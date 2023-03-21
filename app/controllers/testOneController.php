<?php

require BASE_PATH . 'app/models/class.shop.php';

$now = new DateTime('now');

$days = (new Shop)->showOpeningHours('fictional-shop');

$open = (new Shop)->isOpen($now);

if ($open) {
    $dayOpen = (new Shop)->dayWeek($now);
}

