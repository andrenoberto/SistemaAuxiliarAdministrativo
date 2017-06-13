<?php
/*
 * Defines where you are. Do not change this unless you know what you're doing.
 */
define('THIS_SCRIPT', 'projector');
/*
 * Required files
 */
require_once('global.php');
require_once('classes/templates/FormsTemplates.php');
require_once('classes/connector/PojoProjector.php');
require_once('classes/connector/DaoProjector.php');

/*
 * Main Script
 */
if (isset($_REQUEST['do'])) {
    if ($_REQUEST['do'] == 'delete') {
        if (!headers_sent()) {
            header("Location: viewEntries.php?do=projectors");
            die();
        }
    }
    if ($_REQUEST['do'] == 'new') {
        if (isset($_POST['modelName']) && isset($_POST['serialNumber'])) {
            $projector = new PojoProjector();
            $projector->setSerialNumber($_POST['serialNumber']);
            $projector->setModelName($_POST['modelName']);
            $daoProjector = DaoProjector::getInstance();
            $daoProjector->insert($projector);
        }
    }
    if ($_REQUEST['do'] == 'edit') {
        if (isset($_POST['modelName']) && isset($_POST['serialNumber']) && isset($_POST['id'])) {
            $projector = new PojoProjector();
            $projector->setModelName($_POST['modelName']);
            $projector->setSerialNumber($_POST['serialNumber']);
            $projector->setId($_POST['id']);
            $daoProjector = DaoProjector::getInstance();
            $daoProjector->update($projector);
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
            FormsTemplates::render("projectorForm");
            GeneralTemplates::render("footer");
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
