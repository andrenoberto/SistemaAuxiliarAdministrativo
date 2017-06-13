<?php

class Connection
{
    public static $instance;

    private function __construct()
    {
    }

    private static function getConnectionInfo()
    {
        switch (DB_MS) {
            case 'mssql':
                $dbPort = (DB_PORT == '') ? 1433 : DB_PORT;
                $info = "sqlsrv:Server=" . DB_HOST . "," . $dbPort . ";Database=" . DB_NAME;
                return $info;
            default:
                return null;
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PDO(self::getConnectionInfo(), DB_USER, DB_PASS);
            //self::$instance = new PDO(self::getConnectionInfo(), DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true));
        }

        return self::$instance;
    }
}