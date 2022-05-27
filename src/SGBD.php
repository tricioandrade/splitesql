<?php


namespace Tricioandrade\Splitesql;

class SGBD extends Connection
{
    /***
     * @author Patricio Bento Andrade
     * @copyright tricioandarade - Patrício Andrade All Rights Reserved
     * @license  MIT
     * @since 2020
     * @class SGBD START
     */

    #SGBD Proprietes

    private static $nts_value;
    private static $x_value;
    private static $y_value;
    private static $query;

    /**
     * SGBD constructor. Set Connection Proprieties
     */
    public function __construct(string $host, string $user, string $charset, string $database, string $password)
    {
        self::setHost($host);
        self::setUser($user);
        self::setCharset($charset);
        self::setDatabase($database);
        self::setPassword($password);
        self::connect();
    }

    #Set Query Result
    private static function setQuery($query){
        self::$query = $query;
    }
    #Get Query Return
    private static function getQuery(){
        return self::$query;
    }

    #Certification Of Anny Operation
    public static function queryState(){
        return self::$nts_value;
    }

    #getting boolean states for Verification
    private static function get_bool_state(bool $state){
        if ($state): self::$nts_value = $state;
        else: self::$nts_value = $state;
        endif;
    }

    #set x Verification Value
    private static function set_x_check(string $table){
        self::$x_value = SQLcount::rowCount("$table");
    }
    #set y Verification Value
    private static function set_y_check(string $table){
        self::$y_value = SQLcount::rowCount("$table");
    }

    #get x Verification Value
    private static function get_x(){
        return self::$x_value;
    }
    #get y Verification Value
    private static function get_y(){
        return self::$y_value;
    }

    #get x,y boolean values and Verify
    private static function resul_z(int $first, int $second){
        if ($first < $second):
            self::get_bool_state(true);
        else:
            self::get_bool_state(false);
        endif;
    }

    public static function create_table(){

    }
    #count_method
    public static function sql_count_by_1_row($table, $column1, $value){
        return SQLselect::SELECT("$column1", "$table", "$column1", "$value", SQLcount::count);
    }

    #select
    /*one*/
    public static function select_one_row(string $column, string $table){
        if(SQLcount::rowCount("$table")):
            self::get_bool_state(true);
            return SQLselect::SELECT_1_ROW("$column", "$table",consts::fetch);
        else:
            self::get_bool_state(false);
        endif;
    }
    /*all*/
    public static function select_all(string $table){
        if(SQLcount::rowCount("$table")):
            self::get_bool_state(true);
            return SQLselect::SELECT_ALL("$table", consts::fetch);
        else:
            self::get_bool_state(false);
        endif;
    }

    /*all by one Reference*/
    public static function select_all_by_row_where_value(string $table, string $column, string $ref){
        if(SQLcount::count_by_1_row("{$table}", "{$column}", "{$ref}")):
            self::get_bool_state(true);
            return SQLselect::SELECT_ALL_WHERE("$table", "$column", "$ref", consts::fetch);
        else:
            self::get_bool_state(false);
        endif;
    }

