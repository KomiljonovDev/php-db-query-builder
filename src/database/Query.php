<?php

namespace App\database;

use http\Exception;

require 'Helper.php';
class Query {
    protected $pdo;
    protected $table;
    protected static $static_pdo;
    protected static $static_table;
    protected static $static_query;
    protected static $static_conditions;

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
            return $pdo;
        }catch (\Exception $exception){
            echo "<p style='color: #e85151'>" . self::getQuery() . "</p>";
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
    public static function update (array $values) {
        self::connect();
        $columns = implode('=?,', array_keys($values)) . '=?';
        $merged = array_values($values);
        self::$static_query = "UPDATE " . self::dbname() . "." . self::getTable() . " SET $columns";
        if (self::$static_conditions){
            $conditions = "";
            $conditions_array = [];
            foreach (self::$static_conditions as $column => $static_condition) {
                if (strlen($conditions)){
                    $conditions .= $static_condition['logical_operator'] . " ";
                }
                $conditions .= $column . $static_condition['condition']  . "? ";
                $conditions_array[] = $static_condition['value'];
            }
            self::$static_query .= " WHERE " . $conditions;
            $merged = array_merge(array_values($values), $conditions_array);
        }
        self::execute($merged);
    }
    /**
     * @param $condition_or_value mixed condition || value
    */
    public static function where (string $column, mixed $condition_or_value, mixed $value = null) {
        self::connect();
        $condition_data = '=';
        if (func_num_args() == 3){
            $condition_data = $condition_or_value;
            $condition_or_value = $value;
        }
        self::$static_conditions[$column] = ['condition'=>$condition_data,'value'=>$condition_or_value, 'logical_operator'=>'AND'];
        return new static;
    }
    /**
     * @param $condition_or_value mixed condition || value
     */
    public static function orWhere (string $column, mixed $condition_or_value, mixed $value = null) {
        self::connect();
        $condition_data = '=';
        if (func_num_args() == 3){
            $condition_data = $condition_or_value;
            $condition_or_value = $value;
        }
        self::$static_conditions[$column] = ['condition'=>$condition_data,'value'=>$condition_or_value, 'logical_operator'=>'OR'];
        return new static;
    }
    public static function get () {
        $conditions = "";
        $conditions_array = [];
        foreach (self::$static_conditions as $column => $static_condition) {
            if (strlen($conditions)){
                $conditions .= $static_condition['logical_operator'] . " ";
            }
            $conditions .= $column . $static_condition['condition']  . "? ";
            $conditions_array[] = $static_condition['value'];
        }
        self::$static_query = "SELECT * FROM " . self::dbname() . "." . self::getTable() . " WHERE " . $conditions;
        return self::execute($conditions_array)->fetchAll(\PDO::FETCH_ASSOC);
    }
}