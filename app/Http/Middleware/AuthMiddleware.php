<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;

class AuthMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        // Simple check for demonstration: look for ?token=secret in the URL
        if ($request->input('token') !== 'secret') {
            return new Response("401 Unauthorized", 401);
        }

        return $next($request);
    }
}