<?php

namespace XMVC\Service;

class Config
{
    protected static $items = [];

    public static function load($file)
    {
        $path = BASE_PATH . '/config/' . $file . '.php';
        if (file_exists($path)) {
            static::$items[$file] = require $path;
        }
    }

    public static function get($key, $default = null)
    {
        list($file, $item) = explode('.', $key);
        if (!isset(static::$items[$file])) {
            static::load($file);
        }
        return static::$items[$file][$item] ?? $default;
    }
}