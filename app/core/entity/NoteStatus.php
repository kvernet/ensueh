<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum NoteStatus : int {
    case ADDED     = 1;
    case MODIFIED  = 2;
    case CONFIRMED = 3;
    case VALIDATED = 4;
    case UNKNOWN   = 0;

    static public function get(int $id) : self {
        return self::tryFrom($id) ?? self::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("notes_status")->get($this->value);
        if($single == null) return "Inconnu";
        
        return $single->getContent();
    }
}