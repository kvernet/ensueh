<?php

use app\core\entity\Header;
use app\core\entity\Navbar;

if(!isset($params['nav_item_active'])) {
    $params['nav_item_active'] = "";
}

(new Header)->show();

$navbar = new Navbar;
$navbar->addLi("Accueil", APP_DOMAIN . "home/index", $params['nav_item_active'] == "Accueil")
->addLiDropdown("Recherche", [
    ["text" => "Actualités", "href" => APP_DOMAIN . "home/lnews"],
    ["text" => "Laboratoires", "href" => APP_DOMAIN . "home/laboratories"],
    ["text" => "Projets", "href" => APP_DOMAIN . "home/projects"],
    ["text" => "Doctorants", "href" => APP_DOMAIN . "home/phds"],
    ["text" => "Enseignants & Chercheurs", "href" => APP_DOMAIN . "home/researchers"],
    ["text" => "Publications", "href" => APP_DOMAIN . "home/publications"],
])
->addLiDropdown("International", [
    ["text" => "Actualités", "href" => APP_DOMAIN . "home/inews"],
    ["text" => "Venir à l'ENS", "href" => APP_DOMAIN . "home/venir"]
])
->addLiDropdown("Contact", [
    ["text" => "Direction", "href" => APP_DOMAIN . "home/direction"],
    ["text" => "UEH", "href" => APP_DOMAIN . "home/ueh"],
    ["text" => "Prendre un rendez-vous", "href" => APP_DOMAIN . "home/rdv"]
], 1)
->addSearch(APP_DOMAIN . "home/search");
$navbar->show();