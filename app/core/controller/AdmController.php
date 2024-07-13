<?php

namespace app\core\controller;

use app\core\entity\WhoAmI;

class AdmController extends UserController {
    
    public function __construct() {
        $this->setDir("adm/");
        $this->setTitle(APP_NAME . " - ADM");
        $this->setWhoAmI(WhoAmI::ADM);
    }

    public function add_subject() : void {
        $this->goCheck($this->dir . "add_subject");
    }

    public function get_notes_as_table() {
        $this->goCheck($this->dir . "get_notes_as_table");
    }

    public function get_subjects() {
        $this->goCheck($this->dir . "get_subjects");
    }

    public function get_subjects_as_table() {
        $this->goCheck($this->dir . "get_subjects_as_table");
    }

    public function get_users_as_table() {
        $this->goCheck($this->dir . "get_users_as_table");
    }

    public function generate_transcript() {
        $this->goCheck($this->dir . "generate_transcript");
    }

    public function notes() {
        $this->goCheck($this->dir . "notes");
    }

    public function professors() : void {
        $this->goCheck($this->dir . "professors");
    }

    public function request_signup() : void {
        $this->goCheck($this->dir . "request_signup");
    }

    public function signup() : void {
        $this->goCheck($this->dir . "signup");
    }

    public function students() : void {
        $this->goCheck($this->dir . "students");
    }

    public function subjects() : void {
        $this->goCheck($this->dir . "subjects");
    }

    public function undo_note() {
        $this->goCheck($this->dir . "undo_note");
    }

    public function update_subject() : void {
        $this->goCheck($this->dir . "update_subject");
    }

    public function validate_note() {
        $this->goCheck($this->dir . "validate_note");
    }

    public function welcome_signup() : void {
        $this->goCheck($this->dir . "welcome_signup");
    }
}