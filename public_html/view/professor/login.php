<?php

use app\core\controller\ProfessorController;
use app\core\entity\Message;
use app\core\entity\Status;
use app\core\entity\WhoAmI;
use app\core\model\UserModel;

$controller = new ProfessorController;

if($_POST) {
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    $userModel = new UserModel;

    $professor = $userModel->get($user_name, $pwd, WhoAmI::PROFESSOR);

    if($professor != null) {
        $status = $professor->getStatus();
        // check if Professor is active
        if($status == Status::VALIDATED || $status == Status::INACTIVE || $status == Status::DISCONNECTED) {
            // save session and cookie
            $_SESSION["user_name"] = $user_name;
            setcookie("user_name", $user_name, time() + 86400 * 1);  // one full day
            $uid = uniqid();
            setcookie("uniqid", $uid, time() + 86400 * 1);  // one full day
            // update database
            $userModel->updateUniqId($user_name, $uid);
            $userModel->updateStatusByUserName($user_name, Status::CONNECTED);
            $userModel->updateLastActivity($user_name);
            redirectMe("courses");
        }
        else {
            $controller->info([
                "msg" => Status::getCaseErrorMsg($status) . '<br><a href="'. APP_DOMAIN .'professor">Retour</a>'
            ]
            );
        }
    }
    else {
        $controller->info([
            "msg" => Message::getMessage(Message::USER_NOT_EXISTS_MSG) . '<br><a href="'. APP_DOMAIN .'professor">Retour</a>'
        ]
        );
    }
}
else {
    $controller->info();
}