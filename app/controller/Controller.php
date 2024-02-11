<?php

namespace app\controller;

class Controller {

    protected function view($page, $params=null) {
        require_once($page);
    }
}