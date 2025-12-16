<?php

namespace App\Http\Models;

use XMVC\Service\Db;
use PDO;

abstract class Model
{
    protected static $table;

    public static function getTable()
    {
        if (static::$table) {
            return static::$table;
        }

        $className = (new \ReflectionClass(static::class))->getShortName();
        return strtolower($className) . 's';
    }

    public static function all()
    {
        $table = static::getTable();
        $stmt = Db::pdo()->query("SELECT * FROM {$table}");
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function find($id)
    {
        $table = static::getTable();
        $stmt = Db::pdo()->prepare("SELECT * FROM {$table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        $table = static::getTable();
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $stmt = Db::pdo()->prepare("INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($data);

        return static::find(Db::pdo()->lastInsertId());
    }
}