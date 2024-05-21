<?php

use app\core\controller\ProfessorController;
use app\core\entity\Header;
use app\core\entity\Navbar;
use app\core\entity\Status;
use app\core\model\UserModel;

$user_name = ProfessorController::getUserName();

$header = new Header;
$header->setTitle($params["title"] ?? APP_NAME)->show();

//TODO, read from database
$params["n_received_msg"] = 0;

$status = ProfessorController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    $navbar = new Navbar;
    $navbar->addLi("Cours", APP_DOMAIN . "professor/courses", ['active'], ["aria-current" => "page"])
        ->addLi("Notes", APP_DOMAIN . "professor/notes")
        ->addLi("Mon calendrier", APP_DOMAIN . "professor/calendar")
        ->addLi("Mes projets", APP_DOMAIN . "professor/projets")
        ->addLiDropdown("Mes messages", [
            ["text" => "Envoyés", "href" => APP_DOMAIN . "professor/msg_sent"],
            ["text" => "Reçus(" . $params["n_received_msg"] . ")", "href" => APP_DOMAIN . "professor/msg_received"]
        ], -1)
        ->addLiDropdown("Mon compte", [
            ["text" => "Changer mot de passe", "href" => APP_DOMAIN . "professor/cpwd"],
            ["text" => "Se déconnecter", "href" => APP_DOMAIN . "professor/logout"]
        ], 0)
        ->addSearch(APP_DOMAIN . "professor/search")
        ->show();
    // update last activity date
    (new UserModel)->updateLastActivity($user_name);
}
