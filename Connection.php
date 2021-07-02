<?php


namespace App\Model\SpliteSQL;
use PDO;

abstract class Connection
{
    /***
     * @param Connection $Proprietie
     */

    #Connection Propriete

    protected static $host;
    protected static $user;
    protected static $charset;
    protected static $database;
    protected static $password;
    private static $sql;

    /**@param Setters $database*/
    protected static function setDatabase(string $database){   self::$database = $database;}
    protected static function setHost(string $host){   self::$host = $host;}
    protected static function setUser(string $user){   self::$user = $user;}
    protected static function setPassword(string $password){   self::$password = $password;}
    protected static function setCharset(string $charset){     self::$charset = $charset;}

    /**@return Getters*/
    private static function getDatabase(){ return self::$database;  }
    private static function getHost(){     return self::$host;  }
    private static function getUser(){     return self::$user;  }
    private static function getPassword(){ return self::$password;  }
    private static function getCharset(){  return self::$charset;   }

    #Start Connection
    public static function connect(){
        if (!empty(self::getDatabase()) && !empty(self::getHost()) && !empty(self::getUser())):
            try {
                self::$sql = new PDO("mysql:host=" . self::getHost() . ";dbname=" . self::getDatabase(). ";charset=".self::getCharset().";", self::getUser(), self::getPassword());
                self::$sql->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
                return self::$sql;
            }
            catch (\PDOException $exception){
                echo "<script>alert('Connection Error: ".$exception->getMessage()."');</script>";
                die();
            }

        else:
            echo "<script>alert('There is an empty param');</script>";
        endif;
    }
}