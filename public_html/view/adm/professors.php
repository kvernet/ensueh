<?php

use app\core\entity\WhoAmI;

$params['nav_item_active'] = "Professeurs";

$params['whoami'] = WhoAmI::PROFESSOR->value;
$params['whoami_title'] = "professeurs";
$params['current_page_cookie'] = "tabulator_professor_current_page";
$params['return_page'] = "professors";

include_once("users.php");