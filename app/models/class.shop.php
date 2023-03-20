<?php

require BASE_PATH . 'app/models/class.openingHours.php';

class Shop implements OpeningHours
{

    function isOpen(DateTime $now)
    {
        return true;
    }

    function nextOpening(DateTime $now)
    {
        return 'Mon 09:00 - 18:00';
    }


}
