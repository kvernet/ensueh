<?php

function pretiffy($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function add_header() {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<link rel='shortcut icon' type='image/x-icon' href='". LOGO_PATH ."'/>";
    echo "<title>" . SITE_TITLE . "</title>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>";
    echo "<link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.10.0/css/all.css'>";
    echo "<link rel='stylesheet' href='". MAIN_CSS ."'>";
    echo "</head>";
}

function start_body() {
    echo "<body class='bg-cover'>";
    echo "<div class='main-container d-flex'>";
}

function add_list($url, $icon, $name, $class, $active = false) {
    if($active) {
        echo "<li class='active'><a class='". $class ."' href='". $url ."'><i class='". $icon ."'></i> ". $name ."</a></li>";
    }
    else {
        echo "<li><a class='". $class ."' href='". $url ."'><i class='". $icon ."'></i> ". $name ."</a></li>";
    }
}

function add_lists($urls, $icons, $names, $index) {
    echo "<ul class='list-unstyled px-2'>";
    $count = count($names);
    for($i = 0; $i < $count; $i++) {
        $active = $i == $index;
        $class = "text-decoration-none px-3 py-2 d-block";
        add_list($urls[$i], $icons[$i], $names[$i], $class, $active);
    }
    echo "</ul>";
}

function show_sideBar($index1 = 0, $index2 = 0) {
    $ROOT_DIR = DOMAIN_NAME . "/home";
    
    echo "<div class='ensueh-sidebar'>";
    echo "<div class='header-box px-2 pt-3 pb-4 d-flex justify-content-between'>";
    echo "<h1 class='fs-4'><span class='bg-white rounded shadow px-2 me-2 text-yellow'>". SITE_NAME ."</span><span class='text-white'>". SITE_NAME_SUFFIX ."</span>";
    echo "<button class='btn d-md-none close-btn px-2 py-0 text-white' onclick='return closeSideBar();'><i class='far fa-window-close'></i></button>";
    echo "</h1>";
    echo "</div>";

    $names   = ["Accueil", "Direction", "Formations", "Départements", 
            "Contact", "Connexion", "Inscription"];
    $icons   = ["fal fa-home", "", "fas fa-user-graduate", 
            "far fa-user-tag", "fal fa-address-card", "fas fa-sign-in", "fas fa-user-plus"];
    $urls    = [ $ROOT_DIR, $ROOT_DIR . "/direction",  $ROOT_DIR . "/formations", 
            $ROOT_DIR . "/departements",  $ROOT_DIR . "/contact", 
            $ROOT_DIR . "/connexion", $ROOT_DIR . "/inscription"];
    
    add_lists($urls, $icons, $names, $index1);
    
    echo "<hr class='h-color mx-2'>";

    $names   = ["UEH", "Forums", "Concepteur"];
    $icons   = ["fas fa-university", "fab fa-forumbee", "fad fa-user-check"];
    $urls    = [$ROOT_DIR . "/ueh", $ROOT_DIR . "/forums", 
            $ROOT_DIR . "/concepteur"];
    
    add_lists($urls, $icons, $names, $index2);
    echo "</div>";
}

function add_dropList($title, $urls, $names, $active = false) {
    if($active) echo "<li class='nav-item dropdown active'>";
    else echo "<li class='nav-item dropdown'>";
    echo "<a class='nav-link dropdown-toggle' href='' role='button' data-bs-toggle='dropdown' aria-expanded='false'>";
    echo $title;
    echo "</a>";
    echo "<ul class='dropdown-menu'>";
    $count = count($names);
    for($i = 0; $i < $count; $i++) {
        echo "<li><a class='dropdown-item' href='". $urls[$i] ."'>". $names[$i] ."</a></li>";
    }
    echo "</ul>";
    echo "</li>";
}

function add_search() {
    echo "<form class='d-flex' role='search'>";
    echo "<input class='form-control me-2' id='p' name='p' type='search' placeholder='". SEARCH_PLACEHOLDER ."' aria-label='Search'>";
    echo "<button class='btn btn-outline-success' type='submit'>Rechercher</button>";
    echo "</form>";
}

function show_navBar($index = 0) {
    $ROOT_DIR = DOMAIN_NAME . "/home";
    
    echo "<nav class='navbar navbar-expand-md ensueh-navbar'>";
    echo "<div class='container-fluid'>";
    echo "<div class='d-flex justify-content-between d-md-none d-block'>";
    echo "<button class='btn px-1 py-0 open-btn me-2' onclick='return openSideBar();'><i class='fal fa-stream'></i>";
    echo "<a class='navbar-brand fs-4' href='#'><span class='bg-white rounded px-2 py-0 text-dark'>". SITE_NAME ."</span></a>";
    echo "</button>";
    echo "</div>";
    
    echo "<button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>";
    echo "<span class='navbar-toggler-icon'></span>";
    echo "</button>";
    
    echo "<div class='collapse navbar-collapse justify-content-end' id='navbarSupportedContent'>";
    echo "<ul class='navbar-nav mb-2 mb-lg-0'>";

    $title = "Recherche";
    $names = ["Actualités", "Laboratoires", "Projets", 
            "Doctorants", "Chercheurs", "Publications"];
    $urls = [$ROOT_DIR . "/lactualites", $ROOT_DIR . "/laboratoires", 
            $ROOT_DIR . "/projets", $ROOT_DIR . "/doctorants", 
            $ROOT_DIR . "/chercheurs", $ROOT_DIR . "/publications"];
    $active = $index == 0;
    add_dropList($title, $urls, $names, $active);

    $title = "International";
    $names = ["Actualités", "Cooperations", "Venir à l'ENS"];
    $urls = [$ROOT_DIR . "/iactualites", $ROOT_DIR . "/coorperations", 
            $ROOT_DIR. "/venir"];
    $active = $index == 1;
    add_dropList($title, $urls, $names, $active);

    $title = "Orientations";
    $names = ["Acompagnements", "Stages & emplois", "Prendre rendez-vous"];
    $urls = [$ROOT_DIR . "/accompagnements", $ROOT_DIR . "/emplois", 
            $ROOT_DIR . "/rendezvous"];
    $active = $index == 2;
    add_dropList($title, $urls, $names, $active);

    $ndropList = 3;

    echo "</ul>";

    add_search();

    echo "</div>";
    echo "</div>";
    echo "</nav>";
}

function show_header($iside1 = 0, $iside2 = 0, $inav = 0) {
    add_header();
    start_body();
    show_sideBar($iside1, $iside2);
    echo "<div class='content'>";
    show_navBar($inav);
}

function show_footer() {
    echo "</div>";
    echo "</div>";
    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>";
    echo "<script src='". SIDEBAR_JS_PATH ."'></script>";
    echo "</body>";
    echo "</html>";
}