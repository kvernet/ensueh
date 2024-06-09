<?php

use app\core\controller\StudentController;
use app\core\entity\Header;
use app\core\entity\Navbar;
use app\core\entity\Status;
use app\core\model\UserModel;

$user_name = StudentController::getUserName();

(new Header)->setTitle($params["title"] ?? APP_NAME)->show();
if(!isset($params['nav_item_active'])) {
    $params['nav_item_active'] = "";
}

//TODO, read from database
$params["n_received_msg"] = 0;

$status = StudentController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    $navbar = new Navbar;
    $navbar->addLi("Cours", APP_DOMAIN . "student/courses", $params['nav_item_active'] == "Cours")
        ->addLi("Relevés de notes", APP_DOMAIN . "student/transcripts", $params['nav_item_active'] == "Relevés de notes")
        ->addLi("Certificats de scolarité", APP_DOMAIN . "student/certificates", $params['nav_item_active'] == "Certificats de scolarité")
        ->addLiDropdown("Mes messages", [
            ["text" => "Envoyés", "href" => APP_DOMAIN . "student/msg_sent"],
            ["text" => "Reçus(" . $params["n_received_msg"] . ")", "href" => APP_DOMAIN . "student/msg_received"]
        ], -1)
        ->addLiDropdown("Mon compte<sup>". $user_name ."</sup>", [
            ["text" => "Changer mot de passe", "href" => APP_DOMAIN . "student/cpwd"],
            ["text" => "Se déconnecter", "href" => APP_DOMAIN . "student/logout"]
        ], 0)
        ->addSearch(APP_DOMAIN . "student/search")
        ->show();
    // update last activity date
    (new UserModel)->updateLastActivity($user_name);
}