<?php

namespace app\core\controller;

use app\core\entity\WhoAmI;

class StudentController extends UserController {
    
    public function __construct() {
        $this->setDir("student/");
        $this->setTitle(APP_NAME . " - Etudiant");
        $this->setWhoAmI(WhoAmI::STUDENT);
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
}