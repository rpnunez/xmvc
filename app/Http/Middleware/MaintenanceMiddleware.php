<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use XMVC\Service\Config;

class MaintenanceMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        if (Config::get('app.maintenance') === true) {
            return new Response("503 Service Unavailable", 503);
        }

        return $next($request);
    }
}