<?php


class Sidebar
{
    public function __construct()
    {
    }

    public static function getActiveClassName($location)
    {
        $activeClass = "active";
        if ($location == THIS_SCRIPT) {
            return $activeClass;
        }
        return "";
    }

    public static function getActiveClassAttribute($location)
    {
        $activeClass = "active";
        if ($location == THIS_SCRIPT || $location == "active") {
            return "class=\"" . $activeClass . "\"";
        }
        return "";
    }

    public static function getLiActiveClass($navSection)
    {
        $class = '';
        switch ($navSection) {
            case 'dashboard':
                if (THIS_SCRIPT == 'index') {
                    $class = 'active';
                }
                break;
            case 'entries':
                if (THIS_SCRIPT == 'professor' || THIS_SCRIPT == 'projector') {
                    $class = 'active';
                }
                break;
            case 'projector':
                if (THIS_SCRIPT == 'projector') {
                    $class = 'active';
                }
                break;
            case 'projectorBookings':
                if (THIS_SCRIPT == 'book') {
                    $class = 'active';
                } else if (THIS_SCRIPT == 'bookings') {
                    $class = 'active';
                }
                break;
            case 'viewEntries':
                if (THIS_SCRIPT == 'viewEntries') {
                    if (isset($_REQUEST['do'])) {
                        if ($_REQUEST['do'] != 'professors' ||
                            $_REQUEST['do'] != 'students' ||
                            $_REQUEST['do'] != 'activities' ||
                            $_REQUEST['do'] != 'courses'
                        ) {
                            $class = 'active';
                        }
                    }
                }
                break;
        }

        return $class;
    }

    public static function getNavClass($navSection)
    {
        $class = '';
        switch ($navSection) {
            case 'dashboard':
                if (THIS_SCRIPT != 'index') {
                    $class = 'collapse';
                }
                break;
            case 'entries':
                if (THIS_SCRIPT != 'professor' || THIS_SCRIPT != 'projector') {
                    $class = 'collapse';
                }
                break;
            case 'projector':
                if (THIS_SCRIPT != 'projector') {
                    $class = 'collapse';
                }
                break;
            case 'projectorBookings':
                if (THIS_SCRIPT != 'book' ||
                    THIS_SCRIPT != 'bookings') {
                    $class = 'collapse';
                }
                break;
            case 'viewEntries':
                if (isset($_REQUEST['do'])) {
                    if ($_REQUEST['do'] != 'professors' ||
                        $_REQUEST['do'] != 'students' ||
                        $_REQUEST['do'] != 'activities' ||
                        $_REQUEST['do'] != 'courses'
                    ) {
                        $class = 'collapse';
                    }
                } else {
                    $class = 'collapse';
                }
                break;
            default:
                $class = 'collapse';
        }

        return $class;
    }
}