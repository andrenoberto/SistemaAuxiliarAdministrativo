<?php
/*
 * Defines where you are. Do not change this unless you know what you're doing.
 */
define('THIS_SCRIPT', 'book');
/*
 * Required files
 */
require_once('global.php');
require_once('classes/templates/FormsTemplates.php');
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
            FormsTemplates::render("bookProjectorForm");
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