    /*all select order by asc */
    public static function select_all_asc(string $table, string $column){
        if(SQLcount::rowCount("$table")):
            self::setQuery(SQLselect::SELECT_ALL_ORDER_ASC("$table","$column",  consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }

    /*all select order by asc limit*/
    public static function select_all_asc_limit(string $table, string $column, int $limit){
        if(SQLcount::rowCount("$table")):
            self::setQuery(SQLselect::SELECT_ALL_ORDER_ASC_LIMIT("$table","$column",   $limit, consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }
    /*all select order by desc */
    public static function select_all_desc_limit(string $table, string $column, string $limit){
        if(SQLcount::rowCount("$table")):
            self::setQuery(SQLselect::SELECT_ALL_ORDER_DESC_LIMIT("$table","$column",  "$limit",consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }
    /*all select order by asc Where*/
    public static function select_all_asc_where(string $table, string $column, string $equal, string $order_by){
        if(SQLcount::rowCount("{$table}")):
            self::setQuery(SQLselect::SELECT_ALL_ORDER_ASC_WHERE("$table","$column",  "$equal", "$order_by", consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }
    /*all select Where Like*/
    public static function select_all_where_like(string $table, string $column, string $like){
        if(SQLcount::rowCount("$table")):
            self::setQuery(SQLselect::SELECT_ALL_WHERE_LIKE("$table","$column",  "$like", consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }

    /*one select where limit */
    public static function select_one_where_limit(string $column, string $table, string $where, string $equal, string $limit){
        if(SQLcount::rowCount("$table")):
            self::setQuery(SQLselect::SELECT_WHERE_LIMIT("$column", "$table", "$where", "$equal", "$limit", consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }
    /*all select order by desc limit*/
    public static function select_all_desc_where_limit(string $table, string $column,string $equal, string $order_by, string $limit){
        if(SQLcount::rowCount("$table")):
            self::setQuery(SQLselect::SELECT_ALL_ORDER_DESC_WHERE_LIMIT("$table","$column", "$equal", "$order_by", $limit, consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }
    /*all select order by desc limit*/
    public static function select_all_desc_where(string $table, string $column,string $equal, string $order_by){
        if(SQLcount::rowCount("$table")):
            self::setQuery(SQLselect::SELECT_ALL_ORDER_DESC_WHERE("$table","$column", "$equal", "$order_by", consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }

    /*one*/
    public static function select_one(string $column, string $table, string $where, string $ref){
        if(SQLcount::count_by_1_row("$table", "$where", "$ref")):
            self::setQuery(SQLselect::SELECT("$column", "$table","$where", "$ref", consts::fetch)[0]);
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }

    /*one -> bytwo*/
    public static function select_one_where_2(string $column, string $table, string $where_row1, string $equal1, string $where_row2, string $equal2, string $data){
        if(Inspection::sql_count_by_1_row("$table", "$where_row1", "$equal1")):
            self::setQuery(SQLselect::SELECT_1_WHERE_2("$column", "$table","$where_row1","$equal1", "$where_row2", "$equal2", consts::fetch)[0]);
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }


    /*all -> bytwo*/
    public static function select_all_where_2( string $table, string $where_row1, string $equal1, string $where_row2, string $equal2){
        if(Inspection::sql_count_by_1_row("$table", "$where_row1", "$equal1")):
            self::setQuery(SQLselect::SELECT_ALL_WHERE_2("$table", "$where_row1","$equal1", "$where_row2", "$equal2", consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }

    #Select by a limit
    /*Select all Limit[]*/
    public static function select_all_where_limit(string $table, string $column, string $equal_value, string $limit){
        if(Inspection::sql_count_by_1_row("$table", "$column", "$equal_value")):
            self::get_bool_state(true);
            self::setQuery(SQLselect::SELECT_ALL_WHERE_LIMIT("$table", "$column", "$equal_value", "$limit", consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }


    #JOINs
    public static function join_tables_2(string $table1, string $column1, string $table2, string $column2, string $column3, string $column4){
        if(SQLcount::rowCount("$table1") && SQLcount::rowCount("$table2")):
            self::setQuery(SQLjoin::JOIN_TABLES_2($table1, $column1, $table2, $column2, $column3,  $column4, consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }
    public static function join_tables_3(string $table1, string $column1, string $table2, string $column2, string $table3, string $column3, string $columnref1, string $columnref2){
        if(SQLcount::rowCount("$table1") && SQLcount::rowCount("$table2") && SQLcount::rowCount("$table3")):
            self::setQuery(SQLjoin::JOIN_TABLES_3($table1, $column1, $table2, $column2, $table3, $column3, $columnref1,  $columnref2, consts::fetch));
            if (self::getQuery()):
                self::get_bool_state(true);
                return self::getQuery();
            else:
                self::get_bool_state(false);
            endif;
        else:
            self::get_bool_state(false);
        endif;
    }
}