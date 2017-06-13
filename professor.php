<?php
/*
 * Defines where you are. Do not change this unless you know what you're doing.
 */
define('THIS_SCRIPT', 'professor');
/*
 * Required files
 */
require_once('global.php');
require_once('classes/templates/FormsTemplates.php');
require_once('classes/connector/PojoProfessor.php');
require_once('classes/connector/DaoProfessor.php');
/*
 * Main Script
 */
if (isset($_REQUEST['do'])) {
    if ($_REQUEST['do'] == 'delete') {
        if (!headers_sent()) {
            header("Location: viewEntries.php?do=professors");
            die();
        }
    }
    if ($_REQUEST['do'] == 'new') {
        if (isset($_POST['name']) && isset($_POST['cpf'])) {
            $professor = new PojoProfessor();
            $professor->setName($_POST['name']);
            $professor->setCpf($_POST['cpf']);
            $daoProfessor = DaoProfessor::getInstance();
            $daoProfessor->insert($professor);
        }
    }
    if ($_REQUEST['do'] == 'edit') {
        if (isset($_POST['name']) && isset($_POST['cpf']) && isset($_POST['id'])) {
            $professor = new PojoProfessor();
            $professor->setName($_POST['name']);
            $professor->setCpf($_POST['cpf']);
            $professor->setId($_POST['id']);
            $daoProfessor = DaoProfessor::getInstance();
            $daoProfessor->update($professor);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?=
    GeneralTemplates::render("meta");
    GeneralTemplates::render("pagetitle");
    GeneralTemplates::render("headinclude");
    ?>
<body>
<!-- Page container -->
<div class="page-container">
    <?= GeneralTemplates::render("sidebar"); ?>
    <!-- Main container -->
    <div class="main-container">
        <?= GeneralTemplates::render("header") ?>
        <!-- Main content -->
        <div class="main-content">
            <h1 class="page-title"><?= PageInfo::getPageTitle() ?></h1>
            <?=
            GeneralTemplates::render("breadcrumb");
            FormsTemplates::render("professorForm");
            GeneralTemplates::render("footer")
            ?>
        </div>
        <!-- /main content -->
    </div>
    <!-- /main container -->
</div>
<!-- /page container -->
<?=
LibrariesTemplates::render("jquery");
LibrariesTemplates::render("bootstrap");
LibrariesTemplates::render("metismenu");
LibrariesTemplates::render("blockui");
LibrariesTemplates::render("jasny");
LibrariesTemplates::render("js-functions");
?>
</body>
</html>
