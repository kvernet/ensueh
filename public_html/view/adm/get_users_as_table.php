<?php

use app\core\entity\WhoAmI;
use app\core\model\UserModel;

function getUsersAsTable(WhoAmI $whoAmI): void {
    $data = array();

    $users = (new UserModel)->searchUsersByUserNameLike($whoAmI);

    foreach($users as $user) {
        array_push(
            $data,
            [
                "user_name" => $user->getUserName(),
                "first_name" => $user->getFirstName(),
                "last_name" => $user->getLastName(),
                "gender" => $user->getGender()->toText(),
                "email" => $user->getEmail(),
                "phone" => $user->getPhone(),
                "department" => $user->getDepartment()->toText(),
                "whoami" => $user->getWhoAmI()->toText(),
                "section" => $user->getSection()->toText(),
                "grade" => $user->getGrade()->toText(),
                "status" => $user->getStatus()->toText(),
                "id" => $user->getId()
            ]
        );
    }

    header('Content-Type: application/json');
    echo (json_encode(["data" => $data]));
}

if($_POST) {

    $whoami_id = $_POST['whoami_id'];

    getUsersAsTable(WhoAmI::get($whoami_id));
}