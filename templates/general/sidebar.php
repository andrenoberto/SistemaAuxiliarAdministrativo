<?php
require_once('classes/Sidebar.php');

$active['activities'] = '';
$active['courses'] = '';
$active['professors'] = '';
$active['projectors'] = '';
$active['students'] = '';
$active['bookings'] = '';
if (isset($_REQUEST['do'])) {
    switch ($_REQUEST['do']) {
        case 'activities':
            $active['activities'] = 'active';
            break;
        case 'bookings':
            $active['bookings'] = 'active';
        case 'courses':
            $active['courses'] = 'active';
            break;
        case 'professors':
            $active['professors'] = 'active';
            break;
        case 'projectors':
            $active['projectors'] = 'active';
            break;
        case 'students':
            $active['students'] = 'active';
            break;
    }
}
?>
<!-- Page Sidebar -->
<div class="page-sidebar">

    <!-- Site header  -->
    <header class="site-header">
        <div class="site-logo"><a href="index.php"><img src="<?= LOGO_URL ?>" alt="<?= UNIVERSITY ?>"
                                                         title="<?= UNIVERSITY ?>"></a></div>
        <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a>
        </div>
        <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse"
                                                       class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a>
        </div>
    </header>
    <!-- /site header -->

    <!-- Main navigation -->
    <ul id="side-nav" class="main-menu navbar-collapse collapse">
        <li class="has-sub <?= Sidebar::getLiActiveClass('dashboard') ?>"><a href="index.php"><i class="icon-gauge"></i><span
                        class="title">Dashboard</span></a>
            <ul class="nav <?= Sidebar::getNavClass('dashboard') ?>">
                <li <?= Sidebar::getActiveClassAttribute('index') ?>><a href="index.php"><span class="title">Home</span></a>
                </li>
            </ul>
        </li>
        <li class="has-sub <?= Sidebar::getLiActiveClass('entries') ?>"><a href="#"><i class="icon-doc-text"></i><span
                        class="title">Cadastros</span></a>
            <ul class="nav <?= Sidebar::getNavClass('entries') ?>">
                <li <?= Sidebar::getActiveClassAttribute('professor') ?>><a href="professor.php"><span class="title">Professores</span></a>
                </li>
                <li <?= Sidebar::getActiveClassAttribute('projector') ?>><a href="projector.php"><span class="title">Projetores</span></a>
                </li>
            </ul>
        </li>
        <li class="has-sub <?= Sidebar::getLiActiveClass('projectorBookings') ?>"><a href="index.php"><i class="icon-lamp"></i><span
                        class="title">Projetores</span></a>
            <ul class="nav <?= Sidebar::getNavClass('projectorBookings') ?>">
                <li <?= Sidebar::getActiveClassAttribute('book') ?>><a href="book.php"><span class="title">Reservar Projetor</span></a>
                </li>
                <li <?= Sidebar::getActiveClassAttribute('bookings') ?>><a href="viewEntries.php?do=bookings"><span class="title">Visualizar Reservas</span></a>
                </li>
            </ul>
        </li>
        <li class="has-sub <?= Sidebar::getLiActiveClass('viewEntries') ?>"><a href="#"><i class="icon-window"></i><span
                        class="title">Registros</span></a>
            <ul class="nav <?= Sidebar::getNavClass('viewEntries') ?>">
                <li <?= Sidebar::getActiveClassAttribute($active['professors']) ?>><a href="viewEntries.php?do=professors"><span
                                class="title">Professores</span></a></li>
                <li <?= Sidebar::getActiveClassAttribute($active['projectors']) ?>><a href="viewEntries.php?do=projectors"><span
                                class="title">Projetores</span></a></li>
            </ul>
        </li>
    </ul>
    <!-- /main navigation -->
</div>
<!-- /page sidebar -->