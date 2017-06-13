<?php

class SqlQuery
{
    private $dbhost = "192.168.3.2";
    private $db = "ativ_compl";
    private $user = "ativ_compl";
    private $password = "ativ_compl";
    private $connection = null;

    public function __construct()
    {
        $connectionInfo = array("Database" => $this->db, "UID" => $this->user, "PWD" => $this->password);
        $this->connection = sqlsrv_connect($this->dbhost, $connectionInfo);
        if (!$this->connection) {
            echo "Connection could not be established.<br />";
            die(print_r(sqlsrv_errors(), true));
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}