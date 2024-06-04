<?php

use app\core\controller\ProfessorController;
use app\core\entity\Publication;
use app\core\entity\User;
use app\core\model\PublicationModel;
use app\core\model\UserModel;

$params['nav_item_active'] = "Mon compte";

include_once("header.php");

function getPublications(User|null $user) : array {
    if($user) {
        return (new PublicationModel)->getAllByUserName($user->getUserName());
    }else {
        return (new PublicationModel)->getAll();
    }
}

$user_name = ProfessorController::getUserName();
$user = (new UserModel)->getByUserName($user_name);

echo '<div class="jumbotron">';

echo '<h2 class="display-5">Mes publications</h2>';

$publications = getPublications($user);

foreach($publications as $publication) {
    echo $publication->toString();
}

echo '</div>';

include_once("footer.php");