<?php

use App\Src\Service\Router;
use App\Http\Controllers\UserController;

Router::get('api/users', [UserController::class, 'index']);