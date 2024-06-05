<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Session : int {
    case T1      = 1;
    case T2      = 2;
    case T3      = 3;
    case UNKNOWN = 0;

    static public function get(int $id) : self {
        return self::tryFrom($id) ?? self::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("sessions")->get($this->value);
        if($single == null) return "Inconnu";
        
        return $single->getContent();
    }
}