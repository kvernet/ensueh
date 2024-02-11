<?php

define("APP_DIR", __DIR__ . "/../../");
require_once(APP_DIR . "app/inc/config.php");
require_once(APP_DIR . "app/inc/functions.php");

$paths = [
    "Request", "Router"
];
foreach ($paths as $key => $value) {
    require_once(APP_DIR . "app/" . $value . ".php");
}

$controllers = [
    "", "Adm", "Home", "Professor", "User", "Visitor"
];
foreach($controllers as $key => $value) {
    require_once(APP_DIR . "app/controller/" . $value . "Controller.php");
}