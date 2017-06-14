<?php

class Alerts
{

    public function __construct($alertType)
    {
    }

    public static function getAlertStatus($alertFlagName)
    {
        return isset($_SESSION[$alertFlagName]);
    }

    public static function getAlert($alertFlagName)
    {
        $alert = $_SESSION[$alertFlagName];
        unset($_SESSION[$alertFlagName]);
        return $alert;
    }

    /**
     * Set a default message for a specific alert flag which you can get later on.
     *
     * @param string $alertName Name of the message you want to set into session.
     *
     * @return null|string Returns either a null value or a string if a value has been successfully set to a session.
     */
    public static function setAlert($alertFlagName, $alertName)
    {
        switch ($alertName) {
            case 'bookingEntryDeleted':
                $message = "Reserva deletada com sucesso.";
                break;
            case 'bookingSuccess':
                $message = "Projetor reservado com sucesso.";
                break;
            case 'projectorAlreadyBooked':
                $message = "Este projetor já foi reservado. Por favor, verifique a disponibilidade novamente.";
                break;
            case 'professorAlreadyInDatabase':
                $message = "Erro.\nEste professor(a) já encontra-se cadastrado no banco de dados!";
                break;
            case 'professorSuccess':
            case 'projectorSuccess':
                $message = "Registro gravado com sucesso.";
                break;
            case 'bookingUpdated':
            case 'professorUpdated':
            case 'projectorUpdated':
                $message = "Registro atualizado com sucesso.";
                break;
            case 'verifyData':
                $message = "Erro.\nPor favor verifique os dados inseridos e tente novamente!";
                break;
            case 'wrongCredentials':
                $message = "Usuário e/ou senha inválidos.";
                break;
            default:
                $message = $alertName;
                break;
        }
        $_SESSION[$alertFlagName] = $message;
        return;
    }
}