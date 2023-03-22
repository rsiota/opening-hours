<?php

require BASE_PATH . 'app/models/class.shop.php';

$shop = (new Shop)->getByUrl();

$nowLocalTime = (new Shop)->getLocalTime();
$nowOfficeTime = (new Shop)->getOfficeTime('paris-shop');

$localTime = date_format($nowLocalTime, 'H:i:s');
$officeTime = date_format($nowOfficeTime, 'H:i:s');

$days = (new Shop)->showOpeningHours('paris-shop');
$open = (new Shop)->isOpen($nowOfficeTime);

if ($open) {
    $dayOpen = (new Shop)->dayWeek($nowOfficeTime);
}

$localTimezone = (new Shop)->getLocalTimeZone();
$officeTimezone = $shop['timezone'];

$nextOpening = 'Mon 09:00:00';


