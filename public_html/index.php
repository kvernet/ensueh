<?php

session_start();

use app\core\router\Router;

require_once("../app/inc/autoloader.php");

Router::route();