<?php

namespace app\core\entity;

class Single {

    public function __construct(private $id=null,
        private $content=null, private $deleted=null) {
    }

    public function getAsOption() : string {
        if($this->id == null) return null;
        return '<option value="'. $this->getId() .'">'. $this->getContent() .'</option>';
    }

    public function isNull() : bool { return $this->id == null; }
    public function getId() : int { return $this->id; }
    public function getContent() : string { return $this->content; }
    public function getDeleted() : bool { return $this->deleted; }
}