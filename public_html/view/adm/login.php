<?php

session_start();

use app\core\controller\AdmController;
use app\core\model\AdmModel;

$admController = new AdmController;

if($_POST) {
    $user_name = $_POST["user_name"];
    $pwd = $_POST["pwd"];

    $admModel = new AdmModel;

    $adm = $admModel->get($user_name, $pwd);
    
    if(!$adm->isNull()) {
        // check if ADM is active
        if($adm->getActive()) {
            // check if already connected on another device/browser
            if(!$admModel->isConnected($user_name)) {
                $_SESSION["adm_user_name"] = $user_name;
                // update ADM data
                $admModel->updateConnection($user_name, true);

                redirectMe("home");
            }
            else {
                $admController->info([
                    "msg" => "Vous êtes déjà connecté(e) sur un autre appareil/navigateur. Veuillez d'abord vous déconnecter."
                ]
                );
            }
        }
        else {
            $admController->info([
                "msg" => 'Cet ADM n\'est pas actif. Veuillez contacter les responsables.<br><a href="'. APP_DOMAIN .'adm">Retour</a>'
            ]
            );
        }
    }
    else {
        $admController->info([
            "msg" => 'Cet ADM n\'existe pas.<br><a href="'. APP_DOMAIN .'adm">Retour</a>'
        ]
        );
    }
}
else {
    $admController->info();
}