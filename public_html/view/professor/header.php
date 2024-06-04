<?php

use app\core\controller\ProfessorController;
use app\core\entity\Header;
use app\core\entity\Navbar;
use app\core\entity\Status;
use app\core\model\UserModel;

$user_name = ProfessorController::getUserName();

(new Header)->setTitle($params["title"] ?? APP_NAME)->show();
if(!isset($params['nav_item_active'])) {
    $params['nav_item_active'] = "";
}

//TODO, read from database
$params["n_received_msg"] = 0;

$status = ProfessorController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    $navbar = new Navbar;
    $navbar->addLi("Cours", APP_DOMAIN . "professor/courses", $params['nav_item_active'] == "Cours")
        ->addLi("Notes", APP_DOMAIN . "professor/notes", $params['nav_item_active'] == "Notes")
        ->addLi("Mon calendrier", APP_DOMAIN . "professor/calendar", $params['nav_item_active'] == "Mon calendrier")
        ->addLi("Mes projets", APP_DOMAIN . "professor/projects", $params['nav_item_active'] == "Mes projets")
        ->addLiDropdown("Mes messages", [
            ["text" => "Envoyés", "href" => APP_DOMAIN . "professor/msg_sent"],
            ["text" => "Reçus(" . $params["n_received_msg"] . ")", "href" => APP_DOMAIN . "professor/msg_received"]
        ], -1)
        ->addLiDropdown("Mon compte", [
            ["text" => "Mon profil", "href" => APP_DOMAIN . "professor/profile"],
            ["text" => "Mes publications", "href" => APP_DOMAIN . "professor/publications"],
            ["text" => "Changer mot de passe", "href" => APP_DOMAIN . "professor/cpwd"],
            ["text" => "Se déconnecter", "href" => APP_DOMAIN . "professor/logout"]
        ], 2)
        ->addSearch(APP_DOMAIN . "professor/search")
        ->show();
    // update last activity date
    (new UserModel)->updateLastActivity($user_name);
}
