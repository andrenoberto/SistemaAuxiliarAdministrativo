<!-- Main header -->
<div class="main-header row">
    <div class="col-sm-6 col-xs-7">
        <!-- User info -->
        <ul class="user-info pull-left">
            <li class="profile-info dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"
                                                 aria-expanded="false"> <?= UserSession::getUsername() ?> <span
                            class="caret"></span></a>
                <!-- User action menu -->
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="icon-cog"></i>Configurações</a></li>
                    <li><a href="logout.php"><i class="icon-logout"></i>Logout</a></li>
                </ul>
                <!-- /user action menu -->
            </li>
        </ul>
        <!-- /user info -->
    </div>
</div>
<!-- /main header -->
