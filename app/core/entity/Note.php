<?php

namespace app\core\entity;

use DateTime;

class Note {

    public function __construct(
        private int $id,
        private int $subject_id,
        private string $user_name,
        private float $note,
        private int $session_id,
        private int $status_id,
        private DateTime $date
    ) {

    }

    public function getId() : int { return $this->id; }
    public function getSubjectId() : int { return $this->subject_id; }
    public function getUserName() : string { return $this->user_name; }
    public function getNote() : float { return $this->note; }
    public function setNote(float $note) : void { $this->note = $note; }
    public function getSessionId() : int { return $this->session_id; }
    public function getStatusId() : int { return $this->status_id; }
    public function getDate() : DateTime { return $this->date; }
}