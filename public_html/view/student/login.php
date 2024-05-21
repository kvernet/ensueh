<?php

use app\core\controller\StudentController;
use app\core\entity\Message;
use app\core\entity\Status;
use app\core\entity\WhoAmI;
use app\core\model\UserModel;

$controller = new StudentController;

if($_POST) {
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    $userModel = new UserModel;

    $student = $userModel->get($user_name, $pwd, WhoAmI::STUDENT);

    if($student != null) {
        $status = $student->getStatus();
        // check if Student is active
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
                "msg" => Status::getCaseErrorMsg($status) . '<br><a href="'. APP_DOMAIN .'student">Retour</a>'
            ]
            );
        }
    }
    else {
        $controller->info([
            "msg" => Message::getMessage(Message::USER_NOT_EXISTS_MSG) . '<br><a href="'. APP_DOMAIN .'student">Retour</a>'
        ]
        );
    }
}
else {
    $controller->info();
}