<?php

use XMVC\Service\Config;
use App\Http\Views\View;
use XMVC\Service\Cache;

if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return null;
        }

        return Config::get($key, $default);
    }
}

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        return View::render($view, $data);
    }
}

if (!function_exists('extend')) {
    function extend(string $layout): void
    {
        View::extend($layout);
    }
}

if (!function_exists('section')) {
    function section(string $name): void
    {
        View::section($name);
    }
}

if (!function_exists('endsection')) {
    function endsection(): void
    {
        View::endsection();
    }
}

if (!function_exists('yield_section')) {
    function yield_section(string $name): void
    {
        echo View::yieldContent($name);
    }
}

if (!function_exists('cache')) {
    function cache($key = null, $default = null)
    {
        if (is_null($key)) {
            return null;
        }

        if (is_array($key)) {
            $seconds = $default ?? 3600;
            foreach ($key as $k => $v) {
                Cache::put($k, $v, $seconds);
            }
            return true;
        }

        return Cache::get($key, $default);
    }
}