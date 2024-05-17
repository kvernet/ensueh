<?php

use app\core\controller\AdmController;
use app\core\entity\Message;
use app\core\entity\Status;
use app\core\model\UserModel;

$admController = new AdmController;

if($_POST) {
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    $userModel = new UserModel;

    $adm = $userModel->get($user_name, $pwd);

    if($adm != null) {
        $status = $adm->getStatus();
        // check if ADM is active
        if($status == Status::VALIDATED || $status == Status::INACTIVE || $status == Status::DISCONNECTED) {
            // save session and cookie
            $_SESSION["adm_user_name"] = $user_name;
            setcookie("adm_user_name", $user_name, time() + 86400 * 1);  // one full day
            $uid = uniqid();
            setcookie("adm_uniqid", $uid, time() + 86400 * 1);  // one full day
            // update database
            $userModel->updateUniqId($user_name, $uid);
            $userModel->updateStatusByUserName($user_name, Status::CONNECTED);
            $userModel->updateLastActivity($user_name);
            redirectMe("home");
        }
        else {
            $admController->info([
                "msg" => Status::getCaseErrorMsg($status) . '<br><a href="'. APP_DOMAIN .'adm">Retour</a>'
            ]
            );
        }
    }
    else {
        $admController->info([
            "msg" => Message::getMessage(Message::ADM_NOT_EXISTS_MSG) . '<br><a href="'. APP_DOMAIN .'adm">Retour</a>'
        ]
        );
    }
}
else {
    $admController->info();
}