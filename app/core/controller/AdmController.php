<?php

namespace app\core\controller;

use app\core\model\AdmModel;

session_start();

class AdmController extends Controller {
    
    public function index() {
        if(AdmController::IsConnected()) {
            $this->home();
        }
        else {
            $this->view("adm/index", [
                "title" => APP_NAME . " ADM"
            ]);
        }
    }

    public function login() {
        if(AdmController::IsConnected()) {
            $this->home();
        }
        else {
            $this->view("adm/login", [
                "title" => APP_NAME . " ADM"
            ]);
        }
    }

    public function home() {
        if(AdmController::IsConnected()) {
            $this->view("adm/home", [
                "title" => APP_NAME . " ADM"
            ]);
        }
        else {
            $this->_403();
        }
    }

    public function logout() {
        if(AdmController::IsConnected()) {
            $this->view("adm/logout", [
                "title" => APP_NAME . " ADM"
            ]);
        }
        else {
            $this->_403();
        }
    }

    public function _404() : void {
        $this->view("error/_404", [
            "header" => PUBLIC_DIR . "adm/header.php",
            "footer" => PUBLIC_DIR . "adm/footer.php",
            "title" => APP_NAME . " - Erreur 404"
        ]);
        die();
    }

    public function info() {
        if(AdmController::IsConnected()) {
            $this->home();
        }
        else {
            $this->view("adm/info", [
                "title" => APP_NAME . " ADM"
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
}