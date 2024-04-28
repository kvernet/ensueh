<?php

namespace app\core\entity;

class Single {

    public function __construct(private $id=null,
        private $name=null, private $deleted=null) {
    }

    public function getAsOption() : string {
        if($this->id == null) return null;
        return '<option value="'. $this->getId() .'">'. $this->getName() .'</option>';
    }

    public function isNull() : bool { return $this->id == null; }
    public function getId() : int { return $this->id; }
    public function getName() : string { return $this->name; }
    public function getDeleted() : bool { return $this->deleted; }
}