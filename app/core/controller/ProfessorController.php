<?php

namespace app\core\controller;

use app\core\entity\WhoAmI;

class ProfessorController extends UserController {
    
    public function __construct() {
        $this->setDir("professor/");
        $this->setTitle(APP_NAME . " - Professeur");
        $this->setWhoAmI(WhoAmI::PROFESSOR);
    }

    public function calendar() {
        $this->goCheck($this->dir . "calendar");
    }

    public function courses() {
        $this->goCheck($this->dir . "courses");
    }

    public function notes() {
        $this->goCheck($this->dir . "notes");
    }

    public function projets() {
        $this->goCheck($this->dir . "projets");
    }
}