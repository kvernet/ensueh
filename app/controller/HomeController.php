<?php

namespace app\controller;

class HomeController extends Controller {
    public function index() {
        $this->view(APP_DIR . "app/view/home/index.php");
    }

    public function direction() {
        $this->view(APP_DIR . "app/view/home/direction.php");
    }

    public function formations() {
        $this->view(APP_DIR . "app/view/home/formations.php");
    }

    public function departements() {
        $this->view(APP_DIR . "app/view/home/departements.php");
    }

    public function contact() {
        $this->view(APP_DIR . "app/view/home/contact.php");
    }

    public function connexion() {
        $this->view(APP_DIR . "app/view/home/connexion.php");
    }

    public function inscription() {
        $this->view(APP_DIR . "app/view/home/inscription.php");
    }

    public function ueh() {
        $this->view(APP_DIR . "app/view/home/ueh.php");
    }

    public function forums() {
        $this->view(APP_DIR . "app/view/home/forums.php");
    }

    public function concepteur() {
        $this->view(APP_DIR . "app/view/home/concepteur.php");
    }

    public function lactualites() {
        $this->view(APP_DIR . "app/view/home/lactualites.php");
    }

    public function laboratoires() {
        $this->view(APP_DIR . "app/view/home/laboratoires.php");
    }

    public function projets() {
        $this->view(APP_DIR . "app/view/home/projets.php");
    }

    public function doctorants() {
        $this->view(APP_DIR . "app/view/home/doctorants.php");
    }

    public function chercheurs() {
        $this->view(APP_DIR . "app/view/home/chercheurs.php");
    }

    public function publications() {
        $this->view(APP_DIR . "app/view/home/publications.php");
    }

    public function iactualites() {
        $this->view(APP_DIR . "app/view/home/iactualites.php");
    }

    public function coorperations() {
        $this->view(APP_DIR . "app/view/home/coorperations.php");
    }

    public function venir() {
        $this->view(APP_DIR . "app/view/home/venir.php");
    }

    public function accompagnements() {
        $this->view(APP_DIR . "app/view/home/accompagnements.php");
    }

    public function emplois() {
        $this->view(APP_DIR . "app/view/home/emplois.php");
    }

    public function rendezvous() {
        $this->view(APP_DIR . "app/view/home/rendezvous.php");
    }

    public function _404() {
        $this->view(APP_DIR . "app/view/error/_404.php");
        die();
    }
}