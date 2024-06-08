<?php

namespace app\core\controller;

use app\core\entity\WhoAmI;

class AdmController extends UserController {
    
    public function __construct() {
        $this->setDir("adm/");
        $this->setTitle(APP_NAME . " - ADM");
        $this->setWhoAmI(WhoAmI::ADM);
    }

    public function generate_transcript() {
        $this->goCheck($this->dir . "generate_transcript");
    }

    public function get_users_as_table() {
        $this->goCheck($this->dir . "get_users_as_table");
    }

    public function students() : void {
        $this->goCheck($this->dir . "students");
    }

    public function professors() : void {
        $this->goCheck($this->dir . "professors");
    }
}