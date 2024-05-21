<?php

use app\core\controller\StudentController;
use app\core\entity\Header;
use app\core\entity\Navbar;
use app\core\entity\Status;
use app\core\model\UserModel;

$user_name = StudentController::getUserName();

(new Header)->setTitle($params["title"] ?? APP_NAME)->show();

//TODO, read from database
$params["n_received_msg"] = 0;

$status = StudentController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    $navbar = new Navbar;
    $navbar->addLi("Cours", APP_DOMAIN . "student/courses", ['active'], ["aria-current" => "page"])
        ->addLi("Notes", APP_DOMAIN . "student/notes")
        ->addLiDropdown("Mes messages", [
            ["text" => "Envoyés", "href" => APP_DOMAIN . "student/msg_sent"],
            ["text" => "Reçus(" . $params["n_received_msg"] . ")", "href" => APP_DOMAIN . "student/msg_received"]
        ], -1)
        ->addLiDropdown("Mon compte", [
            ["text" => "Changer mot de passe", "href" => APP_DOMAIN . "student/cpwd"],
            ["text" => "Se déconnecter", "href" => APP_DOMAIN . "student/logout"]
        ], 0)
        ->addSearch(APP_DOMAIN . "student/search")
        ->show();
    // update last activity date
    (new UserModel)->updateLastActivity($user_name);
}
