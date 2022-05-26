<?php

namespace Tricioandrade\Splitesql;

class SQLjoin extends SQLselect
{
    #Inner Join
    public static function JOIN_TABLES_2(string $table1, string $column1, string $table2, string $column2, string $column3, string $column4, string $return){
        self::$sql = "SELECT {$table1}.{$column1}, {$table2}.{$column2} FROM {$table1} JOIN {$table2} ON {$table2}.{$column3} =  {$table1}.{$column4}";
 
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        self::SplitValues($return);
    }
    public static function JOIN_TABLES_3(string $table1, string $column1, string $table2, string $column2, string $table3, string $column3, string $columnref1, string $columnref2, string $return){
        self::$sql = "SELECT $table1.$column1, $table2.$column2, $table3.$column3 FROM $table1 JOIN $table2 ON $table2.$columnref1 =  $table1.$columnref2";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();
        var_dump($return);
        self::SplitValues($return);
    }
    public static function INNER_JOIN_1_WHERE(string $table1, string $column1, string $table2, string $column2, string $column3, string $column4, $WHERE, string $return){
        self::$sql = "SELECT $table1.$column1, $table2.$column2 FROM $table1 INNER JOIN $table2 ON $table2.$column3 =  $table1.$column4 WHERE $table1.$column1 = $WHERE";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        self::SplitValues($return);
    }
    public static function INNER_JOIN_1_WHERE_Like(string $table1, string $column1, string $table2, string $column2, string $column3, string $column4, $ref, string $return){
        self::$sql = "SELECT $table1.$column1, $table2.$column2 FROM $table1 INNER JOIN $table2 ON $table2.$column3 =  $table1.$column4 WHERE $table1.$column1 LIKE '$ref%'\"";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        self::SplitValues($return);
    }
}