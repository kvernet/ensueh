<?php

namespace app\core\controller;

class Controller {

    public function _404() : void {
        $this->view("error/_404", [
            "title" => APP_NAME . " - Erreur 404"
        ]);
        die();
    }

    protected function view(string $page, array $params=[]) : void {
        require_once(PUBLIC_DIR . $page . ".php");
    }
}