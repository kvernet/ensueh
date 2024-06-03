<?php

namespace app\core\entity;

use DateTime;

class Profile {

    public function __construct(
        private int $id,
        private string $user_name,
        private string $first_name,
        private string $last_name,
        private string $photo_path,
        private string $description,
        private DateTime $date,
        private bool $deleted
    ) {

    }

    public function getId() : int { return $this->id; }
    public function getUserName() : string { return $this->user_name; }
    public function getFirstName() : string { return $this->first_name; }
    public function getLastName() : string { return $this->last_name; }
    public function getFullName() : string { return $this->getFirstName() . " " . $this->getLastName(); }
    public function getPhotoPath() : string { return $this->photo_path; }
    public function getDescription() : string { return $this->description; }
    public function getDate() : DateTime { return $this->date; }
    public function getDeleted() : bool { return $this->deleted; }
}