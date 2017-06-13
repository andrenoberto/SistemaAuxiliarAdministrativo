<?php
/*
 * Defines where you are. Don't mess up with this unless you know what you're doing.
 */
define('THIS_SCRIPT', 'login');
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
</head>
<body class="login-page">
<?=
FormsTemplates::render("loginForm");
LibrariesTemplates::render("jquery");
LibrariesTemplates::render("bootstrap");
?>
</body>
</html>