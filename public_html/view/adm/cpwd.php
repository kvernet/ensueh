<?php

use app\core\model\AdmModel;

include_once("header.php");

echo '<h3 style="text-align: center;">Changement mot de passe (ADM) en construction...</h3>';

$status = (new AdmModel)->getStatus($adm_user_name);
var_dump($status);

include_once("footer.php");