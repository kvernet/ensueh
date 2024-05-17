<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Gender : int {
    case MALE    = 1;
    case FEMALE  = 2;
    case UNKNOWN = 0;

    static public function get(int $id) : Gender {
        return Gender::tryFrom($id) ?? Gender::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("genders")->get($this->value);
        if($single == null) return "Inconnu";
        
        return $single->getContent();
    }
}