<?php

namespace APP\LIB\DATABASE;

class PDODatabaseHandler extends DatabaseHandler
{
    private static $_instance;
    private static $_handler;

    const OPTIONS = array(
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // Write abrabic
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    );

    private function __construct() {
        self::init();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array(&self::$_handler, $name), $arguments);
    }

    protected static function init()
    {
        try
        {
            self::$_handler = new \PDO("mysql://host=" . DATABASE_HOST_NAME . ";dbname=" . DATABASE_DB_NAME,DATABASE_USER_NAME, DATABASE_PASSWORD, self::OPTIONS);
        }
        catch (\PDOException $e)
        {

        }
    }

    public static function getInstance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}





?>