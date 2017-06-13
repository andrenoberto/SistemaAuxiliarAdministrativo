<?php
require_once('TemplatesPath.php');

class FormsTemplates
{
    public function __construct()
    {
    }

    public static function render($templateName)
    {
        switch ($templateName) {
            case 'bookProjectorForm':
                $path = "forms/bookProjectorForm.php";
                break;
            case 'professorForm':
                $path = "forms/professorForm.php";
                break;
            case 'projectorForm':
                $path = "forms/projectorForm.php";
                break;
            case 'loginForm':
                $path = "forms/loginForm.php";
                break;
            default:
                return null;
        }

        TemplatesPath::includeTemplate($path);
    }
}