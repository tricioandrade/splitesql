<?php


namespace Tricioandrade\Splitesql;

abstract class Connection extends Attributes
{
    /***
     * @param Connection $Proprieties
     */

    protected static $host;
    protected static $user;
    protected static $charset;
    protected static $database;
    protected static $password;
    private static $connection;

    /**
     * @param mixed $host
     */
    public static function setHost($host): void {
        self::$host = $host;
    }

    /**
     * @param mixed $user
     */
    public static function setUser($user): void{
        self::$user = $user;
    }

    /**
     * @param mixed $charset
     */
    public static function setCharset($charset): void{
        self::$charset = $charset;
    }

    /**
     * @param mixed $database
     */
    public static function setDatabase($database): void {
        self::$database = $database;
    }

    /**
     * @param mixed $password
     */
    public static function setPassword($password): void{
        self::$password = $password;
    }

    /**
     * @return mixed
     */
    private static function getHost(){
        return self::$host;
    }

    /**
     * @return mixed
     */
    private static function getUser(){
        return self::$user;
    }


    /**
     * @return mixed
     */
    private static function getCharset(){
        return self::$charset;
    }

    /**
     * @return mixed
     */
    private static function getDatabase(){
        return self::$database;
    }

    /**
     * @return mixed
     */
    private static function getPassword(){
        return self::$password;
    }


    /**
     * @return \Exception|\PDO|\PDOException|PDO
     */
    public static function connect(){
        try {
            self::$connection = new  \PDO(
                "mysql:host=" . self::getHost() . "; dbname=" .self::getDatabase(). ";charset=".self::getCharset().";", self::getUser(),self::getPassword(), [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', \PDO::ATTR_EMULATE_PREPARES => false]);
            self::$connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            self::$connection->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            self::$connection->setAttribute(\PDO::PARAM_STR_CHAR, 'UTF8');
        }
        catch (\PDOException $exception){
            self::$connection = $exception;
        }

        return self::$connection;
    }
}