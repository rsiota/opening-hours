<?php

/**
 * Executes a PDO query and returns result
 */
function db($query)
{
    $db = new PDO(PDO_DSN, DB_USER, DB_PASS);
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

