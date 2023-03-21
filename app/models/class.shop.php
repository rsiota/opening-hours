<?php

require BASE_PATH . 'app/models/class.openingHours.php';
require BASE_PATH . 'app/models/class.utils.php';

class Shop implements OpeningHours
{



    function isOpen(DateTime $now)
    {
        $dayWeek = $this->dayWeek($now);

        $query =
            "SELECT *
            FROM day
            WHERE day.name = '{$dayWeek}'
            AND CURRENT_TIME() >= startTime AND CURRENT_TIME() <= endTime";

        $openDay = Utils::db($query);

        if($openDay) {
            return true;
        }
        return false;
    }

    function dayWeek(DateTime $now)
    {
        return $now->format('D');
    }

    function nextOpening(DateTime $now)
    {
        return 'Mon 09:00 - 18:00';
    }

    function showOpeningHours($url)
    {
        $query =
            "SELECT day.*
            FROM day
            LEFT JOIN shop ON shop.id = day.shop
            WHERE shop.friendlyUrlName = '{$url}'";
        return Utils::db($query);
    }


}
