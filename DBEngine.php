<?php


namespace App\Model\SpliteSQL;


class DBEngine extends Connection
{
    public function __construct(string $host, string $user, string $charset, string $database, string $password)
    {
        self::setHost($host);
        self::setUser($user);
        self::setCharset($charset);
        self::setDatabase($database);
        self::setPassword($password);

        self::connect();
    }
}