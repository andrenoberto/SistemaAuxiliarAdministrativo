<?php
require_once('Connection.php');
require_once('PojoUser.php');

class DaoUser
{
    public static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DaoUser();
        }

        return self::$instance;
    }

    public function insert(PojoUser $user)
    {
        try {
            $sql = "INSERT INTO usuario (username, password, email, name) VALUES (:username, :password, :email, :name)";

            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":username", $user->getName());
            $p_sql->bindValue(":password", $user->getPassword());
            $p_sql->bindValue(":email", $user->getEmail());
            $p_sql->bindValue(":name", $user->getName());

            return $p_sql->execute();
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM usuario WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);

            return $p_sql->execute();
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();

            return $this->pojoUser($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function findByUsername($username)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE username = :username";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":username", $username);
            $p_sql->execute();

            return $this->pojoUser($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function authenticate($username, $password)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE username = :username AND password = :password";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":username", $username);
            $p_sql->bindValue(":password", $password);
            $p_sql->execute();

            return $p_sql->fetchColumn(0);
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    private function pojoUser($row)
    {
        $pojoUser = new PojoUser();
        $pojoUser->setId($row['id']);
        $pojoUser->setName($row['name']);
        $pojoUser->setUsername($row['username']);
        $pojoUser->setPassword($row['password']);
        $pojoUser->setEmail($row['email']);
        return $pojoUser;
    }
}