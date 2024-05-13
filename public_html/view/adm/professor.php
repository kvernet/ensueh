<?php

use app\core\model\AdmModel;

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des professeurs (ADM) en construction...</h3>';

$admModel = new AdmModel;
$users = $admModel->getUsers(2);

echo "<table>";
foreach($users as $user) {
    echo $user->asTableRow();
}
echo "</table>";

include_once("footer.php");