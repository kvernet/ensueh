<?php

use app\core\entity\WhoAmI;

$params['nav_item_active'] = "Etudiants";

$params['whoami'] = WhoAmI::STUDENT->value;
$params['whoami_title'] = "étudiants";
$params['current_page_cookie'] = "tabulator_student_current_page";
$params['return_page'] = "students";

include_once("users.php");