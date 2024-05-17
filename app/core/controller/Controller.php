<?php

namespace app\core\controller;

use app\core\entity\Message;

class Controller {

    public function _404() : void {
        $this->view("error/info", [
            "title" => APP_NAME . " - Erreur 404",
            "msg" => Message::getMessage(Message::PAGE_NOT_EXISTS_MSG)
        ]);
        die();
    }

    public function _403() : void {
        $this->view("error/info", [
            "title" => APP_NAME . " - Erreur 403",
            "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG)
        ]);
        die();
    }

    public function info(array $params=[]) : void {
        $this->view("error/info", $params);
    }

    protected function view(string $page, array $params=[]) : void {
        $file = PUBLIC_DIR . "view/" . $page . ".php";
        if(file_exists($file)) {
            require_once($file);
        }
        else {
            $this->_404();
        }
    }
}