<?php
if (THIS_SCRIPT == 'includes') {
    require_once('./config.php');
} else {
    require_once('./includes/config.php');
}
/*
 * Global Variables
 */
//Your university name
define('UNIVERSITY', 'UNIRB');
//System's name
define('SYSTEM_NAME', 'Sistema Auxiliar Administrativo');
//Path or URL to your logo image. Please insert a transparent background image.
define('LOGO_URL', 'images/logo.png');
/*
 * Main script
 */
if (THIS_SCRIPT) {
    require_once('classes/Misc.php');
    require_once('classes/UserSession.php');
    /*
     * Templates
     */
    require_once('classes/templates/GeneralTemplates.php');
    require_once('classes/templates/LibrariesTemplates.php');
    /*
     * Auth proccess
     */
    //Initialize a new session so unauthorized people can't access the system.
    if (!isset ($_SESSION) && !headers_sent()) {
        session_start();
        define('SESSIONS', TRUE);
    }
    UserSession::loginAuth();
}