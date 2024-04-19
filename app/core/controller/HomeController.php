<?php

namespace app\core\controller;

class HomeController extends Controller {

    public function index() {
        $this->view("home/index", [
            "title" => APP_NAME
        ]);
    }

    public function _404() : void {
        $this->view("error/_404", [
            "header" => PUBLIC_DIR . "home/header.php",
            "footer" => PUBLIC_DIR . "home/footer.php",
            "title" => APP_NAME . " - Erreur 404"
        ]);
        die();
    }
}