<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico'/>
<!-- /site favicon -->

<!-- Entypo font stylesheet -->
<link href="css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="css/mouldifi-forms.css" rel="stylesheet">

<?php if (THIS_SCRIPT == 'viewEntries' || THIS_SCRIPT == 'bookings' || THIS_SCRIPT == 'dailyBookings') : ?>
    <link href="css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
<?php endif ?>
<?php if (THIS_SCRIPT == 'book') : ?>
    <link href="css/plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <link href="css/plugins/select2/select2.css" rel="stylesheet">
<?php endif ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="js/html5shiv.min.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
