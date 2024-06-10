<?php

use app\core\entity\Department;
use app\core\entity\Gender;
use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;
use app\core\entity\Status;
use app\core\entity\User;
use app\core\entity\WhoAmI;
use app\core\model\UserModel;

$result = [
    "page" => "info",
    "msg_id" => Message::ACCESS_DENIED_MSG->value,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "msg_id_success" => Message::SUCCESS_MSG->value
];

if($_POST) {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $department = $_POST["department"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $whoami = $_POST["whoami"];
    $section = $_POST["section"];
    $grade = $_POST["grade"];
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    $userModel = new UserModel;

    $user = new User(
        0, $first_name, $last_name,
        Gender::get($gender), $email,
        $phone, Department::get($department),
        WhoAmI::get($whoami), Section::get($section),
        Grade::get($grade), $user_name, $pwd,
        new DateTime(), null, Status::REQUESTED,
        new DateTime()
    );

    $message = (new UserModel)->add($user);

    $result['msg_id'] = $message->value;
    $result['msg'] = Message::getMessage($message);

    if($message == Message::SUCCESS_MSG) {
        $result['page'] = "welcome_signup";
    }
}

echo json_encode($result);