<?php


namespace App\Model\SpliteSQL;

class SQLjoin extends SQLselect
{
    protected static $stmt;
    protected static $sql;
    protected static $Table;
    protected static $Value;

    #Inner Join
    public static function INNER_JOIN(string $table1, string $row1, string $table2, string $row2, string $row3, string $row4, string $return){
        self::$sql = "SELECT $table1.$row1, $table2.$row2 FROM $table1 INNER JOIN $table2 ON $table2.$row3 =  $table1.$row4";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        self::SplitValues($return);
    }
    public static function INNER_JOIN_1_WHERE(string $table1, string $row1, string $table2, string $row2, string $row3, string $row4, $WHERE, string $return){
        self::$sql = "SELECT $table1.$row1, $table2.$row2 FROM $table1 INNER JOIN $table2 ON $table2.$row3 =  $table1.$row4 WHERE $table1.$row1 = $WHERE";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        self::SplitValues($return);
    }
    public static function INNER_JOIN_1_WHERE_Like(string $table1, string $row1, string $table2, string $row2, string $row3, string $row4, $ref, string $return){
        self::$sql = "SELECT $table1.$row1, $table2.$row2 FROM $table1 INNER JOIN $table2 ON $table2.$row3 =  $table1.$row4 WHERE $table1.$row1 LIKE '$ref%'\"";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        self::SplitValues($return);
    }
}