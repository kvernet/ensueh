<?php

namespace app\core\entity;

use DateTime;

class Note {

    public function __construct(
        private int $id,
        private Subject $subject,
        private string $user_name,
        private float $note,
        private Session $session,
        private bool $validated,
        private bool $deleted,
        private DateTime $date
    ) {

    }

    public function getId() : int { return $this->id; }
    public function getSubject() : Subject { return $this->subject; }
    public function getUserName() : string { return $this->user_name; }
    public function getNote() : float { return $this->note; }
    public function setNote(float $note) : void { $this->note = $note; }
    public function getSession() : Session { return $this->session; }
    public function getValidated() : bool { return $this->validated; }
    public function getDeleted() : bool { return $this->deleted; }
    public function getDate() : DateTime { return $this->date; }
}