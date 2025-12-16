<?php

namespace App\Http\Middleware;

use App\Http\Request;
use XMVC\Service\Log;

class LogRequestMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        Log::info("Request: {$request->method()} {$request->uri()}");

        return $next($request);
    }
}