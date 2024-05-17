<?php

use app\core\entity\Status;
use app\core\model\UserModel;

if($_GET) {
    $id = $_GET['id'];
    $method = $_GET['method'];

    (new UserModel)->updateStatusById($id, Status::SUSPENDED);

    redirectMe($method);
}