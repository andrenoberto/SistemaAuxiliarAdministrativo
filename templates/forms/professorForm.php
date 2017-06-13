<?php
$name = "";
$cpf = "";
$actionUrl = "professor.php?do=new";

if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'edit' && isset($_REQUEST['id'])) {
    $daoProfessor = new DaoProfessor();
    $professor = $daoProfessor->findById($_REQUEST['id']);
    $name = $professor->getName();
    $cpf = $professor->getCpf();
    $id = $professor->getId();
    $actionUrl = "professor.php?do=edit";
}
?>
<div class="row">
    <div class="col-lg-12">
        <?php if (Alerts::getAlertStatus('success')) : ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?= Alerts::getAlert('success') ?>
            </div>
        <?php endif ?>
        <?php if (Alerts::getAlertStatus('danger')) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?= Alerts::getAlert('danger') ?>
            </div>
        <?php endif ?>
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Formulário</h3>
                <ul class="panel-tool-options">
                    <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="<?= $actionUrl ?>">
                    <div class="form-group"><label class="col-sm-2 control-label">Informações Pessoais</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <?php if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'edit') : ?>
                                    <input type="text" id="id" name="id" value="<?= $_REQUEST['id'] ?>" hidden>
                                <?php endif ?>
                                <div class="col-md-8"><input type="text" class="form-control"
                                                             placeholder="Nome Completo" id="name" name="name"
                                                             value="<?= $name ?>"></div>
                                <div class="col-md-4"><input type="text" class="form-control" placeholder="CPF"
                                                             data-mask="999.999.999-99" id="cpf" name="cpf"
                                                             value="<?= $cpf ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-primary" type="submit">Salvar</button>
                            <button class="btn btn-black" onclick="window.history.back()" type="reset">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
