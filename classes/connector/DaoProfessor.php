<?php
require_once('Connection.php');
require_once('PojoProfessor.php');
require_once('classes/Alerts.php');

class DaoProfessor
{
    public static $instance;

    public function __construct()
    {
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM professor WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);

            if ($p_sql->execute()) {
                Alerts::setAlert('success', 'bookingSuccess');
                return true;
            } else {
                Alerts::setAlert('danger', "Error " . $p_sql->errorCode() . ": " . $p_sql->errorInfo()[2]);
                return false;
            }
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function findById($id)
    {
        try {
            $sql = "SELECT * FROM professor WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();

            return $this->pojoProfessor($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function findByCpf($cpf)
    {
        try {
            $sql = "SELECT * FROM professor WHERE cpf = :cpf";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":cpf", $cpf);
            $p_sql->execute();

            return $this->pojoProfessor($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DaoProfessor();
        }

        return self::$instance;
    }

    public function insert(PojoProfessor $professor)
    {
        if (strlen($professor->getCpf()) == 14 && strlen($professor->getName()) <= 80) {
            $sql = "SELECT * FROM professor WHERE cpf = :cpf";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":cpf", $professor->getCpf());
            $p_sql->execute();

            if ($p_sql->fetchColumn(0) >= 1) {
                Alerts::setAlert('danger', 'professorAlreadyInDatabase');
                return null;
            } else {
                try {
                    $sql = "INSERT INTO professor (nome, cpf) VALUES (:name, :cpf)";

                    $p_sql = Connection::getInstance()->prepare($sql);
                    $p_sql->bindValue(":name", $professor->getName());
                    $p_sql->bindValue(":cpf", $professor->getCpf());

                    if ($p_sql->execute()) {
                        Alerts::setAlert('success', 'professorSuccess');
                        return true;
                    } else {
                        Alerts::setAlert('danger', "Error " . $p_sql->errorCode() . ": " . $p_sql->errorInfo()[2]);
                        return false;
                    }
                } catch (Exception $e) {
                    print $e->getMessage() . ": " . $e->getCode();
                    return null;
                }
            }
        } else {
            Alerts::setAlert('danger', 'verifyData');
            return null;
        }
    }

    public function listAll()
    {
        try {
            $sql = "SELECT * FROM professor";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->execute();

            $PDO = array();
            while ($o = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                $PDO[] = $o;
            }
            return $PDO;
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function update(PojoProfessor $professor)
    {
        try {
            $sql = "UPDATE professor SET nome = :name, cpf = :cpf WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":name", $professor->getName());
            $p_sql->bindValue(":cpf", $professor->getCpf());
            $p_sql->bindValue(":id", $professor->getId());
            if ($p_sql->execute()) {
                Alerts::setAlert('success', 'professorUpdated');
                return true;
            } else {
                Alerts::setAlert('danger', "Error " . $p_sql->errorCode() . ": " . $p_sql->errorInfo()[2]);
                return false;
            }

        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function pojoProfessor($row)
    {
        $pojoProfessor = new PojoProfessor();
        $pojoProfessor->setId($row['id']);
        $pojoProfessor->setName($row['nome']);
        $pojoProfessor->setCpf($row['cpf']);
        return $pojoProfessor;
    }
}