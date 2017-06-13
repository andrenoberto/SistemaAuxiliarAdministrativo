<?php
require_once('./classes/connector/DaoProjector.php');
require_once('./classes/connector/PojoBooking.php');
require_once('./classes/connector/DaoBooking.php');
require_once('./classes/connector/PojoBooking.php');

$daoProjector = DaoProjector::getInstance();
$projectorPDO = $daoProjector->listAll();

$modelName = "";
$serialNumber = "";
$actionUrl = "book.php?do=new";

if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'new') {
    $daoBooking = new DaoBooking();
    $pojoBooking = new PojoBooking();
    $pojoBooking->setProjectorId($_REQUEST['projector']);
    $pojoBooking->setDate($_REQUEST['date']);
    $pojoBooking->setRequestedBy($_REQUEST['requestedBy']);
    $pojoBooking->setStartsAt($_REQUEST['startsAt']);
    $pojoBooking->setEndsAt($_REQUEST['endsAt']);
    $pojoBooking->setDestinationRoom($_REQUEST['room']);
    $pojoBooking->setDestinationCourse($_REQUEST['course']);
    $pojoBooking->setBookedBy(UserSession::getUsername());
    $daoBooking->insert($pojoBooking);
} else if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'delete' && isset($_REQUEST['id'])) {
    $daoBooking = new DaoBooking();
    $daoBooking->delete($_REQUEST['id']);
}

/*if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'edit' && isset($_REQUEST['id'])) {
    $daoProjector = new DaoProjector();
    $projector = $daoProjector->findById($_REQUEST['id']);
    $modelName = $projector->getModelName();
    $serialNumber = $projector->getSerialNumber();
    $id = $projector->getId();
    $actionUrl = "projector.php?do=edit";
}*/
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
                <?php if (!isset($_REQUEST['do']) or (isset($_REQUEST['do']) && ($_REQUEST['do'] == 'new' or $_REQUEST['do'] == 'delete'))): ?>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="_date" class="col-sm-3 control-label">Data da Reserva</label>
                            <div class="col-sm-3">
                                <div id="date-popup" class="input-group date">
                                    <input id="_date" name="_date" type="text" data-format="D, dd MM yyyy"
                                           class="form-control"
                                           onchange="$('#results').hide(400); $('#no-results').hide(400)">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="_startsAt" class="col-sm-3 control-label">Horário de Entrega</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="_startsAt" name="_startsAt" type="text" maxlength="5" data-mask="99:99"
                                           class="form-control"
                                           onkeyup="$('#results').hide(400); $('#no-results').hide(400)">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="_endsAt" class="col-sm-3 control-label">Horário de Devolução</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="_endsAt" name="_endsAt" type="text" maxlength="5" data-mask="99:99"
                                           class="form-control"
                                           onkeyup="$('#results').hide(400); $('#no-results').hide(400)">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-primary" type="button" onclick="requestAvailableProjectors()">
                                    Verificar
                                    Disponibilidade
                                </button>
                                <button class="btn btn-black" type="button" onclick="$('form').get(0).reset()">Limpar
                                    Tudo
                                </button>
                            </div>
                        </div>
                        <!--Bookings-->
                        <div id="searching" class="hide-element">
                            <div class="line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="progress active">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped"
                                             role="progressbar"
                                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                             style="width: 100%;">
                                            <span class="sr-only">Buscando reservas...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="no-results" class="hide-element">
                            <div class="line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close">
                                            <span aria-hidden="true" onclick="dismissProjectorsAlert()">×</span>
                                        </button>
                                        Não há nenhum projetor disponível para a data e o horário solicitado.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif ?>
                <div id="results" <?= (isset($_REQUEST['do']) && $_REQUEST['do'] == 'edit' ? '' : 'class="hide-element"') ?>>
                    <form class="form-horizontal" method="post" action="<?= $actionUrl ?>">
                        <?php if (!isset($_REQUEST['do']) or (isset($_REQUEST['do']) && ($_REQUEST['do'] == 'new' or $_REQUEST['do'] == 'delete'))) : ?>
                            <div class="line-dashed"></div>
                        <?php endif ?>
                        <div class="form-group">
                            <label for="projector" class="col-sm-3 control-label">Projetor</label>
                            <div class="col-sm-3">
                                <select id="projector" name="projector" class="form-control"
                                        data-placeholder="Selecione um projetor">
                                    <option>Selecione um projetor</option>
                                    <?php foreach ($projectorPDO as $object): ?>
                                        <option id="opt_<?= $object['id'] ?>" value="<?= $object['id'] ?>"
                                                class="hide-element"><?= $object['modelo'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">Data da Reserva</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="date" name="date" type="text" class="form-control" readonly="readonly">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="startsAt" class="col-sm-3 control-label">Horário de Entrega</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="startsAt" name="startsAt" type="text" maxlength="5" data-mask="99:99"
                                           class="form-control" readonly="readonly">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="endsAt" class="col-sm-3 control-label">Horário de Devolução</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="endsAt" name="endsAt" type="text" maxlength="5" data-mask="99:99"
                                           class="form-control" readonly="readonly">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="requestedBy" class="col-sm-3 control-label">Solicitante</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="requestedBy" name="requestedBy" type="text" maxlength="80"
                                           class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="room" class="col-sm-3 control-label">Sala</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="room" name="room" type="text" maxlength="80" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="course" class="col-sm-3 control-label">Curso</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="course" name="course" type="text" maxlength="80" class="form-control">
                                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-primary" type="submit">Salvar</button>
                                <button class="btn btn-black" onclick="window.history.back()" type="reset">Cancelar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
