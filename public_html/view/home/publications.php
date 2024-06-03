<?php

use app\core\entity\Publication;
use app\core\entity\User;
use app\core\model\PublicationModel;
use app\core\model\UserModel;

$params['nav_item_active'] = "Recherche";

include_once("header.php");

function addPublication(Publication $publication) : void {
    $doi = $publication->getDOI();
    
    echo '<div class="row">'
    . '<div class="col">'
    . $publication->getName()
    . '</div>'
    . '</div>'
    . '<div class="row">'
    . '<div class="col">'
    . '<a href="'. $doi .'" target="_blank">'. $doi .'</a>'
    . '</div>'
    . '</div>'
    . '<hr class="lead">';
}

function getTitle(User|null $user) : string {
    $tile = "Nos publications";
    if($user) {
        $tile = "Publications de " . $user->getFullName();
    }
    return $tile;
}

function getPublications(User|null $user) : array {
    if($user) {
        return (new PublicationModel)->getAllByUserName($user->getUserName());
    }else {
        return (new PublicationModel)->getAll();
    }
}

$user = null;
if(isset($_GET['r'])) {
    $user = (new UserModel)->getByUserName($_GET['r']);
}

echo '<div class="jumbotron">';

echo '<h2 class="display-5">'. getTitle($user) .'</h2>';

$publications = getPublications($user);

foreach($publications as $publication) {
    addPublication($publication);
}

echo '</div>';

include_once("footer.php");