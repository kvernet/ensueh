<?php

use app\core\entity\Profile;
use app\core\model\ProfileModel;

$params['nav_item_active'] = "Recherche";

include_once("header.php");

function addProfile(Profile $profile) : void {
    echo '<div class="row">'
    . '<div class="col-sm-2">'
    . '<div data-mdb-input-init class="form-outline">'
    . '<img class="form-control" name="" id="" src="../../img/researchers/'. $profile->getPhotoPath() .'">'
    . '</div>'
    . '</div>'
    . '<div class="col-sm-10">'
    . '<div data-mdb-input-init class="form-outline">'
    . '<p class="lead">'. $profile->getFullName() .'</p>'
    . '<p>' . $profile->getDescription()
    . '</p>'
    . '<p><a href="publications?r='. $profile->getUserName() .'">Voir publications</a></p>'
    . '</div>'
    . '</div>'
    . '</div>'
    . '<hr class="lead">';
}
?>

<div class="jumbotron">
    <h2 class="display-5">Nos enseignants & chercheurs</h2>
</div>

<div class="researchers">
    <?php
    $profiles = (new ProfileModel)->getAll();
    foreach($profiles as $profile) {
        addProfile($profile);
    }
    ?>
</div>

<?php
include_once("footer.php");
?>