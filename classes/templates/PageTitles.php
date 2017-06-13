<?php

class PageTitles
{
    public function __construct()
    {
    }

    public static function getPageTitle()
    {
        $title = 'UNIVERSITY' . " | ";

        switch (THIS_SCRIPT) {
            case 'index':
                $title .= "Dashboard";
                break;
            case 'login':
                $title .= "Login";
                break;
            case 'professor':
                $title .= "Professor";
                break;
            default:
                return null;
        }
        return $title;
    }
}