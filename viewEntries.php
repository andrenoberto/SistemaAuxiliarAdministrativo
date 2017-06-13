<?php
/*
 * Defines where you are. Do not change this unless you know what you're doing.
 */
if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'bookings') {
    define('THIS_SCRIPT', 'bookings');
} else if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'dailyBookings') {
    define('THIS_SCRIPT', 'dailyBookings');
} else {
    define('THIS_SCRIPT', 'viewEntries');
}
/*
 * Required files
 */
require_once('global.php');
/*
 * Redirects to dashboard if user has accessed the wrong page.
 */
if (!isset($_REQUEST['do']) &&
    ($_REQUEST['do'] != 'professors' ||
        $_REQUEST['do'] != 'viewStudents' ||
        $_REQUEST['do'] != 'viewCourses')
) {
    if (!headers_sent()) {
        header("Location: index.php");
        die();
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
            GeneralTemplates::render('breadcrumb');
            GeneralTemplates::render('viewEntries');
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
LibrariesTemplates::render("datatables");
?>
<script>
    $(document).on("click", ".open-deleteDialog", function () {
        var professorEntryId = $(this).data('id');
        $("a#professorEntryId").attr("href", "professor.php?do=delete&id=" + professorEntryId);

        var projectorEntryId = $(this).data('id');
        $("a#projectorEntryId").attr("href", "projector.php?do=delete&id=" + projectorEntryId);

        var bookingEntryId = $(this).data('id');
        $("a#bookingEntryId").attr("href", "book.php?do=delete&id=" + projectorEntryId);
    });
</script>
</body>
</html>
