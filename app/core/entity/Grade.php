<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Grade : int {
    case L0      = 1;
    case L1      = 2;
    case L2      = 3;
    case L3      = 4;
    case M1      = 5;
    case M2      = 6;
    case PHD     = 7;
    case UNKNOWN = 0;

    static public function get(int $id) : Grade {
        return Grade::tryFrom($id) ?? Grade::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("grades")->get($this->value);
        if($single == null) return "Inconnu";
        
        return $single->getContent();
    }
}