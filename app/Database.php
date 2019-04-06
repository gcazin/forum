<?php

class Database
{
    private $PDOInstance = null;

    private static $instance = null;

    const DB_HOST = 'localhost';

    const DB_DATABASE = 'forum';

    const DB_USER = 'root';

    const DB_PASS = 'root';

    private function __construct()
    {
        $this->PDOInstance = new PDO('mysql:dbname='.self::DB_DATABASE.';host='.self::DB_HOST,self::DB_USER,self::DB_PASS);
        $this->PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function connect()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($query)
    {
        return $this->PDOInstance->query($query);
    }

    public function prepare($query)
    {
        return $this->PDOInstance->prepare($query);
    }

}
