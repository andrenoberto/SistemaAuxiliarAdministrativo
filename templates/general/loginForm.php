<?php
require_once('/classes/Alerts.php');
?>
<div class="login-container">
    <div class="login-branding">
        <a href="index.html"><img src="<?= LOGO_URL ?>" alt="UNIRB" title="UNIRB"></a>
    </div>
    <div class="login-content">
        <h2><strong>Bem-vindo</strong>, por favor faça o login</h2>
        <?php if (Alerts::getAlertStatus('danger')) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?= Alerts::getAlert('danger') ?>
            </div>
        <?php endif ?>
        <form method="post" action="login.php?do=login">
            <div class="form-group">
                <input type="text" placeholder="Usuário" id="username" name="username" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Senha" id="password" name="password" class="form-control">
            </div>
            <?php if (isset($_GET['sessionUrl'])) : ?>
            <div class="form-group">
                <input type="text" value="<?= $_GET['sessionUrl'] ?>" id="sessionUrl" name="sessionUrl" hidden>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <div class="checkbox checkbox-replace">
                    <input type="checkbox" id="remember">
                    <label for="remeber">Lembrar</label>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block">Login</button>
            </div>
            <p class="text-center"><a href="forgot-password.html">Esqueceu sua senha?</a></p>
        </form>
    </div>
</div>
