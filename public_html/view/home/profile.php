<?php

use app\core\model\ProfileModel;
use app\core\model\PublicationModel;
use app\core\model\UserModel;

$params['nav_item_active'] = "Recherche";

include_once("header.php");

function getPublications(string $user_name) : string {
    $dummy = "";
    $publications = (new PublicationModel)->getAllByUserName($user_name);
    foreach($publications as $publication) {
        $dummy .= $publication->toString();
    }
    return $dummy;
}

$user = null;
if (isset($_GET['r'])) {
    $user = (new UserModel)->getByUserName($_GET['r']);
}

if ($user != null) {
    $user_name = $user->getUserName();

    echo '<h3 style="text-align: center;">Profil de '. $user->getFullName() .'</h3>';

    $profile = (new ProfileModel)->getByUserName($user_name);

    $dummy = '<div data-mdb-input-init class="form-outline">'
    . '<p class="bold lead">Mes publications</p>'
    . '<p class="text-justify">' . getPublications($user_name)
    . '</p>'
    . '</div>';
    $profile->showFull($dummy);

    echo '<hr class="lead">';
}

include_once("footer.php");
