<?php
require_once('TemplatesPath.php');

class LibrariesTemplates
{
    public function __construct()
    {
    }

    public static function render($templateName)
    {
        switch ($templateName) {
            case 'blockui':
                $path = "libraries/blockui-master.php";
                break;
            case 'bootstrap':
                $path = "libraries/bootstrap.php";
                break;
            case 'datatables':
                $path = "libraries/datatables.php";
                break;
            case 'jasny':
                $path = "libraries/jasny.php";
                break;
            case 'jquery':
                $path = "libraries/jquery.php";
                break;
            case 'js-functions':
                $path = "libraries/js-functions.php";
                break;
            case 'metismenu':
                $path = "libraries/metismenu.php";
                break;
            default:
                return null;
        }

        TemplatesPath::includeTemplate($path);
    }
}