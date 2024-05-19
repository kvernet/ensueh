<?php

use app\core\controller\ProfessorController;
use app\core\entity\Status;
use app\core\model\UserModel;

$status = ProfessorController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    // update the database
    $user_name = ProfessorController::getUserName();
    (new UserModel)->updateStatusByUserName($user_name, Status::DISCONNECTED);

    // delete sessions
    deleteSessions();

    // delete cookies
    deleteCookies();

    redirectMe("index");
}