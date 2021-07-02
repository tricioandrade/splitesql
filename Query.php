<?php

/***
 * @author Patricio Bento Andrade
 * @copyright tricioandrde - Patrício Andrade All Rights Reserved
 * @license  MIT
 * @since 2020
 * @class __Query
 */

namespace App\Model\SpliteSQL;

class  Query extends Connection
{

    const _FETCH = 'fetch';
    const _COUNT = 'count';
    const __CREATE = 'CREATE';
    const __UPDATE = 'UPDATE';
    const __DELETE = 'DELETE';
    const __SELECT = 'SELECT';
    const __INSERT = 'INSERT';
    const __WHERE = 'WHERE';
    const __SET = 'SET';
    const __LIMIT = 'LIMIT';
    const __EQUAL = '=';

    private static $sql;
    private static $stmt;
    private static $Return;

    /**
     * __Query constructor.
     * @param string $host
     * @param string $database
     * @param string $user
     * @param string|null $password
     * @param string|null $charset
     */
    public function __construct(string $host,  string $database, string $user, string $password = null, string $charset = null)
    {
        self::setHost($host);
        self::setUser($user);
        self::setCharset($charset);
        self::setDatabase($database);
        self::setPassword($password);
    }

    /**
     * @Model static function
     * @param string $param
     * @param string|null $table
     * @param string|null $return
     * @return array|bool|int
     */
    public function SplitSQL(string $SQL, string $table = null, string $return = null){
        self::$sql = $SQL;
        self::$stmt = Connection::connect()->prepare(self::$sql);
        if (self::$stmt->execute()):
            if (false !== stripos($SQL, self::__CREATE)) return true;
            if (false !== stripos($SQL, self::__UPDATE)) return true;
            if (false !== stripos($SQL, self::__DELETE)) return true;
            if (false !== stripos($SQL, self::__SELECT)):
                if ($return == self::_FETCH || $return == null):
                    return self::$stmt->fetchAll(\PDO::FETCH_OBJ);
                elseif ($return == self::_COUNT):
                    return self::$stmt->rowCount();
                endif;
            endif;
        endif;
    }
}