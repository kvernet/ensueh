<?php

namespace app\core\entity;

class Form {

    public function __construct(
        private string $content=""
    ) {
    }

    public function add(string $formated_tag) : Form {
        $this->content .= $formated_tag;
        return $this;
    }

    public function show() : void {
        echo $this->content;
    }
}