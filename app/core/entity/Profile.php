<?php

namespace app\core\entity;

use DateTime;

class Profile {

    public function __construct(
        private int $id,
        private string $user_name,
        private string $first_name,
        private string $last_name,
        private string $photo_path,
        private string $description,
        private string $attraction,
        private string $contact,
        private DateTime $date,
        private bool $deleted
    ) {

    }

    public function getId() : int { return $this->id; }
    public function getUserName() : string { return $this->user_name; }
    public function getFirstName() : string { return $this->first_name; }
    public function getLastName() : string { return $this->last_name; }
    public function getFullName() : string { return $this->getFirstName() . " " . $this->getLastName(); }
    public function getPhotoPath() : string { return $this->photo_path; }
    public function setPhotoPath(string $photo_path) : void { $this->photo_path = $photo_path; }
    public function getDescription() : string { return $this->description; }
    public function setDescription(string $description) : void { $this->description = $description; }
    public function getAttraction() : string { return $this->attraction; }
    public function setAttraction(string $attraction) : void { $this->attraction = $attraction; }
    public function getContact() : string { return $this->contact; }
    public function setContact(string $contact) : void { $this->contact = $contact; }
    public function getDate() : DateTime { return $this->date; }
    public function getDeleted() : bool { return $this->deleted; }

    public function show(string $title, string $textToGo, string $linkToGo, string $photoBaseDir="../../img/researchers/profiles/") : void {
        echo '<div class="row">'

        . '<div class="col-sm-2">'
        . '<div data-mdb-input-init class="form-outline">'
        . '<img class="form-control" name="" id="" src="' . $photoBaseDir . "/" . $this->getPhotoPath() .'">'
        . '</div>'
        . '</div>'

        . '<div class="col-sm-10">'
        . '<div data-mdb-input-init class="form-outline">'
        . '<p class="bold lead">'. $title .'</p>'
        . '<p class="text-justify">' . $this->getDescription()
        . '</p>'
        . '<p><a href="'. $linkToGo .'">'. $textToGo .'</a></p>'
        . '</div>'
        . '</div>'

        . '</div>';
    }

    public function showFull(string $dummy, string $photoBaseDir="../../img/researchers/profiles/") : void {
        echo '<div class="row">'

        . '<div class="col-sm-2">'
        . '<div data-mdb-input-init class="form-outline">'
        . '<img class="form-control" name="" id="" src="' . $photoBaseDir . "/" . $this->getPhotoPath() .'">'
        . '</div>'
        . '</div>'

        . '<div class="col-sm-10">'
        . '<div data-mdb-input-init class="form-outline">'
        . '<p class="bold lead">Mon profil</p>'
        . '<p class="text-justify">' . $this->getDescription()
        . '</p>'
        . '</div>'
        . '<div data-mdb-input-init class="form-outline">'
        . '<p class="bold lead">Mes centres d\'intérêt</p>'
        . '<p class="text-justify">' . $this->getAttraction()
        . '</p>'
        . '</div>'
        . '<div data-mdb-input-init class="form-outline">'
        . '<p class="bold lead">Mes contacts</p>'
        . '<p class="text-justify">' . $this->getContact()
        . '</p>'
        . $dummy
        . '</div>'
        . '</div>'

        . '</div>';
    }
}