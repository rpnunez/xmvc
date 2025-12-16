<?php

namespace App\Http;

use App\Http\Middleware\LogRequestMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\MaintenanceMiddleware;

class Kernel
{
    protected $middleware = [
        MaintenanceMiddleware::class,
        LogRequestMiddleware::class,
    ];

    protected $routeMiddleware = [
        'auth' => AuthMiddleware::class,
    ];
}