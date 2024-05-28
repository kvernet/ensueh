<?php

namespace app\core\controller;

use app\core\entity\Message;
use app\core\entity\Status;
use app\core\entity\WhoAmI;
use app\core\model\UserModel;

class UserController extends Controller {
    protected $dir = "student/";
    protected $title = APP_NAME . " - Etudiant";
    protected $whoAmI = WhoAmI::STUDENT;

    public function _403() : void {
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/". $this->dir ."header.php",
            "footer" => PUBLIC_DIR . "view/". $this->dir ."footer.php",
            "title" => APP_NAME . " - Erreur 403",
            "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG)
        ]);
        die();
    }

    public function _404() : void {
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/". $this->dir ."header.php",
            "footer" => PUBLIC_DIR . "view/". $this->dir ."footer.php",
            "title" => APP_NAME . " - Erreur 404",
            "msg" => Message::getMessage(Message::PAGE_NOT_EXISTS_MSG)
        ]);
        die();
    }

    public function canAccesIt() : bool {
        $user_name = self::getUserName();
        if($user_name == null) return false;

        $whoAmI = (new UserModel)->getWhoAmI($user_name);
        return $whoAmI === $this->whoAmI;
    }

    public function cpwd() : void {
        $this->goCheck($this->dir . "cpwd");
    }

    static public function getStatus() : Status {
        $user_name = self::getUserName();
        if($user_name == null) return Status::UNKNOWN;

        $ar = (new UserModel)->getStatusDetails($user_name);
        if(count($ar) <= 0) return Status::UNKNOWN;

        $status = Status::get($ar['status_id']);
        if($status == Status::REQUESTED) return $status;

        if($status == Status::CONNECTED) {
            // same device/browser
            $uniqid = self::getUniqid();
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

    public function goCheck(string $page) : void {
        $status = self::getStatus();
        if($this->canAccesIt()) {
            if($this->canAccesIt() && ($status == Status::ONLINE || $status == Status::ACTIVE)) {
                $this->view($page, [
                    "title" => $this->title
                ]);
            }
            else {
                $this->view("error/info", [
                    "title" => $this->title,
                    "msg" => Status::getCaseErrorMsg($status)
                ]);
            }
        }
        else {
            $this->view("error/info", [
                "title" => $this->title,
                "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG)
            ]);
        }        
    }

    public function logout() : void {
        $this->goCheck($this->dir . "logout");
    }

    public function msg_received() {
        $this->goCheck($this->dir . "msg_received");
    }

    public function msg_sent() {
        $this->goCheck($this->dir . "msg_sent");
    }

    public function search() : void {
        $this->goCheck($this->dir . "search");
    }

    public function setDir(string $dir) : self {
        $this->dir = $dir;
        return $this;
    }

    public function setTitle(string $title) : self {
        $this->title = $title;
        return $this;
    }

    public function setWhoAmI(WhoAmI $whoAmI) : self {
        $this->whoAmI = $whoAmI;
        return $this;
    }

    static public function getUniqid() : string|null {
        return $_COOKIE['uniqid'] ?? null;
    }

    static public function getUserName() : string|null {
        if(isset($_SESSION["user_name"])) return $_SESSION["user_name"];
        elseif(isset($_COOKIE["user_name"])) return $_COOKIE["user_name"];        
        return null;
    }

    public function user_suspend() : void {
        $this->goCheck($this->dir . "user_suspend");
    }

    public function user_update() : void {
        $this->goCheck($this->dir . "user_update");
    }

    public function user_validate() : void {
        $this->goCheck($this->dir . "user_validate");
    }

    public function get_users_as_table() {
        $this->goCheck($this->dir . "get_users_as_table");
    }
}