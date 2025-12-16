<?php

namespace XMVC;

use XMVC\Service\Config;
use XMVC\Service\Router;
use App\Http\Request;
use App\Http\Response;
use App\Http\Kernel as HttpKernel;

class Kernel
{
    public function __construct()
    {
        $this->loadConfig();
        $this->loadRoutes();
    }

    public function handle()
    {
        $request = new Request();
        
        $httpKernel = new HttpKernel();
        // Accessing protected property via reflection
        $reflection = new \ReflectionClass($httpKernel);
        
        $middlewareProperty = $reflection->getProperty('middleware');
        $middlewareProperty->setAccessible(true);
        $globalMiddleware = $middlewareProperty->getValue($httpKernel);

        $routeMiddlewareProperty = $reflection->getProperty('routeMiddleware');
        $routeMiddlewareProperty->setAccessible(true);
        $routeMiddlewareMap = $routeMiddlewareProperty->getValue($httpKernel);

        // Match the route first to get route-specific middleware
        $route = Router::match($request);

        if (!$route) {
            (new Response("404 Not Found", 404))->send();
            return;
        }

        $middleware = $globalMiddleware;
        foreach ($route['middleware'] as $key) {
            if (isset($routeMiddlewareMap[$key])) {
                $middleware[] = $routeMiddlewareMap[$key];
            }
        }

        $response = $this->sendRequestThroughMiddleware($request, $middleware, function ($request) use ($route) {
            return Router::handleAction($route['action'], $route['params'], $request);
        });

        $response->send();
    }

    protected function sendRequestThroughMiddleware($request, $middleware, $destination)
    {
        $pipeline = array_reduce(
            array_reverse($middleware),
            function ($next, $middlewareClass) {
                return function ($request) use ($next, $middlewareClass) {
                    $middlewareInstance = new $middlewareClass();
                    return $middlewareInstance->handle($request, $next);
                };
            },
            $destination
        );

        return $pipeline($request);
    }

    protected function loadConfig()
    {
        foreach (glob(BASE_PATH . '/config/*.php') as $file) {
            Config::load(basename($file, '.php'));
        }
    }

    protected function loadRoutes()
    {
        require_once BASE_PATH . '/routes/web.php';
        require_once BASE_PATH . '/routes/api.php';
    }
}