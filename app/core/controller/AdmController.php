<?php

namespace app\core\controller;

use app\core\entity\Message;
use app\core\entity\Status;
use app\core\model\UserModel;

class AdmController extends Controller {
    
    public function _403() : void {
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/adm/header.php",
            "footer" => PUBLIC_DIR . "view/adm/footer.php",
            "title" => APP_NAME . " - Erreur 403",
            "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG)
        ]);
        die();
    }

    public function _404() : void {
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/adm/header.php",
            "footer" => PUBLIC_DIR . "view/adm/footer.php",
            "title" => APP_NAME . " - Erreur 404",
            "msg" => Message::getMessage(Message::PAGE_NOT_EXISTS_MSG)
        ]);
        die();
    }

    public function cpwd() : void {
        $this->goCheck("adm/cpwd");
    }

    static public function getStatus() : Status {
        $user_name = AdmController::getUserName();
        if($user_name == null) return Status::UNKNOWN;

        $ar = (new UserModel)->getStatusDetails($user_name);
        if(count($ar) <= 0) return Status::UNKNOWN;

        $status = Status::get($ar['status_id']);
        if($status == Status::REQUESTED) return $status;

        if($status == Status::CONNECTED) {
            // same device/browser
            $uniqid = AdmController::getUniqid();
            if($uniqid != null && $uniqid == $ar['uniqid']) {
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

    public function goCheck(string $page, string $title=APP_NAME . " - ADM") : void {
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

    public function home() : void {
        $this->goCheck("adm/home");
    }
    
    public function index() : void {
        if(AdmController::getStatus() == Status::ONLINE) {
            redirectMe("adm/home");
        }
        else {
            $this->view("adm/index", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
    }

    public function login() : void {
        if(AdmController::getStatus() == Status::ONLINE) {
            redirectMe("adm/home");
        }
        else {
            $this->view("adm/login", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
    }

    public function logout() : void {
        if(AdmController::getStatus() == Status::ONLINE) {
            $this->view("adm/logout", [
                "title" => APP_NAME . " - ADM"
            ]);
        }
        else {
            $this->_403();
        }
    }

    public function msg_received() {
        $this->goCheck("adm/msg_received");
    }

    public function msg_sent() {
        $this->goCheck("adm/msg_sent");
    }

    public function professor() : void {
        $this->goCheck("adm/professor");
    }

    public function search() : void {
        $this->goCheck("adm/search");
    }

    public function student() : void {
        $this->goCheck("adm/student");
    }

    static public function getUniqid() : string|null {
        return $_COOKIE['adm_uniqid'] ?? null;
    }

    static public function getUserName() : string|null {
        if(isset($_SESSION["adm_user_name"])) return $_SESSION["adm_user_name"];
        elseif(isset($_COOKIE["adm_user_name"])) return $_COOKIE["adm_user_name"];
        
        return null;
    }

    public function user_suspend() : void {
        $this->goCheck("adm/user_suspend");
    }

    public function user_update() : void {
        $this->goCheck("adm/user_update");
    }

    public function user_validate() : void {
        $this->goCheck("adm/user_validate");
    }
}