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

if($_POST) {
    $user = new User(
        $_POST["id"],
        $_POST["first_name"], $_POST["last_name"],
        Gender::get($_POST["gender"]),
        $_POST["email"], $_POST["phone"],
        Department::get($_POST["department"]),
        WhoAmI::get($_POST["whoami"]),
        Section::get($_POST["section"]),
        Grade::get($_POST["grade"]),
        "", "",
        new DateTime(date("")), "",
        Status::get($_POST["status"]),
        new DateTime(date(""))
    );

    $message = (new UserModel)->updateById($user);

    if($message == Message::SUCCESS_MSG) {
        redirectMe($_POST['return_page']);
    }else {
        redirectMe($_POST['return_page'] . '?msg_id=' . $message->value);
    }
}