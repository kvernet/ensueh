<?php

namespace app\core\entity;

use DateTime;

class Subject {

    public function __construct(
        private int $id,
        private string $name,
        private Section $section,
        private Grade $grade,
        private string $user_name,
        private float $max_note,
        private float $coef,
        private DateTime $date,
        private bool $deleted
    ) {
        
    }

    public function getId() : int { return $this->id; }
    public function getName() : string { return $this->name; }
    public function getSection() : Section { return $this->section; }
    public function getGrade() : Grade { return $this->grade; }
    public function getUserName() : string { return $this->user_name; }
    public function getMaxNote() : float { return $this->max_note; }
    public function getCoef() : float { return $this->coef; }
    public function getDate() : DateTime { return $this->date; }
    public function getDeleted() : bool { return $this->deleted; }
}