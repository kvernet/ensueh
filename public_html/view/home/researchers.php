<?php

use app\core\model\ProfileModel;

$params['nav_item_active'] = "Recherche";

include_once("header.php");

echo '<div class="jumbotron">'
. '<h2 class="display-5">Nos enseignants & chercheurs</h2>'
. '</div>';

echo '<div class="researchers">';

$profiles = (new ProfileModel)->getAll();
foreach ($profiles as $profile) {
    $profile->show($profile->getFullName(), "Voir profil complet", "profile?r=" . $profile->getUserName());
}
echo '</div>';

include_once("footer.php");