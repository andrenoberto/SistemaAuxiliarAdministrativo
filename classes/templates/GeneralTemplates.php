<?php
require_once('TemplatesPath.php');

class GeneralTemplates
{
    public function __construct()
    {
    }

    public static function render($templateName)
    {
        switch ($templateName) {
            case 'breadcrumb':
                $path = "general/breadcrumb.php";
                break;
            case 'footer':
                $path = "general/footer.php";
                break;
            case 'header':
                $path = "general/header.php";
                break;
            case 'headinclude':
                $path = "general/headinclude.php";
                break;
            case 'meta':
                $path = "general/meta.php";
                break;
            case 'loginForm':
                $path = "general/loginForm.php";
                break;
            case 'pagetitle':
                $path = "general/pagetitle.php";
                break;
            case 'sidebar':
                $path = "general/sidebar.php";
                break;
            case 'viewEntries':
                $path = "general/viewEntries.php";
                break;
            case 'welcome':
                $path = "general/welcome.php";
                break;
            default:
                return null;
        }

        TemplatesPath::includeTemplate($path);
    }
}