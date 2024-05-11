<?php

declare(strict_types = 1);

require_once("config.php");
require_once("bootstrap.php");

spl_autoload_register(function($class) {
    $file = str_replace("\\", "/", $class) . ".php";
    require_once(APP_DIR . $file);
});