<?php
if (THIS_SCRIPT == 'includes') {
    require_once('./config.php');
} else {
    require_once('./includes/config.php');
}

class SqlConnector
{
    private $dbhost = DB_HOST;
    private $db = DB_NAME;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $connection = null;

    public function __construct()
    {
        $connectionInfo = array("Database" => $this->db, "UID" => $this->user, "PWD" => $this->password, "CharacterSet" => "UTF-8");
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

    public function closeConnection() {
        sqlsrv_close($this->connection);
    }

    public function escapeString($subject) {
        $pattern = "/'/";
        $replacement = "''";
        return preg_replace($pattern, $replacement, $subject);
    }
}