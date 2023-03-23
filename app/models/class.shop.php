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
            AND '{$time}' >= startTime AND '{$time}' <= endTime
            AND boolIsClosed != 1";

        $open = Utils::db($query);

        if($open) {
            return true;
        }
        return false;
    }

    function nextOpening(DateTime $now)
    {
        $isOpen = $this->isOpen($now);
        $dayWeek = $this->dayWeek($now);
        $day = $this->getIdbyDay($dayWeek);
        $dayId = $day[0]['id'];

        if ($isOpen) {
            return 'Shop is currently open';
        } else {

            function query($param) {
                return
                    "SELECT day.*
                    FROM day
                    LEFT JOIN shop ON shop.id = day.shop
                    WHERE shop.friendlyUrlName = 'paris-shop'
                    AND day.boolIsClosed != 1
                    AND day.id > {$param} ORDER BY day.id LIMIT 1";
            }

            $nextOpeningNextWeek = Utils::db(query(0));
            $nextOpeningThisWeek = Utils::db(query($dayId));

            if($nextOpeningThisWeek) {
                return $nextOpeningThisWeek[0];
            } else {
                return $nextOpeningNextWeek[0];
            }


        }
    }

    function getByUrl()
    {
        $url = $this->getUrl();
        $result = Utils::db("SELECT * FROM shop WHERE friendlyUrlName = '{$url}'");
        return $result[0];
    }

    function getIdByDay($day)
    {
        return Utils::db("SELECT id FROM day WHERE name = '{$day}'");
    }

    function dayWeek(DateTime $now)
    {
        return $now->format('D');
    }

    function getUrl()
    {
        $request = $_SERVER['REQUEST_URI'];
        return basename($request);
    }


    function getOpeningHours()
    {
        $url = $this->getUrl();
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
