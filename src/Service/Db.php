<?php

namespace XMVC\Service;

use PDO;

class Db
{
    protected static $pdo;

    public static function pdo()
    {
        if (static::$pdo) {
            return static::$pdo;
        }

        $config = Config::get('db.connections.' . Config::get('db.default'));

        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        static::$pdo = new PDO($dsn, $config['username'], $config['password'], $options);

        return static::$pdo;
    }
}