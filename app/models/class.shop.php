<?php

require BASE_PATH . 'app/models/class.openingHours.php';
require BASE_PATH . 'app/models/class.utils.php';

class Shop implements OpeningHours
{
    function isOpen(DateTime $now)
    {
        $dayWeek = $this->dayWeek($now);
        $time = date_format($now, 'H:i:s');

        $query =
            "SELECT *
            FROM day
            WHERE day.name = '{$dayWeek}'
            AND '{$time}' >= startTime AND '{$time}' <= endTime";

        $open = Utils::db($query);

        if($open) {
            return true;
        }
        return false;
    }

    function getByUrl()
    {
        $request = $_SERVER['REQUEST_URI'];
        $url = basename($request);
        $result = Utils::db("SELECT * FROM shop WHERE friendlyUrlName = '{$url}'");
        return $result[0];
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

    function getLocalTime()
    {
        return new Datetime('now');
    }

    function getLocalTimeZone()
    {
        $timezone = ($this->getLocalTime())->getTimeZone();
        return $timezone->getName();
    }

    function getOfficeTime($url)
    {
        $query =
            "SELECT timezone
            FROM shop
            WHERE friendlyUrlName = '{$url}'";
        $timezone = Utils::db($query);
        $timezone_from = $timezone[0]['timezone'];
        $nowOfficeTime = new DateTime('now');
        $nowOfficeTime->setTimezone(new DateTimeZone($timezone_from));
        return $nowOfficeTime;
    }
}
