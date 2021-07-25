<?php

/***
 * @author Patricio Bento Andrade
 * @copyright tricioandrde - Patrício Andrade All Rights Reserved
 * @license  Propriety
 * @since 2020
 * @class Query
 */

namespace App\Model\SpliteSQL;

use App\Model\SpliteSQL\Connection;
use App\Model\SpliteSQL\SGBD;

class  Query extends SGBD
{

    const fetch = 'fetch';
    const count = 'count';
    const create = 'CREATE';
    const update = 'UPDATE';
    const delete = 'DELETE';
    const select = 'SELECT';
    const insert = 'insert';
    const where = 'WHERE';
    const set = 'SET';
    const limit = 'LIMIT';
    const equal = '=';

    private static $sql;
    private static $stmt;

    private static $rows;
    private static $values;
    private static $table;

    private static $check_query_result = false;

    /**
     * _Query constructor.
     * @param string $host
     * @param string $database
     * @param string $user
     * @param string|null $password
     * @param string|null $charset
     */

    /*
     * @encode array to Json
     * @return json array
     */
    private static function encode_json(array $array){
        $array = str_replace('\\',' ',json_encode($array, JSON_UNESCAPED_UNICODE));
        $array = str_replace('  ', '/', $array);
        $array = str_replace(' /', '/', $array);
        return $array;
    }

    /**
     * @param array $rows
     */
    private static function setRows( $rows): void {
        if (is_object($rows)) $rows = get_object_vars($rows);
        self::$rows = str_replace(['[',']', '{','}', '"' ,'"'],  '', self::encode_json(array_keys($rows)));
    }

    /**
     * @param array $values
     */
    private static function setValues( $values): void {
        if (is_object($values)) $values = get_object_vars($values);
        self::$values = str_replace('"', '\'' , str_replace(['[',']', '{','}'],  '', self::encode_json(array_values($values))));
    }

    /**
     * @return mixed
     */
    private static function getRows(){
        return self::$rows;
    }

    /**
     * @return mixed
     */
    private static function getValues(){
        return self::$values;
    }

    /**
     * @return bool
     */
    public static function is_true(){
        return self::$check_query_result;
    }

    /**
     * @param bool $state
     */
    private static function setQueryResult(bool $state){
        self::$check_query_result = $state;
    }

    /**
     * @Model static function
     * @param string $ddl
     * @param array $rows
     * @param array $values
     * @param string|null $table
     * @param string|null $return
     * @return array|bool|int
     */

    public static function sql_select(){

    }

    public static function sql_insert(string $table, $param){
        self::setRows($param); self::setValues($param);
        self::$sql = self::insert." into {$table} (".self::getRows().") values (".self::getValues().")";

        self::$stmt = Connection::connect()->prepare(self::$sql);
        if (self::$stmt->execute()):
            self::setQueryResult(true);
        endif;
    }

    public static function SplitSQL(string $SQL, string $table = null, string $return = null){
        self::$sql = $SQL;
        self::$stmt = Connection::connect()->prepare(self::$sql);
        if (self::$stmt->execute()):
            if (false !== stripos($SQL, self::create)) return true;
            if (false !== stripos($SQL, self::update)) return true;
            if (false !== stripos($SQL, self::delete)) return true;
            if (false !== stripos($SQL, self::select)):
                if ($return == self::fetch || $return == null):
                    return self::$stmt->fetchAll(\PDO::FETCH_OBJ);
                elseif ($return == self::count):
                    return self::$stmt->rowCount();
                endif;
            endif;
        endif;
    }
}