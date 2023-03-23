<?php

require BASE_PATH . 'app/models/class.openingHours.php';
require BASE_PATH . 'app/models/class.utils.php';


class Shop implements OpeningHours
{

    /*
     * Returns current DateTime for a specific timezone
     *
     */

    function getLocalTime()
    {
        $timezone_from = $this->getLocalTimeZone();
        $nowLocalTime = new Datetime('now');
        $nowLocalTime->setTimezone(new DateTimeZone($timezone_from));
        return $nowLocalTime;
    }


    /*
     * Returns timezone string for Chicago
     *
     */

    function getLocalTimeZone()
    {
        return 'America/Chicago';
    }


    /*
     * Returns bool if a store is open
     *
     */

    function isOpen(DateTime $now)
    {
        $now->setTimezone(new DateTimeZone('Europe/Paris'));
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


    /*
     * Returns next opening day of a store
     *
     */

    function nextOpening(DateTime $now)
    {
        $now->setTimezone(new DateTimeZone('Europe/Paris'));
        $url = $this->getUrl();
        $isOpen = $this->isOpen($now);
        $dayWeek = $this->dayWeek($now);
        $day = $this->getIdbyDay($dayWeek);
        $dayId = $day[0]['id'];

        function query($param, $url) {
            return
                "SELECT day.*
                FROM day
                LEFT JOIN shop ON shop.id = day.shop
                WHERE shop.friendlyUrlName = '{$url}'
                AND day.boolIsClosed != 1
                AND day.id > {$param} ORDER BY day.id LIMIT 1";
        }

        if ($isOpen) {
            return false;
        } else {
            $nextOpeningNextWeek = Utils::db(query(0, $url));
            $nextOpeningThisWeek = Utils::db(query($dayId, $url));

            if($nextOpeningThisWeek) {
                return $nextOpeningThisWeek[0];
            } else {
                return $nextOpeningNextWeek[0];
            }
        }
    }


    /*
     * Returns last element of the request/url
     *
     */

    function getUrl()
    {
        $request = $_SERVER['REQUEST_URI'];
        return basename($request);
    }


    /*
     * Returns a shop by the current shop url
     *
     */

    function getByUrl()
    {
        $url = $this->getUrl();
        $result = Utils::db("SELECT * FROM shop WHERE friendlyUrlName = '{$url}'");
        return $result[0];
    }


    /*
     * Returns the formatted day of the week
     *
     */

    function dayWeek(DateTime $now)
    {
        return $now->format('D');
    }


    /*
     * Returns id of a day by name
     *
     */
    function getIdByDay($day)
    {
        return Utils::db("SELECT id FROM day WHERE name = '{$day}'");
    }

    /*
     * Returns days of the week with
     * opening hours for a shop
     *
     */

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

}
