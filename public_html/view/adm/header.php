<?php

use app\core\controller\AdmController;
use app\core\entity\Header;
use app\core\entity\Navbar;
use app\core\entity\Status;
use app\core\model\UserModel;

$user_name = AdmController::getUserName();

$header = new Header;
$header->setTitle($params["title"] ?? APP_NAME)->show();

//TODO, read from database
$params["n_received_msg"] = 0;

$status = AdmController::getStatus();
if($status == Status::ONLINE || $status == Status::ACTIVE) {
    $navbar = new Navbar;
    $navbar->addLi("Accueil", APP_DOMAIN . "adm/home", ['active'], ["aria-current" => "page"])
        ->addLiDropdown("Mes messages", [
            ["text" => "Envoyés", "href" => APP_DOMAIN . "adm/msg_sent"],
            ["text" => "Reçus(" . $params["n_received_msg"] . ")", "href" => APP_DOMAIN . "adm/msg_received"]
        ], -1)
        ->addLi("Etudiants", APP_DOMAIN . "adm/student")
        ->addLi("Professeurs", APP_DOMAIN . "adm/professor")
        ->addLiDropdown("Mon compte", [
            ["text" => "Changer mot de passe", "href" => APP_DOMAIN . "adm/cpwd"],
            ["text" => "Se déconnecter", "href" => APP_DOMAIN . "adm/logout"]
        ], 0)
        ->addSearch(APP_DOMAIN . "adm/search")
        ->show();
    // update last activity date
    (new UserModel)->updateLastActivity($user_name);
}
