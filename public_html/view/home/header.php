<?php

use app\core\entity\Header;
use app\core\entity\Navbar;

$header = new Header;
$header->show();

$navbar = new Navbar;
$navbar->addLi("Accueil", APP_DOMAIN . "home/index", ['active'], ["aria-current" => "page"])
->addLi("Formations", APP_DOMAIN . "home/formations")
->addLi("Direction", APP_DOMAIN . "home/direction")
->addLiDropdown("Recherche", [
    ["text" => "Actualités", "href" => APP_DOMAIN . "home/lnews"],
    ["text" => "Laboratoires", "href" => APP_DOMAIN . "home/laboratories"],
    ["text" => "Projets", "href" => APP_DOMAIN . "home/projects"],
    ["text" => "Doctorants", "href" => APP_DOMAIN . "home/phds"],
    ["text" => "Enseignants-chercheurs", "href" => APP_DOMAIN . "home/researchers"],
    ["text" => "Publications", "href" => APP_DOMAIN . "home/publications"],
])
->addLiDropdown("International", [
    ["text" => "Actualités", "href" => APP_DOMAIN . "home/inews"],
    ["text" => "Partenariats", "href" => APP_DOMAIN . "home/partnerships"],
    ["text" => "Venir à l'ENS", "href" => APP_DOMAIN . "home/venir"]
])
->addLiDropdown("Orientations", [
    ["text" => "Stages & emplois", "href" => APP_DOMAIN . "home/jobs"],
    ["text" => "Prendre un rendez-vous", "href" => APP_DOMAIN . "home/rdv"]
])
->addLiDropdown("Contact", [
    ["text" => "Direction", "href" => APP_DOMAIN . "home/direction"],
    ["text" => "UEH", "href" => APP_DOMAIN . "home/ueh"],
    ["text" => "Forums", "href" => APP_DOMAIN . "home/forums"],
    ["text" => "Concepteurs", "href" => APP_DOMAIN . "home/developers"]
])
->addLi("Se connecter", APP_DOMAIN . "home/login")
->addSearch(APP_DOMAIN . "home/search");
$navbar->show();