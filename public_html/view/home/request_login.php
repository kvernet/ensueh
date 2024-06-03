<?php

use app\core\controller\UserController;
use app\core\entity\Message;
use app\core\entity\Status;
use app\core\model\UserModel;

$result = [
    "page" => "info",
    "msg_id" => Message::ACCESS_DENIED_MSG->value,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "msg_id_success" => Message::SUCCESS_MSG->value
];

if($_POST) {
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    $userModel = new UserModel;

    $user = $userModel->get($user_name, $pwd);

    if($user != null) {
        $status = UserController::getStatus();
        // check if ADM is active
        if($status == Status::REQUESTED || $status == Status::SUSPENDED) {
            $result['msg'] = Status::getCaseErrorMsg($status);
        }
        else {
            // save session and cookie
            $_SESSION["user_name"] = $user_name;
            setcookie("user_name", $user_name, time() + 86400 * COOKIE_DURATION, "/");
            $uid = uniqid();
            setcookie("uniqid", $uid, time() + 86400 * COOKIE_DURATION, "/");

            // update database
            $userModel->updateUniqId($user_name, $uid);
            $userModel->updateStatusByUserName($user_name, Status::CONNECTED);
            $userModel->updateLastActivity($user_name);

            $home = $user->getWhoAmI()->getHome();
            
            $result['page'] = APP_DOMAIN . $home;
            $result['msg_id'] = Message::SUCCESS_MSG->value;
            $result['msg'] = Message::getMessage(Message::SUCCESS_MSG);
        }
    }
    else {
        $result['msg'] = Message::getMessage(Message::USER_NOT_EXISTS_MSG);
    }
}

echo json_encode($result);