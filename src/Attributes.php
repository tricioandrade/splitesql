<?php


namespace Tricioandrade\Splitesql;

abstract class Attributes
{
    const count = 'count';
    const fetch = 'fetch';
    const create = 'CREATE';
    const update = 'UPDATE';
    const delete = 'DELETE';
    const select = 'select';
    const insert = 'insert';
    const where = 'WHERE';
    const set = 'SET';
    const limit = 'LIMIT';

    public $create              = 'CREATE';
    public $update              = 'UPDATE';
    public $delete              = 'DELETE';
    public $select              = 'SELECT';
    public $insert              = 'INSERT';

    public $columns             = 'COLUMNS';

    public $columnType          = 'COLUMN_TYPE';
    public $columnName          = 'COLUMN_NAME';
    public $columnComment       = 'COLUMN_COMMENT';
    public $columnKey           = 'COLUMN_KEY';
    public $columnDefault       = 'COLUMN_DEFAULT';

    public $dataType            = 'DATA_TYPE';
    
    public $informationSchema   = 'INFORMATION_SCHEMA';

    public $tableSchema         = 'TABLE_SCHEMA';
    public $tableName           = 'TABLE_NAME';
    public $characterMLength    = 'CHARACTER_MAXIMUM_LENGTH';

    public $where               = 'WHERE';
    public $set                 = 'SET';
    public $limit               = 'LIMIT';
    public $alter               = 'ALTER';
    public $change              = 'CHANGE';
    public $join                = 'JOIN';

    public $constraint          = 'CONSTRAINT';
    public $references          = 'REFERENCES';


    public $and                = 'AND';


}