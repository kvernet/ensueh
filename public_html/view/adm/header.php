<?php

use app\core\controller\AdmController;
use app\core\entity\Header;
use app\core\entity\Navbar;
use app\core\entity\Status;
use app\core\model\AdmModel;

session_start();

$adm_user_name = AdmController::getUserName();

$header = new Header;
$header->setTitle($params["title"] ?? APP_NAME)->show();

if(AdmController::getStatus() == Status::ONLINE) {
    $navbar = new Navbar;
    $navbar->addLi("Accueil", APP_DOMAIN . "adm/home", ['active'], ["aria-current" => "page"])
        ->addLi("Etudiants", APP_DOMAIN . "adm/student")
        ->addLi("Professeurs", APP_DOMAIN . "adm/professor")
        ->addLiDropdown("Mon compte", [
            ["text" => "Changer mot de passe", "href" => APP_DOMAIN . "adm/cpwd"],
            ["text" => "Se déconnecter", "href" => APP_DOMAIN . "adm/logout"]
        ], 0)
        ->addSearch(APP_DOMAIN . "adm/search");
    $navbar->show();
    // update last activity date
    (new AdmModel)->updateLastActivity($adm_user_name);
}
