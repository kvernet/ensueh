<?php

namespace app\core\entity;

class Footer {

    public function __construct(
        private $js_links=[
            BOOSTRAP_JS,
            FONT_AWESOME
        ]) {
    }

    public function setJSLinks(array $links) : Footer {
        $this->js_links = $links;
        return $this;
    }

    public function show() : void {
        echo '<div class="container">'
        . '<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">'
        . '<div class="col-md-4 d-flex align-items-center">'
        . '<span class="mb-3 mb-md-0 text-muted">&copy; ' . APP_FULL_NAME . '</span>'
        . '</div>'
        . '<ul class="nav col-md-4 justify-content-end list-unstyled d-flex">'
        . '<li class="ms-3"><a class="text-muted" href="https://www.linkedin.com/in/ensueh" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>'
        . '<li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-facebook"></i></a></li>'
        . '<li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-x-twitter"></i></a></li>'
        . '<li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-instagram"></i></a></li>'
        . '</ul>'
        . '</footer>'
        . '</div>';
        
        $jlinks = "";
        foreach($this->js_links as $link) {
            $jlinks .= $link;
        }
        echo $jlinks;
        echo '</body>';
        echo '</html>';
    }
}