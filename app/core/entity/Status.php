<?php

namespace app\core\entity;

enum Status: string {
    case ACTIVE = 'active';         // someone that inscription has been already confirmed
    case INACTIVE = 'inactive';     // someone that is just loged in (waiting for confirmation)
    case OFFLINE = 'offline';       // someone that is connected but does not interact with the website
    case ONLINE = 'online';         // someone that is connected and interacts with the website
    case CONNECTED = 'connected';   // someone that is already connected on another browser
    case SUSPENDED = 'suspended';   // someone's account that is suspended
    case UNKNOWN = 'unknown';       // someone whose account has an unknown status

    case REQUESTED = 'requested';

    static public function get($value) : Status {
        return Status::tryFrom($value) ?? Status::UNKNOWN;
    }

    static public function getCaseErrorMsg(Status $status) : string {
        return match($status) {
            Status::INACTIVE => ADM_STATUS_INACTIVE_MSG,
            Status::SUSPENDED => ADM_STATUS_SUSPENDED_MSG,
            Status::ONLINE => ADM_STATUS_CONNECTED_MSG,
            Status::SUSPENDED => ADM_STATUS_SUSPENDED_MSG,
            Status::UNKNOWN => ADM_STATUS_UNKNOWN_MSG,
            Default => "OK"
        };
    }
}