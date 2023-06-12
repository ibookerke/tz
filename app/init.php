<?php

spl_autoload_register(function($classname){

    $classname = str_replace('\\', '/', $classname);

    require $filename = "../app/".ucfirst($classname).".php";
});

require_once "../config/config.php";

require_once "Core/helpers.php";

require_once "Core/Application.php";
require_once "Core/http/Request.php";
require_once "Core/http/Router.php";
require_once "Core/http/Controller.php";
require_once "Core/Database.php";
require_once "Core/Model.php";
require_once "Core/http/Route.php";
