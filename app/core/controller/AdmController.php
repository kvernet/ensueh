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

        $ar = (new AdmModel)->getStatusDetails($user_name);
        if(count($ar) <= 0) return Status::UNKNOWN;

        $status = Status::get($ar['status']);
        if($status == Status::REQUESTED) return $status;

        if($status == Status::CONNECTED) {
            // same device/browser
            if($ar['uniqid'] == $_COOKIE['adm_uniqid']) {
                if($ar['tdiff'] <= ONLINE_DURATION) {
                    return Status::ONLINE;
                }
                else {
                    if($ar['tdiff'] <= ACTIVE_DURATION) {
                        return Status::ACTIVE;
                    }
                    else {
                        return Status::INACTIVE;
                    }
                    return Status::OFFLINE;
                }
            }
            elseif($ar['tdiff'] > ACTIVE_DURATION) {
                return Status::DISCONNECTED;
            }
        }

        return $status;
    }

    public function goCheck($page, $title=APP_NAME . " - ADM") {
        $status = AdmController::getStatus();
        if($status == Status::ONLINE || $status == Status::ACTIVE) {
            $this->view($page, [
                "title" => $title
            ]);
        }
        else {
            $this->view("error/info", [
                "title" => APP_NAME . " - ADM",
                "msg" => Status::getCaseErrorMsg($status)
            ]);
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