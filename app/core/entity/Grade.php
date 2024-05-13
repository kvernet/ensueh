<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Grade : int {
    case LICENCE = 1;
    case MASTER  = 2;
    case PHD     = 3;
    case UNKNOWN = 0;

    static public function get(int $id) : Grade {
        return Grade::tryFrom($id) ?? Grade::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("grades")->get($this->value);
        if($single == null) return "Inconnu";
        
        return $single->getName();
    }
}