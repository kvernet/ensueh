<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum WhoIam : int {
    case STUDENT   = 1;
    case PROFESSOR = 2;
    case UNKNOWN   = 0;

    static public function get(int $id) : WhoIam {
        return WhoIam::tryFrom($id) ?? WhoIam::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("whoiam")->get($this->value);
        if($single == null) return "Inconnu";
        
        return $single->getName();
    }
}