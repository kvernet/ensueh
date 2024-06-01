<?php

namespace app\core\controller;

use app\core\entity\Message;
use app\core\model\HistoryModel;

class HomeController extends Controller {

    public function _404() : void {
        (new HistoryModel)->add("Page [home::_404] visitée", getUserIP());
        
        $this->view("error/info", [
            "header" => PUBLIC_DIR . "view/home/header.php",
            "footer" => PUBLIC_DIR . "view/home/footer.php",
            "title" => APP_NAME . " - Erreur 404",
            "msg" => Message::getMessage(Message::PAGE_NOT_EXISTS_MSG)
        ]);
        die();
    }

    public function admission() : void {
        (new HistoryModel)->add("Page [admission] visitée", getUserIP());
        
        $this->view("home/admission", [
            "title" => APP_NAME
        ]);
    }

    public function coaching() : void {
        (new HistoryModel)->add("Page [coaching] visitée", getUserIP());
        
        $this->view("home/coaching", [
            "title" => APP_NAME
        ]);
    }

    public function departments() : void {
        (new HistoryModel)->add("Page [departments] visitée", getUserIP());
        
        $this->view("home/departments", [
            "title" => APP_NAME
        ]);
    }

    public function direction() : void {
        (new HistoryModel)->add("Page [direction] visitée", getUserIP());
        
        $this->view("home/direction", [
            "title" => APP_NAME
        ]);
    }

    public function formations() : void {
        (new HistoryModel)->add("Page [formations] visitée", getUserIP());
        
        $this->view("home/formations", [
            "title" => APP_NAME
        ]);
    }

    public function forums() : void {
        (new HistoryModel)->add("Page [forums] visitée", getUserIP());
        
        $this->view("home/forums", [
            "title" => APP_NAME
        ]);
    }

    public function index() : void {
        (new HistoryModel)->add("Page [index] visitée", getUserIP());
        
        $this->view("home/index", [
            "title" => APP_NAME
        ]);
    }

    public function inews() : void {
        (new HistoryModel)->add("Page [inews] visitée", getUserIP());
        
        $this->view("home/inews", [
            "title" => APP_NAME
        ]);
    }

    public function jobs() : void {
        (new HistoryModel)->add("Page [jobs] visitée", getUserIP());
        
        $this->view("home/jobs", [
            "title" => APP_NAME
        ]);
    }

    public function laboratories() : void {
        (new HistoryModel)->add("Page [laboratories] visitée", getUserIP());
        
        $this->view("home/laboratories", [
            "title" => APP_NAME
        ]);
    }

    public function lnews() : void {
        (new HistoryModel)->add("Page [lnews] visitée", getUserIP());
        
        $this->view("home/lnews", [
            "title" => APP_NAME
        ]);
    }

    public function login() : void {
        (new HistoryModel)->add("Page [login] visitée", getUserIP());
        
        $this->view("home/login", [
            "title" => APP_NAME
        ]);
    }

    public function news() : void {
        (new HistoryModel)->add("Page [news] visitée", getUserIP());
        
        $this->view("home/news", [
            "title" => APP_NAME
        ]);
    }

    public function partnerships() : void {
        (new HistoryModel)->add("Page [partnerships] visitée", getUserIP());
        
        $this->view("home/partnerships", [
            "title" => APP_NAME
        ]);
    }

    public function presentation() : void {
        (new HistoryModel)->add("Page [presentation] visitée", getUserIP());
        
        $this->view("home/presentation", [
            "title" => APP_NAME
        ]);
    }    

    public function phds() : void {
        (new HistoryModel)->add("Page [phds] visitée", getUserIP());
        
        $this->view("home/phds", [
            "title" => APP_NAME
        ]);
    }

    public function projects() : void {
        (new HistoryModel)->add("Page [projects] visitée", getUserIP());
        
        $this->view("home/projects", [
            "title" => APP_NAME
        ]);
    }

    public function publications() : void {
        (new HistoryModel)->add("Page [publications] visitée", getUserIP());
        
        $this->view("home/publications", [
            "title" => APP_NAME
        ]);
    }

    public function rdv() : void {
        (new HistoryModel)->add("Page [rdv] visitée", getUserIP());
        
        $this->view("home/rdv", [
            "title" => APP_NAME
        ]);
    }

    public function request_login() : void {
        (new HistoryModel)->add("Page [request_login] visitée", getUserIP());
        
        $this->view("home/request_login", [
            "title" => APP_NAME
        ]);
    }

    public function request_signup() : void {
        (new HistoryModel)->add("Page [request_signup] visitée", getUserIP());
        
        $this->view("home/request_signup", [
            "title" => APP_NAME
        ]);
    }

    public function researchers() : void {
        (new HistoryModel)->add("Page [researchers] visitée", getUserIP());
        
        $this->view("home/researchers", [
            "title" => APP_NAME
        ]);
    }

    public function search() : void {
        (new HistoryModel)->add("Page [search] visitée", getUserIP());
        
        $this->view("home/search", [
            "title" => APP_NAME
        ]);
    }

    public function signup() : void {
        (new HistoryModel)->add("Page [signup] visitée", getUserIP());
        
        $this->view("home/signup", [
            "title" => APP_NAME
        ]);
    }

    public function signup_welcome() {
        (new HistoryModel)->add("Page [signup_welcome] visitée", getUserIP());
        
        $this->view("home/signup_welcome", [
            "title" => APP_NAME
        ]);
    }

    public function ueh() : void {
        (new HistoryModel)->add("Page [ueh] visitée", getUserIP());
        
        $this->view("home/ueh", [
            "title" => APP_NAME
        ]);
    }

    public function venir() : void {
        (new HistoryModel)->add("Page [venir] visitée", getUserIP());
        
        $this->view("home/venir", [
            "title" => APP_NAME
        ]);
    }
}