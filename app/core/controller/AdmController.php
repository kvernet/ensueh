<?php

namespace app\core\controller;

use app\core\entity\WhoAmI;

class AdmController extends UserController {
    
    public function __construct() {
        $this->setDir("adm/");
        $this->setTitle(APP_NAME . " - ADM");
        $this->setWhoAmI(WhoAmI::ADM);
    }
}