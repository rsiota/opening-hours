<?php

class shop implements openingHours
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
