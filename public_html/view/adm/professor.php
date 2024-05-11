<?php

use app\core\controller\AdmController;
use app\core\model\AdmModel;

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des professeurs (ADM) en construction...</h3>';

$adm_user_name = AdmController::getUserName();
$admModel = new AdmModel;
$ar = $admModel->getStatusDetails($adm_user_name);
$status = AdmModel::getStatus($ar);

pretiffy($ar);
pretiffy($status);

include_once("footer.php");