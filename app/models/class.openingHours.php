<?php

interface OpeningHours
{
    function isOpen(DateTime $now);
    function nextOpening(DateTime $now);
}
