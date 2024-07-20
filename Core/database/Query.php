<?php

namespace Core\database;

use http\Exception;

require 'Helper.php';
abstract class Query {
    private static $static_query;
    protected $pdo;
    protected static $static_pdo;
    protected $table;
    protected static $static_table;

    public function __construct ($table_name = null) {
        $this->pdo = new \PDO(env('DATABASE') . ":host" . env('HOST') . ";dbname=" . env('DB_NAME'), env('DB_USER'), env('DB_PASSWORD'));
        $this->table = $table_name;
    }
    /**
     *
     *@message static methods
     *
     */
    public static function setTable (string $table): void {
        self::$static_table = $table;
    }
    public static function getTable (): string {
        if (isset(static::$table_name)){
            return static::$table_name;
        }
        return self::$static_table ? self::$static_table : throw new \Exception("Please set table name: Query::setTable('your_table_name)");
    }
    public static function dbname () {
        return env('DB_NAME');
    }
    public static function connect ():\PDO {
        if (!self::$static_pdo){
            return self::$static_pdo = new \PDO(env('DATABASE') . ":host" . env('HOST') . ";dbname=" . env('DB_NAME'), env('DB_USER'), env('DB_PASSWORD'));
        }
        return self::$static_pdo;
    }
    public static function getQuery () {
        return self::$static_query;
    }
    public static function execute (array $params) {
        try {
            $pdo = self::$static_pdo->prepare(self::$static_query);
            $pdo->execute($params);
        }catch (\Exception $exception){
            echo self::getQuery() . "<br>";
            var_dump(self::$static_table);
            echo $exception;
        }
    }
    public static function create (array $values) {
        self::connect();
        $columns = implode(', ', array_keys($values));
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $values = array_values($values);
        self::$static_query = "INSERT INTO " . self::dbname() . "." . self::getTable() . " ($columns) VALUES ($placeholders)";
        self::execute($values);
    }

    public static function where () {
        self::connect();

    }
}