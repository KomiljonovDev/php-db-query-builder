<?php

namespace Core\database;

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
    public static function table ():string {
        if (isset(static::$table_name)){
            return static::$table_name;
        }
        return '';
    }
    public static function connect ($table_name = null):\PDO {
        if (!self::$static_pdo){
//            self::$static_table = $table_name;
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
            echo self::getQuery() . "\n";
            echo $exception;
        }
    }
    public static function create (array $values) {
        self::connect(self::table());
        $columns = implode(', ', array_keys($values));
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $values = array_values($values);
        self::$static_query = "INSERT INTO " . self::table() . " ($columns) VALUES ($placeholders)";
        self::execute($values);
    }
}