<?php

namespace app\core\entity;

use app\core\model\SingleModel;
use app\core\model\SubjectModel;
use app\core\model\UserModel;
use DateTime;

class Subject {

    public function __construct(
        private int $id,
        private string $name,
        private Section $section,
        private Grade $grade,
        private string $user_name,
        private float $max_note,
        private float $coef,
        private DateTime $date,
        private bool $deleted
    ) {
        
    }

    public function getId() : int { return $this->id; }
    public function getName() : string { return $this->name; }
    public function getSection() : Section { return $this->section; }
    public function getGrade() : Grade { return $this->grade; }
    public function getUserName() : string { return $this->user_name; }
    public function getMaxNote() : float { return $this->max_note; }
    public function getCoef() : float { return $this->coef; }
    public function getDate() : DateTime { return $this->date; }
    public function getDeleted() : bool { return $this->deleted; }

    public function save() : Message {
        return (new SubjectModel)->add($this);
    }

    static public function addModal(string $return_page="subjects", string $action="add_subject", string $text="Ajouter un cours") : string {
        $target = "modal_add_subject";
        $singleModel = new SingleModel;
    
        return '<a class="btn btn-success" href="#" data-bs-toggle="modal" data-bs-target="#'.$target.'" data-bs-whatever="@mdo" onclick="return false;">'. $text .'</a>'
        .'<div class="modal fade" id="'.$target.'" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">'
        .'<div class="modal-dialog">'
        .'<div class="modal-content">'
        .'<div class="modal-header">'
        .'<h1 class="modal-title fs-5" id="addModalLabel">Ajouter un cours</h1>'
        .'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
        .'</div>'
        .'<div class="modal-body">'
        .'<form action="'. $action .'" method="post" enctype="multipart/form-data">'
    
        .'<div class="mb-3">'
        .'<input type="text" class="form-control" id="return_page" name="return_page" value="'. $return_page .'" hidden>'
        .'</div>'
    
        .'<div class="mb-3">'
        .'<label for="user_name" class="col-form-label">Professeur:</label>'
        .'<select class="form-control" id="user_name" name="user_name">'
        .(new UserModel)->getUsersAsOptions(WhoAmI::PROFESSOR)
        ."</select>"
        .'</div>'
    
        .'<div class="mb-3">'
        .'<label for="name" class="col-form-label">Titre du cours:</label>'
        .'<input type="text" class="form-control" id="name" name="name">'
        .'</div>'
    
        .'<div class="mb-3">'
        .'<label for="section" class="col-form-label">Section:</label>'
        .'<select class="form-control" id="section" name="section">'
        .$singleModel->setTable("sections")->getAllAsOptions()
        ."</select>"
        .'</div>'
    
        .'<div class="mb-3">'
        .'<label for="grade" class="col-form-label">Niveau:</label>'
        .'<select class="form-control" id="grade" name="grade">'
        .$singleModel->setTable("grades")->getAllAsOptions()
        ."</select>"
        .'</div>'
    
        .'<div class="mb-3">'
        .'<label for="max_note" class="col-form-label">Note max:</label>'
        .'<input type="number" class="form-control" id="max_note" name="max_note">'
        .'</div>'
    
        .'<div class="mb-3">'
        .'<label for="coef" class="col-form-label">Coef:</label>'
        .'<input type="number" class="form-control" id="coef" name="coef">'
        .'</div>'
    
        .'<div class="modal-footer">'
        .'<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>'
        .'<button type="submit" class="btn btn-primary">Enregistrer</button>'
        .'</div>'
        .'</form>'
        .'</div>'
        .'</div>'
        .'</div>'
        .'</div>';
    }
}