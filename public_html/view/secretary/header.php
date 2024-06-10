<?php

use app\core\controller\SecretaryController;
use app\core\entity\Header;
use app\core\entity\Navbar;
use app\core\entity\Status;
use app\core\model\UserModel;

$user_name = SecretaryController::getUserName();

$header = new Header;
$header->setTitle($params["title"] ?? APP_NAME)->show();
if(!isset($params['nav_item_active'])) {
    $params['nav_item_active'] = "";
}

//TODO, read from database
$params["n_received_msg"] = 0;

$status = SecretaryController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    (new Navbar)
        ->addLiDropdown("Etudiants", [
            ["text" => "Informations", "href" => "students"],
            ["text" => "Notes", "href" => "notes"]
        ])
        ->addLi("Professeurs", "professors", $params['nav_item_active'] == "Professeurs")
        ->addLiDropdown("Mes messages", [
            ["text" => "Envoyés", "href" => "msg_sent"],
            ["text" => "Reçus(" . $params["n_received_msg"] . ")", "href" => "msg_received"]
        ], -1)
        ->addLiDropdown("Mon compte<sup>". $user_name ."</sup>", [
            ["text" => "Changer mot de passe", "href" => "cpwd"],
            ["text" => "Se déconnecter", "href" => "logout"]
        ], 0)
        ->addSearch("search")
        ->show();
    // update last activity date
    (new UserModel)->updateLastActivity($user_name);
}
