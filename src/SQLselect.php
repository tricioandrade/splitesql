<?php

namespace Tricioandrade\Splitesql;


class SQLselect extends consts
{
    protected static $stmt;
    protected static $sql;
    protected static $Return;
    protected static $Table;
    protected static $Value;

    protected static function spliteReturn($return){
        try {
            self::$stmt = Connection::connect()->prepare(self::$sql);
            self::$stmt->execute();
            switch($return):
                case self::count:
                     self::setReturn(self::$stmt->rowCount());
                     break;
                case self::fetch:
                     self::setReturn(self::$stmt->fetchAll(\PDO::FETCH_OBJ));;
                    break;
            endswitch;
            return self::getReturn();
        }
        catch (\Throwable $exception) {
             echo $exception->getMessage();
        }
    }

    private static function setReturn($return){
        self::$Return = $return;
    }
    private static function getReturn(){
        return self::$Return;
    }
    #SELECT_ALL_WHERE_LIKE
    public static function SELECT_ALL_WHERE_LIKE(string $TABLE, string $COLUMN, string $LIKE,  string $return){
        self::$sql = "SELECT * FROM $TABLE WHERE $COLUMN LIKE '$LIKE%'";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    #SELECT_ALL_WHERE_AND_LIKE
    public static function SELECT_ALL_WHERE_AND_LIKE(string $TABLE, string $COLUMN, string $COLUMN2, string $LIKE, string $EQUAL2,  string $return){
        self::$sql = "SELECT * FROM $TABLE WHERE $COLUMN AND $COLUMN2 = '$EQUAL2' LIKE '$LIKE%'";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    #SELECT_ALL_WHERE_AND_1
    public static function SELECT_ALL_WHERE_AND_1( string $TABLE, string $COLUMN,
                                                   string $EQUAL, string $COLUMN2, string $EQUAL2,  string $return){
        self::$sql = "SELECT * FROM $TABLE WHERE $COLUMN = '$EQUAL' AND $COLUMN2 = '$EQUAL2'";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    #SELECT_ALL_WHERE_AND_2
    public static function SELECT_ALL_WHERE_AND_2( string $TABLE, string $COLUMN,
                                                   string $EQUAL, string $COLUMN2, string $EQUAL2,  string $COLUMN3, string $EQUAL3,  string $return){
        self::$sql = "SELECT * FROM $TABLE WHERE $COLUMN = '$EQUAL' AND $COLUMN2 = '$EQUAL2' AND $COLUMN3 = '$EQUAL3'";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    public static function SELECT_1_ROW(string $COLUMN, string $TABLE, string $return){
        self::$sql = "SELECT $COLUMN FROM $TABLE";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_WHERE(string $table, string $WHERE, string $EQUAL, string $return){
        self::$sql = "SELECT * FROM $table WHERE $WHERE = '$EQUAL'";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_WHERE_LIMIT(string $table, string $WHERE, string $EQUAL, string $limit, string $return){
        self::$sql = "SELECT * FROM $table WHERE $WHERE = '$EQUAL' LIMIT $limit";


        return self::spliteReturn($return);
    }


    public static function SELECT_WHERE_LIMIT(string $column, string $table, string $WHERE, string $EQUAL, string $limit, string $return){
        self::$sql = "SELECT $column FROM $table WHERE $WHERE = '$EQUAL' LIMIT $limit";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    public static function SELECT_3_WHERE(string $referenceColumn1, string $referenceColumn2, string $referenceColumn3, string $table, string $WHERE, string $EQUAL, string $return){
        self::$sql = "SELECT $referenceColumn1, $referenceColumn2, $referenceColumn3 FROM $table WHERE $WHERE = '$EQUAL'";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    public static function SELECT_2_WHERE(string $referenceColumn1, string $referenceColumn2, string $table, string $WHERE, string $EQUAL1, string $AND, string $EQUAL2, string $return){
        self::$sql = "SELECT $referenceColumn1, $referenceColumn2 FROM $table WHERE $WHERE = '$EQUAL1' AND $AND = '$EQUAL2'";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_WHERE_2(string $table, string $WHERE, string $EQUAL1, string $AND, string $EQUAL2, string $return){
        self::$sql = "SELECT * FROM $table WHERE $WHERE = '$EQUAL1' AND $AND = '$EQUAL2'";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        self::$stmt->execute();

        return self::spliteReturn($return);
    }

    public static function SELECT_1_WHERE_2(string $referenceColumn1, string $table, string $WHERE, string $EQUAL1, string $AND, string $EQUAL2, string $return){
        self::$sql = "SELECT $referenceColumn1 FROM $table WHERE $WHERE = '$EQUAL1' AND $AND = '$EQUAL2'";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL(string $table, string $return){
        self::$sql = "SELECT * FROM $table";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_ORDER_DESC(string $table, string $COLUMN, string $return){
        self::$sql = "SELECT * FROM $table ORDER BY $COLUMN DESC";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }


    public static function SELECT_ALL_ORDER_DESC_LIMIT(string $table, string $COLUMN, string $limit, string $return){
        self::$sql = "SELECT * FROM $table ORDER BY $COLUMN DESC LIMIT $limit";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_ORDER_ASC(string $table, string $COLUMN, string $return){
        self::$sql = "SELECT * FROM $table ORDER BY $COLUMN";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_ORDER_ASC_LIMIT(string $table, string $COLUMN, int $limit, string $return){
        self::$sql = "SELECT * FROM $table ORDER BY $COLUMN LIMIT $limit";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_ORDER_ASC_WHERE(string $table, $COLUMN_ref, string $equal, string $order_row, string $return){
        self::$sql = "SELECT * FROM $table WHERE $COLUMN_ref = '$equal' ORDER BY $order_row ";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_ORDER_DESC_WHERE(string $table, string $column, string $referenceColumn1, string $COLUMN, string $return){
        self::$sql = "SELECT * FROM {$table} WHERE {$column} = {$referenceColumn1} ORDER BY {$COLUMN} DESC";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }

    public static function SELECT_ALL_ORDER_DESC_WHERE_LIMIT(string $table, string $WHERE, string $Equal, string $COLUMN, string $limit, string $return){
        self::$sql = "SELECT * FROM $table WHERE $WHERE = '$Equal' ORDER BY $COLUMN DESC LIMIT $limit";
        self::$stmt = Connection::connect()->prepare(self::$sql);

        return self::spliteReturn($return);
    }
    public static function SELECT(string $column, string $table, string $WHERE, string $EQUAL, string $return){
        self::$sql = "SELECT $column FROM $table WHERE $WHERE = '$EQUAL'";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        return self::spliteReturn($return);
    }

}