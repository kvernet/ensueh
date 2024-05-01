<?php

namespace app\core\entity;

class Navbar {

    public function __construct(private string $content="",
        private string $fsearch="") {        
    }

    // $text : the text to be displayed in the link
    // $link : the link to go through when clicking
    // $class : the table that contains all the classes to design the element
    // $attributes : the associative table that contains all other attributes. Example aria-current="page"
    public function addLi(string $text, string $link,
            array $class=[], array $attributes=[]) : Navbar {
        $this->content .= '<li class="nav-item">';
        $a = '<a class="nav-link';
        foreach($class as $cls) {
            $a .= ' ' . $cls;
        }
        $a .= '"';
        foreach($attributes as $key => $value) {
            $a .= ' ' . $key . '="'. $value .'"';
        }
        $a .= ' href="'. $link .'">';
        $a .= $text . '</a>';

        $this->content .= $a;
        $this->content .= '</li>';

        return $this;
    }

    // $text : the text to be displayed in the dropdown
    // $links : the associative table that contains links' details. Example $links=[["href" => "../home", "text" => "Home"]]
    // $dividerAt : the index to include a divider, default id -1 means no divider should be included
    public function addLiDropdown(string $text, array $links, $dividerAt=-1) : Navbar {
        $this->content .= '<li class="nav-item dropdown">'.
        '<a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.
        $text.
        '</a>'.
        '<ul class="dropdown-menu">';
        for($i = 0; $i < count($links); $i++) {
            $this->content .= '<li><a class="dropdown-item" href="'. $links[$i]["href"] .'">'. $links[$i]["text"] .'</a></li>';
            if($dividerAt == $i) {
                $this->content .= '<li><hr class="dropdown-divider"></li>';
            }
        }
        $this->content .= '</ul>'.
        '</li>';

        return $this;
    }

    // $link : the link to go through for researching the phrase
    public function addSearch(string $link="") : Navbar {
        $this->fsearch .= '<form class="d-flex" role="search" action="'. $link .'">'.
        '<input class="form-control me-2" type="search" name="p" placeholder="Mot(s)" aria-label="Search">'.
        '<button class="btn btn-outline-success" type="submit">Rechercher</button>'.
        '</form>';
        return $this;
    }

    public function show(string $text=APP_NAME) {
        echo '<nav class="navbar navbar-expand-lg bg-body-tertiary">';
        echo '<div class="container-fluid">';
        echo '<a class="navbar-brand" href="">'. $text .'</a>';
        echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
        echo '<span class="navbar-toggler-icon"></span>';
        echo '</button>';

        echo '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
        echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">';

        echo $this->content;

        echo '</ul>';

        echo $this->fsearch;

        echo '</div>';
        echo '</div>';
        echo '</nav>';
    }
}