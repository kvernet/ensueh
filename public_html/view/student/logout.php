<?php

use app\core\controller\StudentController;
use app\core\entity\Status;
use app\core\model\UserModel;

$status = StudentController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    // update the database
    $user_name = StudentController::getUserName();
    (new UserModel)->updateStatusByUserName($user_name, Status::DISCONNECTED);

    // delete sessions
    deleteSessions();

    // delete cookies
    deleteCookies();

    redirectMe("..");
}