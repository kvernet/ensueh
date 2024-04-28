<?php

session_start();

use app\core\model\AdmModel;

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
                var_dump($adm);
                $_SESSION["adm_user_name"] = $user_name;
                // update ADM data
                $admModel->login($user_name);
                redirectMe("home");
            }
            else {
                redirectMe("info", [
                    "message" => "Vous êtes déjà connecté(e) sur un autre appareil/navigateur. Veuillez d'abord vous déconnecter."
                ]);
            }
        }
        else {
            redirectMe("info", [
                "message" => "Cet ADM n'est pas actif. Veuillez contacter les responsables."
            ]);
        }
    }
    else {
        redirectMe("info", [
            "message" => "Cet ADM n'existe pas."
        ]);
    }
}
else {
    redirectMe("index");
}