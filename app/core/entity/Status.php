<?php

namespace app\core\entity;

enum Status: string {
    case REQUESTED = 'requested';
    case VALIDATED = 'validated';
    case CONNECTED = 'connected';
    case DISCONNECTED = 'disconnected';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case SUSPENDED = 'suspended';
    case UNKNOWN = 'unknown';

    static public function get($value) : Status {
        return Status::tryFrom($value) ?? Status::UNKNOWN;
    }

    static public function getCaseErrorMsg(Status $status) : string {
        return match($status) {
            Status::REQUESTED => ADM_STATUS_REQUESTED_MSG,
            Status::CONNECTED => ADM_STATUS_CONNECTED_MSG,
            Status::DISCONNECTED => ACCESS_DENIED_MSG,
            Status::INACTIVE => ADM_STATUS_INACTIVE_MSG,
            Status::SUSPENDED => ADM_STATUS_SUSPENDED_MSG,
            Status::UNKNOWN => ACCESS_DENIED_MSG,
            Default => ""
        };
    }
}