<?php

use app\core\controller\AdmController;
use app\core\entity\Status;
use app\core\model\UserModel;

$status = AdmController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    // update the database
    $user_name = AdmController::getUserName();
    (new UserModel)->updateStatusByUserName($user_name, Status::DISCONNECTED);

    // delete sessions
    deleteSessions();

    // delete cookies
    deleteCookies();

    redirectMe("..");
}