<?php

use app\core\controller\AdmController;
use app\core\entity\Header;
use app\core\entity\Navbar;

session_start();

$adm_user_name = $_SESSION["adm_user_name"];

$header = new Header;
$header->show();

if(AdmController::IsConnected()) {
    $navbar = new Navbar;
    $navbar->addLi("Accueil", APP_DOMAIN . "adm/home", ['active'], ["aria-current" => "page"])
        ->addLi("Etudiants", APP_DOMAIN . "adm/student")
        ->addLi("Professeurs", APP_DOMAIN . "adm/professor")
        ->addLiDropdown("Mon compte<sup>$adm_user_name</sup>", [
            ["text" => "Changer mot de passe", "href" => APP_DOMAIN . "adm/cpwd"],
            ["text" => "Se déconnecter", "href" => APP_DOMAIN . "adm/logout"]
        ], 0)
        ->addSearch(APP_DOMAIN . "adm/search");
    $navbar->show();
}
