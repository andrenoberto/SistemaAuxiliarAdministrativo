<?php
/*
 * Defines where you are. Do not change this unless you know what you're doing.
 */
define('THIS_SCRIPT', 'includes');
header('Content-type:application/json;charset=utf-8');
/*
 * Required files
 */
require_once('../global.php');
require_once('../classes/connector/DaoBooking.php');
require_once('../classes/connector/DaoProjector.php');
/*
 * Main Script
 */
if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'request') {
    $date = $_REQUEST['date'];
    $startsAt = $_REQUEST['startsAt'];
    $endsAt = $_REQUEST['endsAt'];

    $dateArray = explode('/', $date);
    $startsAt = "{$dateArray[2]}-{$dateArray[1]}-{$dateArray[0]} {$startsAt}:00.000";
    $endsAt = "{$dateArray[2]}-{$dateArray[1]}-{$dateArray[0]} {$endsAt}:00.000";

    $daoBooking = new DaoBooking();
    $daoProjector = new DaoProjector();
    $bookingPDO = $daoBooking->findNotAvailableProjectors($startsAt, $endsAt);
    $projectorPDO = $daoProjector->listAll();
    $notAvailableProjectors = count($bookingPDO);
    $totalAvailableProjectors = count($projectorPDO);

    //Gets the ids of projectors that are already in use
    $notAvailableIds = '';
    $comma = '';
    foreach ($bookingPDO as $booking) {
        $notAvailableIds .= $comma;
        $notAvailableIds .= $booking['projetor_id'];
        $comma = ', ';
    }
    //Number of available projector to be booked
    $availableToBook = $totalAvailableProjectors - $notAvailableProjectors;
    //We should now look for all projectors that are in use
    $results = $daoProjector->listAll($notAvailableIds);

    $data = [
        'total' => $availableToBook,
        'notAvailable' => $notAvailableIds,
        'results' => $results
    ];
    //Returning a json result
    echo json_encode($data);
}