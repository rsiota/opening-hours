<?php

require BASE_PATH . 'app/models/class.shop.php';


// Get Datetime in Chicago
$nowLocalTime = (new Shop)->getLocalTime();
$localTime = date_format($nowLocalTime, 'H:i:s');

// Pass Datetime in Chicago to nextOpening method
$nextOpening = (new Shop)->nextOpening($nowLocalTime);

// Check if the shop is open now
$open = (new Shop)->isOpen($nowLocalTime);

// If the shop is open, get today's day formatted
if ($open) {
    $dayOpen = (new Shop)->dayWeek($nowLocalTime);
}

// Get opening hours of the shop
$days = (new Shop)->getOpeningHours();

// Get shop by url
$shop = (new Shop)->getByUrl();

// Get timezone of Chicago
$localTimezone = (new Shop)->getLocalTimeZone();

// Get timezone of Paris office
$officeTimezone = $shop['timezone'];

// Get formatted time of Paris office
$officeTime = date_format($nowLocalTime, 'H:i:s');






