<?php

require_once("config.php");

spl_autoload_register(function($class) {
    $file = str_replace("\\", "/", $class) . ".php";
    require_once(APP_DIR . $file);
});

function redirectMe($page, $params=[]) {
    header("Location: " . $page);
    exit(0);
}