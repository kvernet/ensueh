<?php

use app\core\entity\WhoAmI;
use app\core\model\UserModel;

function getUsersAsTable(WhoAmI $whoAmI, int $page, int $size): void {
    $userModel = new UserModel;
    
    $data = array();

    // Retrieve pagination parameters
    $offset = ($page - 1) * $size;

    //TODO Get total row count
    $total = $userModel->getUsersCount($whoAmI);

    $users = $userModel->getPaginatedData($whoAmI, $offset, $size);

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

    $response = [
        "last_page" => ceil($total / $size),
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo (json_encode($response));
}

if($_POST) {
    $whoami_id = $_POST['whoami_id'];
    // Retrieve pagination parameters
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $size = isset($_POST['size']) ? intval($_POST['size']) : 10;

    getUsersAsTable(WhoAmI::get($whoami_id), $page, $size);
}