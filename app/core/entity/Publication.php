<?php

namespace app\core\entity;

use DateTime;

class Publication {

    public function __construct(
        private int $id,
        private string $user_name,
        private string $name,
        private string $doi,
        private DateTime $date,
        private bool $deleted
    ) {

    }

    public function getId() : int { return $this->id; }
    public function getUserName() : string { return $this->user_name; }
    public function getName() : string { return $this->name; }
    public function getDOI() : string { return $this->doi; }
    public function getDate() : DateTime { return $this->date; }
    public function getDeleted() : bool { return $this->deleted; }
}