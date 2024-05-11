<?php

namespace app\core\controller;

session_start();

use app\core\entity\Status;
use app\core\model\AdmModel;
use DateTime;

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

    public function cpwd() {
        $this->goCheck("adm/cpwd");
    }

    static public function getStatus() : Status {
        $user_name = AdmController::getUserName();

        if($user_name == null) return Status::UNKNOWN;
        
        $ar = (new AdmModel)->getStatus($user_name);
        if(count($ar) <= 0) return Status::UNKNOWN;

        // check if status is Status::ONLINE
        $status = Status::get($ar['status']);
        if($status != Status::ONLINE) return $status;

        // check if inactivity duration is higher than given parameter $duration
        if($status == Status::ONLINE && isOffline($ar['tdiff'])) return Status::OFFLINE;
        
        // check if last browser is used
        $uniqid = $_COOKIE['adm_uniqid'];
        if(!isset($uniqid)) return false;
        if($uniqid != $ar['uniqid']) return Status::CONNECTED;
        
        return Status::ONLINE;
    }

    public function goCheck($page, $title=APP_NAME . " - ADM") {
        $status = AdmController::getStatus();
        if($status == Status::ONLINE) {
            $this->view($page, [
                "title" => $title
            ]);
        }
        elseif($status == Status::CONNECTED) {
            $this->view("error/info", [
                "title" => APP_NAME . " - ADM",
                "msg" => ADM_STATUS_CONNECTED_MSG
            ]);
        }
        elseif($status == Status::OFFLINE) {
            $this->view("error/info", [
                "title" => APP_NAME . " - ADM",
                "msg" => ADM_STATUS_OFFLINE_MSG
            ]);
        }
        else {
            $this->_403();
        }
    }

    public function home() {
        $this->goCheck("adm/home");
    }
    
    public function index() {
        if(AdmController::getStatus() == Status::ONLINE) {
            redirectMe("adm/home");
        }
        else {
            $this->view("adm/index", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
    }

    public function login() {
        if(AdmController::getStatus() == Status::ONLINE) {
            redirectMe("adm/home");
        }
        else {
            $this->view("adm/login", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
    }

    public function logout() {
        if(AdmController::getStatus() == Status::ONLINE) {
            $this->view("adm/logout", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
        else {
            $this->_403();
        }
    }

    public function professor() {
        $this->goCheck("adm/professor");
    }

    public function search() {
        $this->goCheck("adm/search");
    }

    public function student() {
        $this->goCheck("adm/student");
    }

    static public function getUserName() : string|null {
        $session_user_name = $_SESSION["adm_user_name"];
        $cookie_user_name  = $_COOKIE["adm_user_name"];

        if(isset($session_user_name) || isset($cookie_user_name)) {
            return isset($session_user_name) ? $session_user_name : $cookie_user_name;
        }
        else {
            return null;
        }
    }
}