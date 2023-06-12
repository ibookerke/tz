<?php

use \Controllers\MessageController;
use Core\Route;
return [
    '' => new Route([
        'type' => 'GET',
        'route' => [MessageController::class, 'index']
    ]),
    'messages/create' => new Route([
        'type' => 'GET',
        'route' => [MessageController::class, 'create']
    ]),
    'messages/store' => new Route([
        'type' => 'POST',
        'route' => [MessageController::class, 'store']
    ])
];