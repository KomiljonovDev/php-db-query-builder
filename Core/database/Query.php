<?php

namespace Core\database;

abstract class Query {
    private static $query;
    protected $connection;
    protected static $pdo;

    public function __construct () {
        $this->connection = new \PDO(env('DATABASE') . ":host" . env('HOST') . ";dbname=" . env('DB_NAME'), env('DB_USER'), env('DB_PASSWORD'));
    }

    public static function connect () {
        return self::$pdo = new \PDO(env('DATABASE') . ":host" . env('HOST') . ";dbname=" . env('DB_NAME'), env('DB_USER'), env('DB_PASSWORD'));
    }
    public static function create () {
        if (isset(static::$table_name)){
            return static::$table_name;
        }
    }
}