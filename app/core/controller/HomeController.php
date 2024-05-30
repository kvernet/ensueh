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

    public function admission() : void {
        $this->view("home/admission", [
            "title" => APP_NAME
        ]);
    }

    public function coaching() : void {
        $this->view("home/coaching", [
            "title" => APP_NAME
        ]);
    }

    public function departments() : void {
        $this->view("home/departments", [
            "title" => APP_NAME
        ]);
    }

    public function direction() : void {
        $this->view("home/direction", [
            "title" => APP_NAME
        ]);
    }

    public function formations() : void {
        $this->view("home/formations", [
            "title" => APP_NAME
        ]);
    }

    public function forums() : void {
        $this->view("home/forums", [
            "title" => APP_NAME
        ]);
    }

    public function index() : void {
        $this->view("home/index", [
            "title" => APP_NAME
        ]);
    }

    public function inews() : void {
        $this->view("home/inews", [
            "title" => APP_NAME
        ]);
    }

    public function jobs() : void {
        $this->view("home/jobs", [
            "title" => APP_NAME
        ]);
    }

    public function laboratories() : void {
        $this->view("home/laboratories", [
            "title" => APP_NAME
        ]);
    }

    public function lnews() : void {
        $this->view("home/lnews", [
            "title" => APP_NAME
        ]);
    }

    public function login() : void {
        $this->view("home/login", [
            "title" => APP_NAME
        ]);
    }

    public function news() : void {
        $this->view("home/news", [
            "title" => APP_NAME
        ]);
    }

    public function partnerships() : void {
        $this->view("home/partnerships", [
            "title" => APP_NAME
        ]);
    }

    public function presentation() : void {
        $this->view("home/presentation", [
            "title" => APP_NAME
        ]);
    }    

    public function phds() : void {
        $this->view("home/phds", [
            "title" => APP_NAME
        ]);
    }

    public function projects() : void {
        $this->view("home/projects", [
            "title" => APP_NAME
        ]);
    }

    public function publications() : void {
        $this->view("home/publications", [
            "title" => APP_NAME
        ]);
    }

    public function rdv() : void {
        $this->view("home/rdv", [
            "title" => APP_NAME
        ]);
    }

    public function request_login() : void {
        $this->view("home/request_login", [
            "title" => APP_NAME
        ]);
    }

    public function request_signup() : void {
        $this->view("home/request_signup", [
            "title" => APP_NAME
        ]);
    }

    public function researchers() : void {
        $this->view("home/researchers", [
            "title" => APP_NAME
        ]);
    }

    public function search() : void {
        $this->view("home/search", [
            "title" => APP_NAME
        ]);
    }

    public function signup() : void {
        $this->view("home/signup", [
            "title" => APP_NAME
        ]);
    }

    public function signup_welcome() {
        $this->view("home/signup_welcome", [
            "title" => APP_NAME
        ]);
    }

    public function ueh() : void {
        $this->view("home/ueh", [
            "title" => APP_NAME
        ]);
    }

    public function venir() : void {
        $this->view("home/venir", [
            "title" => APP_NAME
        ]);
    }
}