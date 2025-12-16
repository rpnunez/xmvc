<?php

use XMVC\Service\Router;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Router::get('', [HomeController::class, 'index']);
Router::get('users/{id}', [UserController::class, 'show']);
Router::get('profile', [ProfileController::class, 'index'])->middleware('auth');