<?php

namespace app\core\controller;

use app\core\entity\Message;

class HomeController extends Controller {

    public function _404() : void {
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/home/header.php",
            "footer" => PUBLIC_DIR . "view/home/footer.php",
            "title" => APP_NAME . " - Erreur 404",
            "msg" => Message::getMessage(Message::PAGE_NOT_EXISTS_MSG)
        ]);
        die();
    }

    public function coaching() {
        $this->view("home/coaching", [
            "title" => APP_NAME
        ]);
    }

    public function departments() {
        $this->view("home/departments", [
            "title" => APP_NAME
        ]);
    }

    public function developers() {
        $this->view("home/developers", [
            "title" => APP_NAME
        ]);
    }

    public function direction() {
        $this->view("home/direction", [
            "title" => APP_NAME
        ]);
    }

    public function formations() {
        $this->view("home/formations", [
            "title" => APP_NAME
        ]);
    }

    public function forums() {
        $this->view("home/forums", [
            "title" => APP_NAME
        ]);
    }
    
    public function index() {
        $this->view("home/index", [
            "title" => APP_NAME
        ]);
    }

    public function inews() {
        $this->view("home/inews", [
            "title" => APP_NAME
        ]);
    }

    public function jobs() {
        $this->view("home/jobs", [
            "title" => APP_NAME
        ]);
    }

    public function laboratories() {
        $this->view("home/laboratories", [
            "title" => APP_NAME
        ]);
    }

    public function lnews() {
        $this->view("home/lnews", [
            "title" => APP_NAME
        ]);
    }

    public function login() {
        $this->view("home/login", [
            "title" => APP_NAME
        ]);
    }

    public function partnerships() {
        $this->view("home/partnerships", [
            "title" => APP_NAME
        ]);
    }

    public function phds() {
        $this->view("home/phds", [
            "title" => APP_NAME
        ]);
    }

    public function projects() {
        $this->view("home/projects", [
            "title" => APP_NAME
        ]);
    }

    public function publications() {
        $this->view("home/publications", [
            "title" => APP_NAME
        ]);
    }

    public function rdv() {
        $this->view("home/rdv", [
            "title" => APP_NAME
        ]);
    }

    public function request_login() {
        $this->view("home/request_login", [
            "title" => APP_NAME
        ]);
    }

    public function request_signup() {
        $this->view("home/request_signup", [
            "title" => APP_NAME
        ]);
    }

    public function researchers() {
        $this->view("home/researchers", [
            "title" => APP_NAME
        ]);
    }

    public function search() {
        $this->view("home/search", [
            "title" => APP_NAME
        ]);
    }

    public function signup() {
        $this->view("home/signup", [
            "title" => APP_NAME
        ]);
    }

    public function ueh() {
        $this->view("home/ueh", [
            "title" => APP_NAME
        ]);
    }

    public function venir() {
        $this->view("home/venir", [
            "title" => APP_NAME
        ]);
    }
}