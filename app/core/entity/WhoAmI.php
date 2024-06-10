<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum WhoAmI : int {
    case STUDENT   = 1;
    case PROFESSOR = 2;
    case SECRETARY = 3;
    case ADM       = 4;
    case UNKNOWN   = 0;

    static public function get(int $id) : WhoAmI {
        return WhoAmI::tryFrom($id) ?? WhoAmI::UNKNOWN;
    }

    public function getHome() : string {
        return match($this) {
            WhoAmI::STUDENT => "student/courses",
            WhoAmI::PROFESSOR => "professor/courses",
            WhoAmI::SECRETARY => "secretary/students",
            WhoAmI::ADM => "adm/students",
            Default => ""
        };
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("whoami")->get($this->value);
        if($single == null) return "Message inconnu";
        
        return $single->getContent();
    }
}