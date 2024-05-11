<?php

session_start();

use app\core\controller\AdmController;
use app\core\entity\Status;
use app\core\model\AdmModel;

$admController = new AdmController;

if($_POST) {
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    $admModel = new AdmModel;

    $adm = $admModel->getAdm($user_name, $pwd);

    if(!$adm->isNull()) {
        $status = $adm->getStatus();
        // check if ADM is active
        if($status == Status::ACTIVE || $status == Status::OFFLINE) {
            // save session and cookie
            $_SESSION["adm_user_name"] = $user_name;
            setcookie("adm_user_name", $user_name, time() + 86400 * 1);  // one full day
            $uid = uniqid();
            setcookie("adm_uniqid", $uid, time() + 86400 * 1);  // one full day
            // update database
            $admModel->updateUniqId($user_name, $uid);
            $admModel->updateStatus($user_name, Status::ONLINE);
            $admModel->updateLastActivity($user_name);
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
            "msg" => ADM_NOT_EXISTS_MSG . '<br><a href="'. APP_DOMAIN .'adm">Retour</a>'
        ]
        );
    }
}
else {
    $admController->info();
}