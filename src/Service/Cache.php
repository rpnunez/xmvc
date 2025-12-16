<?php

namespace XMVC\Service;

class Cache
{
    /**
     * Retrieve an item from the cache.
     */
    public static function get($key, $default = null)
    {
        $config = static::getConfig();

        if ($config['driver'] === 'file') {
            $file = static::getFilePath($key, $config['path']);

            if (file_exists($file)) {
                $content = file_get_contents($file);
                $data = unserialize($content);

                if ($data['expires_at'] > time()) {
                    return $data['value'];
                }

                // Cache expired
                unlink($file);
            }
        }

        return $default;
    }

    /**
     * Store an item in the cache.
     */
    public static function put($key, $value, $seconds = 3600)
    {
        $config = static::getConfig();

        if ($config['driver'] === 'file') {
            $path = $config['path'];

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file = static::getFilePath($key, $path);

            $data = [
                'value' => $value,
                'expires_at' => time() + $seconds
            ];

            return file_put_contents($file, serialize($data)) !== false;
        }

        return false;
    }

    /**
     * Remove an item from the cache.
     */
    public static function forget($key)
    {
        $config = static::getConfig();

        if ($config['driver'] === 'file') {
            $file = static::getFilePath($key, $config['path']);
            if (file_exists($file)) {
                return unlink($file);
            }
        }

        return false;
    }

    protected static function getConfig()
    {
        $default = Config::get('cache.default');
        return Config::get("cache.stores.{$default}");
    }

    protected static function getFilePath($key, $path)
    {
        return $path . '/' . sha1($key) . '.cache';
    }
}