<?php

namespace app\core\controller;

class PrivateController extends Controller {

    public function init_db() {
        $this->view("private/init_db");
    }

    public function signup() {
        $this->view("private/signup");
    }

    public function request_signup() {
        $this->view("private/request_signup");
    }

    public function welcome_signup() {
        $this->view("private/welcome_signup");
    }
}