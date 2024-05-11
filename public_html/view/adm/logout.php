<?php

use app\core\controller\AdmController;
use app\core\entity\Status;
use app\core\model\AdmModel;

session_start();
$user_name = $_SESSION["adm_user_name"];

$status = AdmController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    // update the database
    $admModel = new AdmModel;
    $admModel->updateStatus($user_name, Status::DISCONNECTED);

    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();

    redirectMe("index");
}