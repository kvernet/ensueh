<?php

declare(strict_types = 1);

require_once("config.php");
require_once("bootstrap.php");
require_once(PUBLIC_DIR . "tcpdf/tcpdf.php");

spl_autoload_register(function($class) {
    $file = APP_DIR . str_replace("\\", "/", $class) . ".php";
    if(file_exists($file)) {
        require_once($file);
    }
});