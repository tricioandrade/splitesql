<?php

/***
 * @author Patrício Andrade
 * @user tricioandrade - All Rights Reserved
 * @license  MIT
 * @since 2020
 * @Github http://github.com/tricioandrade/splitesql
 * @class Query
 */

namespace Tricioandrade\Splitesql;

class  Query extends Connection
{

    private static $sql;
    private static $stmt;

    private static $columns;
    private static $columValues;

    private static $objectVars;
    private static $array_keys;
    private static $array_values;
    private static $select_values;
    private static $array_to_filter;
    private static $select_data_for_query;
    private static $resultState = false;

    private static $query;
    private static $fetch;
    private static $rowCount;

    private static $queryConsts = [
        self::create,
        self::update,
        self::select,
        self::delete
    ];

    public function __construct(string $host, string $user, string $charset, string $database, string $password)
    {
        self::setHost($host);
        self::setUser($user);
        self::setCharset($charset);
        self::setDatabase($database);
        self::setPassword($password);
        self::connect();
    }

    /**
     * @return bool
     */
    public static function queryState(): bool{
        return self::$resultState;
    }

    /**
     * @param mixed $Query
     */
    private static function setQuery(): void {
        self::$query = new \ArrayObject();
        self::$query->id = self::$fetch !== null ? function (){
            $array = array();
            foreach (self::$fetch as $key => $item):
                $array[$key] = $item->id;
                     endforeach;
                        return $array;
                                    } : null ;
        self::$query->get = self::$fetch ?? null;
        self::$query->count = self::$rowCount ?? null;
        self::$query->queryState = self::$resultState;
    }
    /**
     * @return mixed
     */
    private static function getQuery(){
        return self::$query;
    }

    /**
     * @param mixed $fetch
     */
    public static function setFetch($fetch): void
    {
        self::$fetch = $fetch;
    }

    /**
     * @param mixed $rowCount
     */
    private static function setRowCount($rowCount): void{
        self::$rowCount = $rowCount;
    }

    /**
     * @return mixed
     */
    private static function getColumns(){
        return self::$columns;
    }

    /**
     * @return mixed
     */
    private static function getColumnValues(){
        return self::$columValues;
    }
    
    /**
     * Setting array or object to get array and extract values from index's
     * @method setObjectToGetArray
     * @param array | object $param
     */

    public static function setObjectToGetArray(array | object $param){
        if (is_object($param)) $param = get_object_vars($param);
        self::$objectVars = $param;
    }

    /**
     * Setting Columns from Array and create new from extracted object
     * using json_encode() to "stringfy" and clean invalid chars
     * @method setColumns
     * @param array|object $columns
     */
    private static function setColumns(array | object $columns): void {
        self::setObjectToGetArray($columns);
        self::$columns = str_replace(['[',']', '{','}', '"' ,'"'],  '', self::encode_json(array_keys(self::getObjectConvertedToArray())));
    }

    /**
     * Setting Values from Array and create new from extracted object
     * using json_encode() to "stringfy" and clean invalid chars
     * @method setValues
     * @param array|object $columnValues
     */
    private static function setColumnValues(array | object $columnValues ): void {
        self::setObjectToGetArray($columnValues);
        self::$columValues = str_replace('"', '\'' , str_replace(['[',']', '{','}'],  '', self::encode_json(array_values(self::getObjectConvertedToArray()))));
    }

    /**
     * @return array array
     */
    public static function getObjectConvertedToArray(){
        return self::$objectVars;
    }


    /**
     * @method setArrayToGetKeys
     * @param array to get Keys 
     */

    private static function setArrayToGetKeys(array $array){
        self::$array_keys = array_keys($array);
    }
    
    /**
     * @method getArrayKeys
     * @return array
     */
    public static function getArrayKeys(): array{
        return self::$array_keys;
    }


    /**
     * @method setArrayToGetValues
     * @param array to get Values
     */

    public static function setArrayToGetValues(array $array){
        self::$array_values = array_values($array);
    }
    
    /**
     * @method getArrayValues
     * @return array
     */
    private static function getArrayValues(){
        return self::$array_values;
    }

    public static function setValuesAndCleanIt($columnValues){
        self::$select_values = str_replace('$', '\'' , str_replace(['[',']', '\'' ,'{','}'],  '', self::encode_json(array_values($columnValues))));
    }

    public static function getValuesCleaned(): string{
        return self::$select_values;   
    }

