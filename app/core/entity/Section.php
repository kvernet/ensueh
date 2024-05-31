<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Section : int {
    case PHYSICS    = 1;
    case MATH       = 2;
    case PHYLOSOPHY = 3;
    case NATURAL_SCIENCES = 4;
    case MODERN_LANGUAGES = 5;
    case LIVING_LANGUAGES = 6;
    case HISTORY_GEOGRAPHY = 7;
    case UNKNOWN    = 0;

    static public function get(int $id) : Section {
        return Section::tryFrom($id) ?? Section::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("sections")->get($this->value);
        if($single == null) return "Message inconnu";
        
        return $single->getContent();
    }
}