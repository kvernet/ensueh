<?php

use app\core\controller\SecretaryController;
use app\core\entity\Status;
use app\core\model\UserModel;

$status = SecretaryController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    // update the database
    $user_name = SecretaryController::getUserName();
    (new UserModel)->updateStatusByUserName($user_name, Status::DISCONNECTED);

    // delete sessions
    deleteSessions();

    // delete cookies
    deleteCookies();

    redirectMe("..");
}