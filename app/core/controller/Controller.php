<?php

namespace app\core\controller;

class Controller {

    public function _404() : void {
        $this->view("error/_404", [
            "title" => APP_NAME . " - Erreur 404"
        ]);
        die();
    }

    public function _403() : void {
        $this->view("error/_403", [
            "title" => APP_NAME . " - Erreur 403"
        ]);
        die();
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