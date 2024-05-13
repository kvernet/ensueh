<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Department : int {
    case Ouest      = 1;
    case SudEst     = 2;
    case Nord       = 3;
    case NordEst    = 4;
    case Artibonite = 5;
    case Centre     = 6;
    case Sud        = 7;
    case GrandAnse  = 8;
    case NordOuest  = 9;
    case Nippes     = 10;
    case UNKNOWN    = 0;

    static public function get(int $id) : Department {
        return Department::tryFrom($id) ?? Department::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("departments")->get($this->value);
        if($single == null) return "Inconnu";
        
        return $single->getName();
    }
}