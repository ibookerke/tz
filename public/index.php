<?php

use Core\Application;

session_start();


require_once "../app/init.php";

DEBUG_MODE ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$app = new Application();
$app->run();

?>
