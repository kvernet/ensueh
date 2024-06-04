<?php

namespace app\core\controller;

use app\core\entity\WhoAmI;

class ProfessorController extends UserController {
    
    public function __construct() {
        $this->setDir("professor/");
        $this->setTitle(APP_NAME . " - Professeur");
        $this->setWhoAmI(WhoAmI::PROFESSOR);
    }

    public function add_course() {
        $this->goCheck($this->dir . "add_course");
    }

    public function calendar() {
        $this->goCheck($this->dir . "calendar");
    }

    public function courses() {
        $this->goCheck($this->dir . "courses");
    }

    public function get_courses_as_table() {
        $this->goCheck($this->dir . "get_courses_as_table");
    }

    public function notes() {
        $this->goCheck($this->dir . "notes");
    }

    public function profile() {
        $this->goCheck($this->dir . "profile");
    }

    public function profile_update() {
        $this->goCheck($this->dir . "profile_update");
    }

    public function projects() {
        $this->goCheck($this->dir . "projects");
    }

    public function publications() {
        $this->goCheck($this->dir . "publications");
    }

    public function update_course() {
        $this->goCheck($this->dir . "update_course");
    }
}