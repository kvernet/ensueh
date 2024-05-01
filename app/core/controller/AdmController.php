<?php

namespace app\core\controller;

use app\core\model\AdmModel;

session_start();

class AdmController extends Controller {
    
    public function _403() : void {
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/adm/header.php",
            "footer" => PUBLIC_DIR . "view/adm/footer.php",
            "title" => APP_NAME . " - Erreur 403",
            "msg" => ACCESS_DENIED_MSG
        ]);
        die();
    }

    public function _404() : void {
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/adm/header.php",
            "footer" => PUBLIC_DIR . "view/adm/footer.php",
            "title" => APP_NAME . " - Erreur 404",
            "msg" => PAGE_NOT_EXISTS_MSG
        ]);
        die();
    }

    public function home() {
        if(AdmController::IsConnected()) {
            $this->view("adm/home", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
        else {
            $this->_403();
        }
    }
    
    public function index() {
        if(AdmController::IsConnected()) {
            redirectMe("adm/home");
        }
        else {
            $this->view("adm/index", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
    }

    static public function IsConnected() {
        $admModel = new AdmModel;
        $user_name = $_SESSION["adm_user_name"];
        if($user_name) {
            return $admModel->isConnected($user_name);
        }
        else {
            return false;
        }
    }

    public function login() {
        if(AdmController::IsConnected()) {
            redirectMe("adm/home");
        }
        else {
            $this->view("adm/login", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
    }

    public function logout() {
        if(AdmController::IsConnected()) {
            $this->view("adm/logout", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
        else {
            $this->_403();
        }
    }
}