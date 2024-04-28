<?php

namespace app\core\entity;
use DateTime;

class Adm {

    public function __construct(
        private $id=null, private $first_name=null, private $last_name=null,
        private $email=null, private $phone=null, private $gender_id=null,
        private $section_id=null, private $user_name=null, private $pwd=null,
        private $date_ins=null, private $connected=null, private $active=null) {
    }

    public function isNull() : bool { return $this->id == null; }
    
    public function getId() : int { return $this->id; }
    public function getFirstName() : string { return $this->first_name; }
    public function getLastName() : string { return $this->last_name; }
    public function getEmail() : string { return $this->email; }
    public function getPhone() : string { return $this->phone; }
    public function getGenderId() : int { return $this->gender_id; }
    public function getSectionId() : int { return $this->section_id; }
    public function getUserName() : string { return $this->user_name; }
    public function getPwd() : string { return $this->pwd; }
    public function getDateIns() : DateTime { return new DateTime($this->date_ins); }
    public function getConnected() : bool { return $this->connected; }
    public function getActive() : bool { return $this->active; }
}