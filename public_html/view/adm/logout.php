<?php

use app\core\model\AdmModel;

session_start();
$user_name = $_SESSION["adm_user_name"];

// update the database
$admModel = new AdmModel;
$admModel->logout($user_name);

// remove all session variables
session_unset();

// destroy the session
session_destroy();

redirectMe("index");