    /**
     * @method setSelectQueryValues
     * @param array $columnValues
     */
    private static function setQueryColumnValues($columnValues){
            $new = array();
            self::setObjectToGetArray($columnValues);
            self::setArrayToGetKeys((array)self::getObjectConvertedToArray());
            self::setArrayToGetValues((array)self::getObjectConvertedToArray());

            for($i = 0; $i < count(self::getArrayKeys()); $i++):
                $new[$i] = self::getArrayKeys()[$i] . "=\$" . self::getArrayValues()[$i] ."\$";
            endfor;

            self::setValuesAndCleanIt($new);
            self::$select_data_for_query =  self::getValuesCleaned();
    }

    /**
     * @param 
     * @return string
     */
    private static function getQueryColumnValues():string {
        return self::$select_data_for_query;
    }

    /**
     * Setting the query result state
     * @method setResultState
     * @param bool $state
     */
    private static function setResultState(bool $state){
        self::$resultState = $state;
    }

    /**
     * Encode Object or Array to Json
     * @param array|object $array
     * @return array
     */
    private static function encode_json(array | object $array): array{
        $array = str_replace('\\',' ',json_encode($array, JSON_UNESCAPED_UNICODE));
        $array = str_replace('  ', '/', $array);
        $array = str_replace(' /', '/', $array);

        return $array;
    }


    /**
     * @param $value
     * @return string
     */

    protected static function whereCondition ($value): string{
        return self::$row ? self::where." ".self::$row ." ".self::$symbol." {$value}" : 'id '.self::$symbol." ".$value;
    }

    /**
     * @return string
     */
    protected static function or_ (): string{
        return self::$or_ ? self::$or." ".self::$or_ : '';
    }

    /**
     * @return string
     */
    protected static function and_ (): string{
        return self::$and_ ? self::$and." ".self::$and_ : '';
    }

    /**
     * @return string
     */
    protected static function limit (): string{
        return self::$limitRows ? self::limit. ' '.self::$limitRows : '';
    }

    /**
     * @return string
     */
    protected static function orderBy (): string{
        return self::$orderBy ? self::$order. ' '.self::$orderBy : '';
    }

    /**
     * @param string $table
     * @param array|object $param
     */
    public static function insert(string $table, array | object $param): void{
        self::setColumns($param);
        self::setColumnValues($param);
        self::$sql = self::insert." into {$table} (".self::getColumns().") values (".self::getColumnValues().")";
        self::$stmt = Connection::connect()->prepare(self::$sql);
        self::$resultState = self::$stmt->execute() ?? false;
    }

    /**
     * @param mixed $array_to_filter
     */
    public static function setArrayToFilter($array_to_filter): void{
        if (is_object($array_to_filter)) $array_to_filter = self::setObjectToGetArray($array_to_filter);
        self::setArrayToGetKeys($array_to_filter);
        $array_keys = self::getArrayKeys();
        for($i=0; $i < count($array_to_filter); $i++):
            self::$array_to_filter[$array_keys[$i]] = filter_var($array_to_filter[$array_keys[$i]], FILTER_SANITIZE_STRING);
        endfor;
    }

    /**
     * @return mixed
     */
    public static function getArrayToFilter(){
        return self::$array_to_filter;
    }

    /**
     * @param string $table
     */
    public static function all( string $table): void{
        self::query(self::select." * {$table}");
    }

    /**
     * @param array|string $column
     * @param string $table
     * @param int|string|null $value
     */
    public static function where( string | array $column, string $table, int | string $value = null): void{
        if (is_array($column)): self::setQueryColumnValues($column); $column = self::getQueryColumnValues(); endif;
        self::query(self::select." {$column} from {$table} ".
            self::whereCondition($value).
            self::and_().
            self::or_().
            self::orderBy().
            self::limit());
    }

    /**
     * @Model static function
     * @param string $SQL
     * @param string|null $type_of_return
     * @return \Closure
     */

    public static function query(string $sql){
        self::$stmt = Connection::connect()->prepare($sql);
        if (self::$stmt->execute()):
            for ($i = 0; $i < count(self::$queryConsts); $i++):
                if(false !== stripos($sql, self::$queryConsts[$i])) self::setResultState(true);
            endfor;
            if (false !== stripos($sql, self::select)):
                self::setResultState(true);
                self::setRowCount(self::$stmt->rowCount());
                self::setFetch(self::$stmt->fetchAll(\PDO::FETCH_OBJ));
                self::setQuery();
            endif;
        else:
            self::setResultState(false);
        endif;

        return self::getQuery();
    }


}
