<?php
require_once('Connection.php');
require_once('PojoProjector.php');
if (THIS_SCRIPT != 'includes') {
    require_once('classes/Alerts.php');
}

class DaoProjector
{
    public static $instance;

    public function __construct()
    {
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM projetor WHERE id = :id";
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
            $sql = "SELECT * FROM projetor WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();

            return $this->pojoProjector($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DaoProjector();
        }

        return self::$instance;
    }

    public function listAll($ids = '')
    {
        try {
            if ($ids) {
                $sql = "SELECT * FROM projetor WHERE id NOT IN (:ids)";
            } else {
                $sql = "SELECT * FROM projetor";
            }
            $p_sql = Connection::getInstance()->prepare($sql);
            if ($ids) {
                $p_sql->bindValue(":ids", $ids);
            }
            $p_sql->execute();

            $PDO = array();
            while ($o = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                $o['modelo'] = trim($o['modelo']);
                $o['num_serie'] = trim($o['num_serie']);
                $PDO[] = $o;
            }
            return $PDO;
        } catch (Exception $e) {
            print $e->getMessage() . ": " . $e->getCode();
            return null;
        }
    }

    public function insert(PojoProjector $pojoProjector)
    {
        if (strlen($pojoProjector->getModelName()) > 0) {
            try {
                $sql = "INSERT INTO projetor (modelo, num_serie) VALUES (:modelName, :serialNumber)";

                $p_sql = Connection::getInstance()->prepare($sql);
                $p_sql->bindValue(":modelName", $pojoProjector->getModelName());
                $p_sql->bindValue(":serialNumber", $pojoProjector->getSerialNumber());

                if ($p_sql->execute()) {
                    Alerts::setAlert('success', 'projectorSuccess');
                    return true;
                } else {
                    Alerts::setAlert('danger', "Error " . $p_sql->errorCode() . ": " . $p_sql->errorInfo()[2]);
                    return false;
                }
            } catch (Exception $e) {
                print $e->getMessage() . ": " . $e->getCode();
                return null;
            }
        } else {
            Alerts::setAlert('danger', 'verifyData');
            return null;
        }
    }

    public function update(PojoProjector $projector)
    {
        try {
            $sql = "UPDATE projetor SET modelo = :modelName, num_serie = :serialNumber WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":modelName", $projector->getModelName());
            $p_sql->bindValue(":serialNumber", $projector->getSerialNumber());
            $p_sql->bindValue(":id", $projector->getId());
            if ($p_sql->execute()) {
                Alerts::setAlert('success', 'projectorUpdated');
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

    public function pojoProjector($row) {
        $pojoProjector = new PojoProjector();
        $pojoProjector->setId($row['id']);
        $pojoProjector->setModelName(trim($row['modelo']));
        $pojoProjector->setSerialNumber(trim($row['num_serie']));
        return $pojoProjector;
    }
}