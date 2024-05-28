<?php

namespace app\core\entity;

class Footer {

    public function __construct(
        private $js_links=[
            BOOSTRAP_JS,
            '<script src="../../js/script.js"></script>'
        ]) {
    }

    public function setJSLinks(array $links) : Footer {
        $this->js_links = $links;
        return $this;
    }

    public function show() : void {
        $jlinks = "";
        foreach($this->js_links as $link) {
            $jlinks .= $link;
        }
        echo $jlinks;
        echo '</body>';
        echo '</html>';
    }
}