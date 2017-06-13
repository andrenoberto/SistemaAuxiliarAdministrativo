<?php
require_once('classes/connector/DaoProfessor.php');
require_once('classes/connector/DaoProjector.php');
require_once('classes/connector/DaoBooking.php');
/*
 * Main script
 */
$PDO = array();
switch ($_REQUEST['do']) {
    case 'professors':
        $daoProfessor = new DaoProfessor();
        $PDO = $daoProfessor->listAll();
        break;
    case 'projectors':
        $daoProjector = new DaoProjector();
        $PDO = $daoProjector->listAll();
        break;
    case 'bookings':
    case 'dailyBookings':
        $dailyBookings = (THIS_SCRIPT == 'dailyBookings') ? true : false;
        $daoBooking = new DaoBooking();
        $PDO = $daoBooking->listAll();
        break;
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Registros</h3>
                <ul class="panel-tool-options">
                    <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-entries">
                        <thead>
                        <tr>
                            <?php switch ($_REQUEST['do']) : ?><?php case 'professors': ?>
                                <th>Nome Completo</th>
                                <th>CPF</th>
                                <?php break; ?>
                            <?php case 'projectors': ?>
                                <th>Modelo</th>
                                <th>Número de Série</th>
                                <?php break; ?>
                            <?php case 'bookings': ?>
                            <?php case 'dailyBookings': ?>
                                <th>Horário de Entrega</th>
                                <th>Horário de Devolução</th>
                                <th>Projetor</th>
                                <th>Sala</th>
                                <th>Curso</th>
                                <th>Data da Solicitação</th>
                                <?php break; ?>
                            <?php endswitch ?>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php switch ($_REQUEST['do']) : ?><?php case 'professors': ?>
                            <?php foreach ($PDO as $object) : ?>
                                <?php $o = $daoProfessor->pojoProfessor($object) ?>
                                <tr>
                                    <td><?= $o->getName() ?></td>
                                    <td><?= $o->getCpf() ?></td>
                                    <td align="center">
                                        <a href="professor.php?do=edit&id=<?= $o->getId() ?>">
                                            <button type="button" class="btn btn-info"><i class="fa fa-paste"></i>&nbsp;
                                                Editar
                                            </button>
                                        </a>
                                        <button type="button" class="open-deleteDialog btn btn-red" data-toggle="modal"
                                                data-target="#deleteDialog" data-id="<?= $o->getId() ?>"><i
                                                    class="fa fa-close"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php case 'projectors': ?>
                            <?php foreach ($PDO as $object) : ?>
                                <?php $o = $daoProjector->pojoProjector($object) ?>
                                <tr>
                                    <td><?= $o->getModelName() ?></td>
                                    <td><?= $o->getSerialNumber() ?></td>
                                    <td align="center">
                                        <a href="projector.php?do=edit&id=<?= $o->getId() ?>">
                                            <button type="button" class="btn btn-info"><i class="fa fa-paste"></i>&nbsp;
                                                Editar
                                            </button>
                                        </a>
                                        <button type="button" class="open-deleteDialog btn btn-red" data-toggle="modal"
                                                data-target="#deleteDialog" data-id="<?= $o->getId() ?>"><i
                                                    class="fa fa-close"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php case 'bookings': ?>
                        <?php case 'dailyBookings': ?>
                            <?php foreach ($PDO as $object) : ?>
                                <?php $o = $daoBooking->pojoBooking($object) ?>
                                <tr>
                                    <td><?= $o->getReadableStartsDate() ?></td>
                                    <td><?= $o->getReadableEndsDate() ?></td>
                                    <td><?= $o->getModelName() ?></td>
                                    <td><?= $o->getDestinationRoom() ?></td>
                                    <td><?= $o->getDestinationCourse() ?></td>
                                    <td><?= $o->getCreatedAt() ?></td>
                                    <td align="center">
                                        <a href="book.php?do=edit&id=<?= $o->getId() ?>">
                                            <button type="button" class="btn btn-info"><i class="fa fa-paste"></i>&nbsp;
                                                Editar
                                            </button>
                                        </a>
                                        <button type="button" class="open-deleteDialog btn btn-red" data-toggle="modal"
                                                data-target="#deleteDialog" data-id="<?= $o->getId() ?>"><i
                                                    class="fa fa-close"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endswitch ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <?php switch ($_REQUEST['do']) : ?><?php case 'professors': ?>
                                <th>Nome Completo</th>
                                <th>CPF</th>
                                <?php break; ?>
                            <?php case 'projectors': ?>
                                <th>Modelo</th>
                                <th>Número de Série</th>
                                <?php break; ?>
                            <?php case 'bookings': ?>
                            <?php case 'dailyBookings': ?>
                                <th>Horário de Entrega</th>
                                <th>Horário de Devolução</th>
                                <th>Projetor</th>
                                <th>Sala</th>
                                <th>Curso</th>
                                <th>Data da Solicitação</th>
                                <?php break; ?>
                            <?php endswitch ?>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Basic Modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteDialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Deletar Registro</h4>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir este registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <?php switch ($_REQUEST['do']) : ?><?php case 'professors': ?>
                <a name="professorEntryId" id="professorEntryId">
                    <?php break; ?>
                    <?php case 'projectors': ?>
                    <a name="projectorEntryId" id="projectorEntryId">
                        <?php break; ?>
                        <?php case 'bookings': ?>
                        <?php case 'dailyBookings': ?>
                        <a name="bookingEntryId" id="bookingEntryId">
                            <?php break; ?>
                        <?php endswitch ?>
                        <button type="button" class="btn btn-danger">Excluir</button>
                    </a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End Basic Modal-->

