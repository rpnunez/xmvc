<?php

namespace XMVC\Service;

use App\Http\Request;
use App\Http\Response;

class Router
{
    protected static $routes = [];
    protected static $lastRouteIndex = null;

    public static function get($uri, $action)
    {
        static::addRoute('GET', $uri, $action);
        return new static;
    }

    public static function post($uri, $action)
    {
        static::addRoute('POST', $uri, $action);
        return new static;
    }

    protected static function addRoute($method, $uri, $action)
    {
        static::$routes[] = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'action' => $action,
            'middleware' => [],
        ];
        static::$lastRouteIndex = array_key_last(static::$routes);
    }

    public function middleware($key)
    {
        if (static::$lastRouteIndex !== null) {
            static::$routes[static::$lastRouteIndex]['middleware'][] = $key;
        }
        return $this;
    }

    public static function match(Request $request)
    {
        $uri = $request->uri();
        $method = $request->method();

        foreach (static::$routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route['uri']);
            $pattern = "#^" . $pattern . "$#";

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return [
                    'action' => $route['action'],
                    'params' => $matches,
                    'middleware' => $route['middleware']
                ];
            }
        }

        return null;
    }

    public static function dispatch(Request $request)
    {
        $route = static::match($request);

        if ($route) {
            return static::handleAction($route['action'], $route['params'], $request);
        }

        return new Response("404 Not Found", 404);
    }

    public static function handleAction($action, $params, Request $request)
    {
        // Prepend request to params
        array_unshift($params, $request);

        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }

        if (is_array($action)) {
            [$controller, $method] = $action;
            $controllerInstance = new $controller();
            return call_user_func_array([$controllerInstance, $method], $params);
        }
    }
}