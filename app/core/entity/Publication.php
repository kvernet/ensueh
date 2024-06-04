<?php

namespace app\core\entity;

use DateTime;

class Publication {

    public function __construct(
        private int $id,
        private string $user_name,
        private string $name,
        private string $doi,
        private string $published_year,
        private DateTime $date,
        private bool $deleted
    ) {

    }

    public function getId() : int { return $this->id; }
    public function getUserName() : string { return $this->user_name; }
    public function getName() : string { return $this->name; }
    public function getDOI() : string { return $this->doi; }
    public function getPublishedDate() : string { return $this->published_year; }
    public function getDate() : DateTime { return $this->date; }
    public function getDeleted() : bool { return $this->deleted; }

    function toString() : string {
        $doi = $this->getDOI();
        
        return '<div class="row">'
        . '<div class="col">'
        . $this->getName()
        . '</div>'
        . '</div>'
        . '<div class="row">'
        . '<div class="col">'
        . '<a href="'. $doi .'" target="_blank">'. $doi .'</a>'
        . '</div>'
        . '</div>'
        . '<hr class="lead">';
    }
}