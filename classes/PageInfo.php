<?php

class PageInfo
{
    public function __construct()
    {
    }

    public static function getPageHtmlTitle()
    {
        $title = UNIVERSITY . " | " . self::getPageTitle();
        return $title;
    }

    public static function getPageTitle()
    {
        switch (THIS_SCRIPT) {
            case 'book':
                $title = "Reservar Projetor";
                break;
            case 'index':
                $title = "Dashboard";
                break;
            case 'login':
                $title = "Login";
                break;
            case 'professor':
            case 'projector':
                if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'edit') {
                    $title = 'Editar Cadastro';
                } else {
                    $title = "Novo Cadastro";
                }
                break;
            case 'viewEntries':
                switch ($_REQUEST['do']) {
                    case 'professors':
                        $title = "Visualizar Registros de Professores";
                        break;
                    case 'projectors':
                        $title = "Visualizar Registros de Projetores";
                        break;
                    default:
                        $title = "Visualizar Registros";
                        break;
                }
                break;
            default:
                return SYSTEM_NAME;
        }
        return $title;
    }

    private static function getBreadcrumbUrl($location)
    {
        switch ($location) {
            case 'entries':
            case 'register':
            case 'projectors':
                return 'javascript:void(0)';
            case 'home':
                return 'index.php';
            case 'professorForm':
                return 'professor.php';
            case 'projectorForm':
                return 'projector.php';
            case 'viewProfessors':
                return 'viewEntries.php?do=professors';
            case 'viewProjectors':
                return 'viewEntries.php?do=projectors';
            default:
                return null;
        }
    }

    private static function getBreadcrumbPhrase($location)
    {
        switch ($location) {
            case 'bookProjector':
                return 'Reservar Projetor';
            case 'entries':
                return 'Registros';
            case 'home':
                return 'Home';
            case 'projectors':
            case 'projectorForm':
                return 'Projetores';
            case 'professorForm':
            case 'viewProfessors':
                return 'Professores';
            case 'register':
                return 'Cadastros';
            case 'viewProjectors':
                return 'Projetores';
            default:
                return null;
        }
    }

    private static function getBreadcrumbStyle($location)
    {
        $style = '<li><a href="' . self::getBreadcrumbUrl($location) . '">';
        if ($location == 'home') {
            $style .= '<i class="fa fa-home" ></i>';
        }
        $style .= ' ' . self::getBreadcrumbPhrase($location) . '</a ></li >' . "\n";
        return $style;
    }

    public static function getBreadcrumb()
    {
        $style = self::getBreadcrumbStyle('home');
        switch (THIS_SCRIPT) {
            case 'book':
                $style .= self::getBreadcrumbStyle('projectors');
                $style .= self::getBreadcrumbStyle('bookProjector');
                break;
            case 'index':
                return self::getBreadcrumbStyle('home');
            case 'professor':
                $style .= self::getBreadcrumbStyle('register');
                $style .= self::getBreadcrumbStyle('professorForm');
                break;
            case 'projector':
                $style .= self::getBreadcrumbStyle('register');
                $style .= self::getBreadcrumbStyle('projectorForm');
                break;
            case 'viewEntries':
                if (isset($_REQUEST['do'])) {
                    if ($_REQUEST['do'] == 'professors') {
                        $style .= self::getBreadcrumbStyle('entries');
                        $style .= self::getBreadcrumbStyle('viewProfessors');
                    } else if ($_REQUEST['do'] == 'projectors') {
                        $style .= self::getBreadcrumbStyle('entries');
                        $style .= self::getBreadcrumbStyle('viewProjectors');
                    }
                } else {
                    $style .= self::getBreadcrumbStyle('entries');
                }
                break;
            default:
                return null;
        }
        return $style;
    }
}