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

    private  $sql;
    private  $stmt;

    private  $columns;
    private  $column;
    private  $table;
    private  $value;
    private  $columValues;

    private  $objectVars;
    private  $array_keys;
    private  $array_values;
    private  $select_values;
    private  $array_to_filter;
    private  $select_data_for_query;
    private  $resultState = false;

    private  $where;
    private  $query;
    private  $fetch;
    private  $rowCount;

    private  $queryConsts = [
        self::create,
        self::update,
        self::select,
        self::delete
    ];

    /**
     * @return bool
     */
    public function queryState(): bool{
        return $this->resultState;
    }

    /**
     * @param mixed $Query
     */
    private  function setQuery(): void {
        $this->query = new \ArrayObject();
        
        $this->query->id = $this->fetch !== null ? function (){
            $array = array();
            foreach ($this->fetch as $key => $item):
                $array[$key] = $item->id;
            endforeach;
            return $array;
        } : null ;
        
        $this->query->get = function () {
            return $this->fetch ?? null; 
        };
        
        $this->query->count = function (){
            return $this->rowCount ?? null; 
        };
        
        $this->query->queryState = $this->resultState;
    }
    /**
     * @return mixed
     */
    public function result(){
        return $this->query;
    }

    /**
     * @param mixed $fetch
     */
    public function setFetch($fetch): void
    {
        $this->fetch = $fetch;
    }

    /**
     * @param mixed $rowCount
     */
    private  function setRowCount($rowCount): void{
        $this->rowCount = $rowCount;
    }

    /**
     * @return mixed
     */
    private  function getColumns(){
        return $this->columns;
    }

    /**
     * @return mixed
     */
    private  function getColumnValues(){
        return $this->columValues;
    }
    
    /**
     * Setting array or object to get array and extract values from index's
     * @method setObjectToGetArray
     * @param array | object $param
     */

    public function setObjectToGetArray(array | object $param){
        if (is_object($param)) $param = get_object_vars($param);
        $this->objectVars = $param;
    }

    /**
     * Setting Columns from Array and create new from extracted object
     * using json_encode() to "stringfy" and clean invalid chars
     * @method setColumns
     * @param array|object $columns
     */
    private  function setColumns(array | object $columns): void {
        $this->setObjectToGetArray($columns);
        $this->columns = str_replace(['[',']', '{','}', '"' ,'"'],  '', $this->encode_json(array_keys($this->getObjectConvertedToArray())));
    }

    /**
     * Setting Values from Array and create new from extracted object
     * using json_encode() to "stringfy" and clean invalid chars
     * @method setValues
     * @param array|object $columnValues
     */
    private  function setColumnValues(array | object $columnValues ): void {
        $this->setObjectToGetArray($columnValues);
        $this->columValues = str_replace('"', '\'' , str_replace(['[',']', '{','}'],  '', $this->encode_json(array_values($this->getObjectConvertedToArray()))));
    }

    /**
     * @return array array
     */
    public function getObjectConvertedToArray(){
        return $this->objectVars;
    }


    /**
     * @method setArrayToGetKeys
     * @param array to get Keys 
     */

    private  function setArrayToGetKeys(array $array){
        $this->array_keys = array_keys($array);
    }
    
    /**
     * @method getArrayKeys
     * @return array
     */
    public function getArrayKeys(): array{
        return $this->array_keys;
    }


    /**
     * @method setArrayToGetValues
     * @param array to get Values
     */

    public function setArrayToGetValues(array $array){
        $this->array_values = array_values($array);
    }
    
    /**
     * @method getArrayValues
     * @return array
     */
    private  function getArrayValues(){
        return $this->array_values;
    }

    public function setValuesAndCleanIt($columnValues){
        $this->select_values = str_replace('$', '\'' , str_replace(['[',']', '\'' ,'{','}'],  '', $this->encode_json(array_values($columnValues))));
    }

    public function getValuesCleaned(): string{
        return $this->select_values;   
    }

    /**
     * @method setSelectQueryValues
     * @param array $columnValues
     */
    private  function setQueryColumnValues($columnValues){
            $new = array();
            $this->setObjectToGetArray($columnValues);
            $this->setArrayToGetKeys((array)$this->getObjectConvertedToArray());
            $this->setArrayToGetValues((array)$this->getObjectConvertedToArray());

            for($i = 0; $i < count($this->getArrayKeys()); $i++):
                $new[$i] = $this->getArrayKeys()[$i] . "=\$" . $this->getArrayValues()[$i] ."\$";
            endfor;

            $this->setValuesAndCleanIt($new);
            $this->select_data_for_query =  $this->getValuesCleaned();
    }

    /**
     * @param 
     * @return string
     */
    private  function getQueryColumnValues():string {
        return $this->select_data_for_query;
    }

    /**
     * Setting the query result state
     * @method setResultState
     * @param bool $state
     */
    private  function setResultState(bool $state){
        $this->resultState = $state;
    }

    /**
     * Encode string to Array, using Json
     * @param array|object $array
     * @return array
     */
    private  function encode_json(array $array): string {
        $array = str_replace('\\',' ',json_encode($array, JSON_UNESCAPED_UNICODE));
        $array = str_replace('  ', '/', $array);
        $array = str_replace(' /', '/', $array);

        return $array;
    }


    public function connectDB(string $host, string $user, string $charset, string $database, string $password)
    {
        $this->setHost($host);
        $this->setUser($user);
        $this->setCharset($charset);
        $this->setDatabase($database);
        $this->setPassword($password);

        $this->connect();
    }


    protected  function whereCondition ($value): string{
        return $this->row ? self::where." ".$this->row ." ".$this->symbol." {$value}" : 'id '.$this->symbol." ".$value;
    }

    /**
     * @return string
     */
    protected  function getOr (): string{
        $this->getWhere();
        return $this->or_ ? $this->or." ".$this->or_ : '';
    }

    /**
     * @return string
     */
    protected  function getAnd (): string{
        return $this->and_ ? $this->and." ".$this->and_ : '';
    }

    /**
     * @return string
     */
    protected  function getLimit (): string{
        return $this->limitRows ? self::limit. ' '.$this->limitRows : '';
    }

    /**
     * @return string
     */
    protected  function getOrderBy (): string{
        return $this->orderBy ? $this->order. ' '.$this->orderBy : '';
    }

    /**
     * @param string $table
     * @param array|object $param
     */
    public function insert(string $table, array | object $param): void{
        $this->setColumns($param);
        $this->setColumnValues($param);
        $this->sql = $this->insert." into {$table} (".$this->getColumns().") values (".$this->getColumnValues().")";
        $this->stmt = Connection::connect()->prepare($this->sql);
        $this->resultState = $this->stmt->execute() ?? false;
        $this->setQuery();
    }

    /**
     * @param mixed $array_to_filter
     */
    public function setArrayToFilter($array_to_filter): void{
        if (is_object($array_to_filter)) $array_to_filter = $this->setObjectToGetArray($array_to_filter);
        $this->setArrayToGetKeys($array_to_filter);
        $array_keys = $this->getArrayKeys();
        for($i=0; $i < count($array_to_filter); $i++):
            $this->array_to_filter[$array_keys[$i]] = filter_var($array_to_filter[$array_keys[$i]], FILTER_SANITIZE_STRING);
        endfor;
    }

    /**
     * @return mixed
     */
    public function getArrayToFilter(){
        return $this->array_to_filter;
    }

    /**
     * @param string $table
     */
    public function all( string $table): void{
        $this->query($this->select." * {$table}");
    }

    /**
     * @return mixed
     */
    private function getWhere(){
        return $this->where;
    }

    /**
     * @param array|string $column
     * @param string $table
     * @param int|string|null $value
     */
    public function where($column, string $table){
        if (is_array($column)): $this->setQueryColumnValues($column); $column = $this->getQueryColumnValues(); endif;
        $this->table = $table;
        $this->column = $column;

        $this->stmt = new \ArrayObject();

        $this->sql = function (){
             $this->query($this->select." {$this->column} from {$this->table} ".
                $this->whereCondition($this->value).
                $this->getAnd().
                $this->getOr().
                $this->getOrderBy().
                $this->getLimit());
        };

        $this->where = new \ArrayObject();
        $this->where->row   =   function ( $row, int | string $value, int $limit){
            $this->value = $value;
            $this->row  = $row;
            $this->limitRows = $limit;

            $this->stmt->or        =   function (string $or, string $orderBy){
                $this->or_ = $or;
                $this->sql;
                return ($this->orderBy = $orderBy) ? $this->stmt->orderby = function (){
                    $this->sql;
                    return $this->result();
                } : $this->result();
            };

            $this->stmt->and =  function (string $and, string $orderBy){
                $this->and_ = $and;
                $this->sql;
                return ($this->orderBy = $orderBy) ? $this->stmt->get = function (){
                    $this->sql;
                    return $this->result();
                } : $this->result();
            };

        };

    }



    /**
     * @Model  function
     * @param string $SQL
     * @param string|null $type_of_return
     * @return \Closure
     */

    public function query(string $sql){
        $this->stmt = Connection::connect()->prepare($sql);
        if ($this->stmt->execute()):
            for ($i = 0; $i < count($this->queryConsts); $i++):
                if(false !== stripos($sql, $this->queryConsts[$i]))
                    $this->setResultState(true);
                $this->setQuery();
            endfor;
            if (false !== stripos($sql, $this->select)):
                $this->setResultState(true);
                $this->setRowCount($this->stmt->rowCount());
                $this->setFetch($this->stmt->fetchAll(\PDO::FETCH_OBJ));
                $this->setQuery();
            endif;
        else:
            $this->setResultState(false);
        endif;

        return $this->result();
    }

 }
