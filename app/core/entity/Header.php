<?php

namespace app\core\entity;

class Header {
    
    public function __construct(private $title=APP_NAME,
        private $css_links=[
            BOOTSTRAP_CSS,
            '<link rel="stylesheet" href="../../css/style.css">'
        ]){
    }

    public function setTitle(string $title) : Header {
        $this->title = $title;
        return $this;
    }

    public function setCSSLinks(array $links) : Header {
        $this->css_links = $links;
        return $this;
    }

    public function show() : void {
        $clinks = "";
        foreach($this->css_links as $link) {
            $clinks .= $link;
        }
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link rel="shortcut icon" type="image/x-icon" href="../../img/ensueh-logo.webp"/>';
        echo '<title>'. $this->title .'</title>';
        echo $clinks;
        echo '</head>';
        echo '<body class="container-fluid bg-light">';
    }
}