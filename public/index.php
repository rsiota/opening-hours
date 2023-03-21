<?php

// Bootstrap Paths
$appPath = realpath(dirname(__FILE__));
defined('PUBLIC_PATH') || define('PUBLIC_PATH', $appPath . '/');
defined('BASE_PATH') || define('BASE_PATH', realpath(PUBLIC_PATH . '..') . '/');


require BASE_PATH . 'app/configuration.php';
require BASE_PATH . 'core/routes.php';

?>
