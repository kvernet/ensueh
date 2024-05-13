<?php

use app\core\model\AdmModel;

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des étudiants (ADM) en construction...</h3>';

$admModel = new AdmModel;
$users = $admModel->getUsers(1);

pretiffy($users);

include_once("footer.php");