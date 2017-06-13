<?php
require_once('SqlConnector.php');
require_once('Alerts.php');
require_once('Misc.php');
require_once('connector/PojoUser.php');
require_once('connector/DaoUser.php');

class UserSession
{
    public function __construct()
    {
    }

    public static function logIn($username)
    {
        $_SESSION["user_login"] = $username;
    }

    public static function logOut()
    {
        unset($_SESSION["user_login"]);
        session_destroy();
        if (headers_sent() === false) {
            header("Location: login.php");
            die();
        }
    }

    public static function userSession()
    {
        return $_SESSION["user_login"];
    }

    public static function userStatus()
    {
        return isset($_SESSION["user_login"]);
    }

    public static function verifyUser()
    {
        if (!self::userStatus()) {
            if (headers_sent() === false) {
                header("Location: login.php");
                die();
            }
        }
    }

    public static function getUsername() {
        $DaoUser = DaoUser::getInstance();
        $user = $DaoUser->findByUsername($_SESSION["user_login"]);
        return $user->getName();

    }

    public static function getUserFirstName() {
        $username = self::getUsername();
        $username = explode(' ', $username);
        return $username[0];
    }

    public static function loginProcess($username, $password)
    {
        $md5password = md5($password);
        $DaoUser = DaoUser::getInstance();
        $user = $DaoUser->authenticate($username, $md5password);
        if (!$user) {
            Alerts::setAlert('danger', 'wrongCredentials');
            return null;
        }
        return $user;
    }

    public static function loginAuth()
    {
        if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'login') {
            //Check data
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $user = UserSession::loginProcess($_POST['username'], $_POST['password']);
            }
            //Create session
            if (isset($user) && $user != null) {
                UserSession::logIn($_POST['username']);
                $headerAddress = 'Location: index.php';
                if (isset($_POST['sessionUrl'])) {
                    $headerAddress = 'Location: ' . base64_decode($_POST['sessionUrl']);
                }
            } else if (self::userStatus()) {
                $headerAddress = 'Location: index.php';
            } else if (isset($_POST['sessionUrl'])) {
                $headerAddress = 'Location: ' . base64_decode($_POST['sessionUrl']);
            }
        } else if (preg_match('/login.php/', Misc::getURI()) && self::userStatus()) {
            $headerAddress = 'Location: index.php';
        } else if (!preg_match('/login.php/', Misc::getURI()) && !self::userStatus()) {
            $headerAddress = 'Location: login.php?sessionUrl=' . base64_encode(Misc::getURI());
        }

        if (isset($headerAddress) && !headers_sent()) {
            if (headers_sent() === false) {
                header($headerAddress);
                die();
            }
        }
    }
}