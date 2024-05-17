<?php

namespace app\core\entity;

use app\core\model\SingleModel;

enum Message : int {
    case ACCESS_DENIED_MSG = 1;
    case PAGE_NOT_EXISTS_MSG = 2;
    case EMAIL_EXIST_MESSAGE = 3;
    case PHONE_EXIST_MESSAGE = 4;
    case USERNAME_EXIST_MESSAGE = 5;
    case ADM_STATUS_REQUESTED_MSG = 6;
    case ADM_STATUS_CONNECTED_MSG = 7;
    case ADM_STATUS_INACTIVE_MSG = 8;
    case ADM_STATUS_SUSPENDED_MSG = 9;
    case ADM_NOT_EXISTS_MSG = 10;
    case UNKNOWN = 0;

    static public function get(int $value) : Message {
        return Message::tryFrom($value) ?? Message::UNKNOWN;
    }

    static public function getMessage(Message $msg) : string {
        $single = (new SingleModel)->setTable("messages")->get($msg->value);
        if($single == null) return "Message inconnu";
        
        return $single->getContent();
    }
}