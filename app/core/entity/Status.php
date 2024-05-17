<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Status: int {
    case REQUESTED    = 1;
    case VALIDATED    = 2;
    case CONNECTED    = 3;
    case DISCONNECTED = 4;
    case ACTIVE       = 5;
    case INACTIVE     = 6;
    case ONLINE       = 7;
    case OFFLINE      = 8;
    case SUSPENDED    = 9;
    case UNKNOWN      = 0;

    static public function get($value) : Status {
        return Status::tryFrom($value) ?? Status::UNKNOWN;
    }

    public function toText() : string {
        $single = (new SingleModel)->setTable("statuses")->get($this->value);
        if($single == null) return "Message inconnu";
        
        return $single->getContent();
    }

    static public function getCaseErrorMsg(Status $status) : string {
        return match($status) {
            Status::REQUESTED => Message::getMessage(Message::ADM_STATUS_REQUESTED_MSG),
            Status::CONNECTED => Message::getMessage(Message::ADM_STATUS_CONNECTED_MSG),
            Status::DISCONNECTED => Message::getMessage(Message::ACCESS_DENIED_MSG),
            Status::INACTIVE => Message::getMessage(Message::ADM_STATUS_INACTIVE_MSG),
            Status::SUSPENDED => Message::getMessage(Message::ADM_STATUS_SUSPENDED_MSG),
            Status::UNKNOWN => Message::getMessage(Message::ACCESS_DENIED_MSG),
            Default => ""
        };
    }
}