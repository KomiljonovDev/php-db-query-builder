<?php

namespace Core\database;
require_once 'Helper.php';

class Connecter {
    protected $connection;
    protected static $pdo;

    public function __construct () {
        $this->connection = new \PDO(env('DATABASE') . ":host" . env('HOST') . ";dbname=" . env('DB_NAME'), env('DB_USER'), env('DB_PASSWORD'));
    }

    public static function connect () {
        self::$pdo = new \PDO(env('DATABASE') . ":host" . env('HOST') . ";dbname=" . env('DB_NAME'), env('DB_USER'), env('DB_PASSWORD'));
    }
}