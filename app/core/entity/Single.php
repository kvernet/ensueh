<?php

namespace app\core\entity;

class Single {

    public function __construct(private int $id,
        private string $content, private bool $deleted=false) {
    }

    public function getAsOption(bool $isSelected=false) : string|null {
        if($this->id == null) return null;
        if($isSelected) {
            return '<option value="'. $this->getId() .'" selected>'. $this->getContent() .'</option>';
        }
        return '<option value="'. $this->getId() .'">'. $this->getContent() .'</option>';
    }

    public function getId() : int { return $this->id; }
    public function getContent() : string { return $this->content; }
    public function getDeleted() : bool { return $this->deleted; }
}