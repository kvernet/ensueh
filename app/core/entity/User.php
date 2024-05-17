<?php

namespace app\core\entity;

use app\core\model\UserModel;
use DateTime;

class User {

    public function __construct(
        private int $id,
        private string $first_name, private string $last_name,
        private Gender $gender, private string $email, private string $phone, 
        private Department $department, private WhoIam $whoiam,
        private Section $section, private Grade $grade,
        private string $user_name, private string $pwd,
        private DateTime $date_ins, private string|null $uniqid,
        private Status $status, private DateTime $last_activity) {
    }

    public function getId() : int { return $this->id; }
    public function getFirstName() : string { return $this->first_name; }
    public function getLastName() : string { return $this->last_name; }
    public function getGender() : Gender { return $this->gender; }
    public function getEmail() : string { return $this->email; }
    public function getPhone() : string { return "" . $this->phone; }
    public function getDepartment() : Department { return $this->department; }
    public function getWhoIam() : WhoIam { return $this->whoiam; }
    public function getSection() : Section { return $this->section; }
    public function getGrade() : Grade { return $this->grade; }
    public function getUserName() : string { return $this->user_name; }
    public function getPwd() : string { return $this->pwd; }
    public function getDateIns() : DateTime { return $this->date_ins; }
    public function getUniqId() : string { return $this->uniqid; }
    public function getStatus() : Status { return $this->status; }
    public function setStatus(Status $status) : void { $this->status = $status; }
    public function getLastActivity() : DateTime { return $this->last_activity; }

    static public function getModal(int $id, string $text="Modifier") : string {
        $user = (new UserModel)->getById($id);
        $target = "modal_update_user_" . $id;
        return '<a href="#" data-bs-toggle="modal" data-bs-target="#'.$target.'" data-bs-whatever="@mdo">'. $text .'</a>'
        .'<div class="modal fade" id="'.$target.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">'
        .'<div class="modal-dialog">'
        .'<div class="modal-content">'
        .'<div class="modal-header">'
        .'<h1 class="modal-title fs-5" id="exampleModalLabel">Modification étudiant</h1>'
        .'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
        .'</div>'
        .'<div class="modal-body">'
        .'<form>'
        .'<div class="mb-3">'
        .'<label for="first_name" class="col-form-label">Prénom:</label>'
        .'<input type="text" class="form-control" id="first_name" value="'. $user->getFirstName() .'">'
        .'</div>'
        .'<div class="mb-3">'
        .'<label for="first_name" class="col-form-label">Nom:</label>'
        .'<input type="text" class="form-control" id="first_name" value="'. $user->getLastName() .'">'
        .'</div>'
        .'<div class="mb-3">'
        .'<label for="first_name" class="col-form-label">Email:</label>'
        .'<input type="text" class="form-control" id="first_name" value="'. $user->getEmail() .'">'
        .'</div>'
        .'<div class="mb-3">'
        .'<label for="first_name" class="col-form-label">Téléphone:</label>'
        .'<input type="text" class="form-control" id="first_name" value="'. $user->getPhone() .'">'
        .'</div>'
        .'</form>'
        .'</div>'
        .'<div class="modal-footer">'
        .'<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>'
        .'<button type="button" class="btn btn-primary">Enregistrer</button>'
        .'</div>'
        .'</div>'
        .'</div>'
        .'</div>';
    }
}