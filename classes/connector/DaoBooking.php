<?php
require_once('Connection.php');
require_once('PojoBooking.php');

class DaoBooking
{
    public static $instance;

    public function __construct()
    {
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM reservas_projetor WHERE id = :id";
            $p_sql = Connection::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);

            if ($p_sql->execute()) {
                Alerts::setAlert('success', 'bookingEntryDeleted');
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

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DaoBooking();
        }

        return self::$instance;
    }

    public function listAll($dailyBookings = false)
    {
        try {
            $sql = "SELECT reservas_projetor.id AS id, hora_inicial, hora_final, sala, curso, modelo, data_registro FROM reservas_projetor INNER JOIN projetor ON reservas_projetor.projetor_id = projetor.id";
            if ($dailyBookings) {
                $sql .= " WHERE data_reserva = CONVERT(DATE, CURRENT_TIMESTAMP)";
            }
            $sql .= " ORDER BY hora_inicial ASC";
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

    public function findNotAvailableProjectors($startsAt, $endsAt)
    {
        try {
            $sql = "SELECT * FROM reservas_projetor WHERE ((hora_inicial BETWEEN '{$startsAt}' AND '{$endsAt}') or (hora_final BETWEEN '{$startsAt}' AND '{$endsAt}')) or (('{$startsAt}' BETWEEN hora_inicial AND hora_final) or ('{$endsAt}' BETWEEN hora_inicial AND hora_final))";
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

    public function insert(PojoBooking $pojoBooking)
    {
        $sql = "INSERT INTO reservas_projetor (projetor_id, data_reserva, hora_inicial, hora_final, responsavel_reserva, solicitacao_reserva, sala, curso, data_registro) 
                VALUES (:projectorId, :bookingDate, :startsAt, :endsAt, :bookedBy, :requestedBy, :room, :course, CURRENT_TIMESTAMP)";

        $conn = Connection::getInstance();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $p_sql = $conn->prepare($sql);

        $waiting = true; // Since this is a transaction we need to call it again in case there's another transaction being executed
        while ($waiting) {
            try {
                $conn->beginTransaction();
                $p_sql->bindValue(":projectorId", $pojoBooking->getProjectorId());
                $p_sql->bindValue(":bookingDate", $pojoBooking->getSqlDate());
                $p_sql->bindValue(":startsAt", $pojoBooking->getSqlStartDate());
                $p_sql->bindValue(":endsAt", $pojoBooking->getSqlEndDate());
                $p_sql->bindValue(":bookedBy", $pojoBooking->getBookedBy());
                $p_sql->bindValue(":requestedBy", $pojoBooking->getRequestedBy());
                $p_sql->bindValue(":room", $pojoBooking->getDestinationRoom());
                $p_sql->bindValue(":course", $pojoBooking->getDestinationCourse());
                if ($p_sql->execute()) {
                    Alerts::setAlert('success', 'bookingSuccess');
                } else {
                    Alerts::setAlert('danger', "Error " . $p_sql->errorCode() . ": " . $p_sql->errorInfo()[2]);
                }

                $conn->commit();
                $waiting = false;
            } catch (PDOException $e) {
                if (stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
                    // This should be specific to SQLite, sleep for 0.25 seconds
                    // and try again.  We do have to commit the open transaction first though
                    $conn->commit();
                    usleep(250000);
                } else {
                    $conn->rollBack();
                    Alerts::setAlert('danger', 'verifyData');
                    print $e->getMessage() . ": " . $e->getCode();
                    throw $e;
                }
            }
        }
    }

    public function pojoBooking($row)
    {
        $pojoBooking = new PojoBooking();
        if (array_key_exists('id', $row)) {
            $pojoBooking->setId($row['id']);
        }
        if (array_key_exists('responsavel_reserva', $row)) {
            $pojoBooking->setBookedBy($row['responsavel_reserva']);
        }
        if (array_key_exists('data_reserva', $row)) {
            $pojoBooking->setDate($row['data_reserva']);
        }
        if (array_key_exists('curso', $row)) {
            $pojoBooking->setDestinationCourse($row['curso']);
        }
        if (array_key_exists('sala', $row)) {
            $pojoBooking->setDestinationRoom($row['sala']);
        }
        if (array_key_exists('projetor_id', $row)) {
            $pojoBooking->setProjectorId($row['projetor_id']);
        }
        if (array_key_exists('hora_final', $row)) {
            $pojoBooking->setEndsAt($row['hora_final']);
        }
        if (array_key_exists('hora_inicial', $row)) {
            $pojoBooking->setStartsAt($row['hora_inicial']);
        }
        if (array_key_exists('solicitacao_reserva', $row)) {
            $pojoBooking->setRequestedBy($row['solicitacao_reserva']);
        }
        if (array_key_exists('modelo', $row)) {
            $pojoBooking->setModelName($row['modelo']);
        }
        if (array_key_exists('data_registro', $row)) {
            $pojoBooking->setCreatedAt($row['data_registro']);
        }

        return $pojoBooking;
    }
}