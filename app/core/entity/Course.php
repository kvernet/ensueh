<?php

namespace app\core\entity;

use app\core\model\CourseModel;
use app\core\model\SingleModel;
use DateTime;

class Course {

    public function __construct(
        private int $id,
        private string $title,
        private string $description,
        private Section $section,
        private Grade $grade,
        private string $file_path,
        private string $user_name,
        private DateTime $date_add,
        private bool $deleted) {        
    }

    public function getId() : int { return $this->id; }
    public function getTitle() : string { return $this->title; }
    public function getDescription() : string { return $this->description; }
    public function getSection() : Section { return $this->section; }
    public function getGrade() : Grade { return $this->grade; }
    public function getFilePath() : string { return $this->file_path; }
    public function getUserName() : string { return $this->user_name; }
    public function getDate() : DateTime { return $this->date_add; }
    public function getDeleted() : bool { return $this->deleted; }

    static public function getAddModal(string $return_page="", string $action="add_course", string $text="Ajouter") : string {
        $target = "modal_add_course";
        $singleModel = new SingleModel;

        return '<a href="#" data-bs-toggle="modal" data-bs-target="#'.$target.'" data-bs-whatever="@mdo">'. $text .'</a>'
        .'<div class="modal fade" id="'.$target.'" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">'
        .'<div class="modal-dialog">'
        .'<div class="modal-content">'
        .'<div class="modal-header">'
        .'<h1 class="modal-title fs-5" id="addModalLabel">Ajout d\'un cours</h1>'
        .'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
        .'</div>'
        .'<div class="modal-body">'
        .'<form action="'. $action .'" method="post" enctype="multipart/form-data">'

        .'<div class="mb-3">'
        .'<input type="text" class="form-control" id="return_page" name="return_page" value="'. $return_page .'" hidden>'
        .'</div>'

        .'<div class="mb-3">'
        .'<label for="title" class="col-form-label">Titre:</label>'
        .'<input type="text" class="form-control" id="title" name="title">'
        .'</div>'

        .'<div class="mb-3">'
        .'<label for="description" class="col-form-label">Description:</label>'
        .'<textarea type="text" class="form-control" id="description" name="description" rows="3"></textarea>'
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
        .'<label for="file_path" class="col-form-label">Fichier:</label>'
        .'<input type="file" accept="application/pdf" class="form-control" id="file_path" name="file_path">'
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

    static public function getUpdateModal(int $id, string $return_page="", string $action="update_course", string $text="Modifier") : string {
        $course = (new CourseModel)->getById($id);
        $target = "modal_update_course_" . $id;
        $singleModel = new SingleModel;

        return '<a href="#" data-bs-toggle="modal" data-bs-target="#'.$target.'" data-bs-whatever="@mdo">'. $text .'</a>'
        .'<div class="modal fade" id="'.$target.'" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">'
        .'<div class="modal-dialog">'
        .'<div class="modal-content">'
        .'<div class="modal-header">'
        .'<h1 class="modal-title fs-5" id="updateModalLabel">Modification du cours</h1>'
        .'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
        .'</div>'
        .'<div class="modal-body">'
        .'<form action="'. $action .'" method="post" enctype="multipart/form-data">'

        .'<div class="mb-3">'
        .'<input type="text" class="form-control" id="id" name="id" value="'. $course->getId() .'" hidden>'
        .'</div>'

        .'<div class="mb-3">'
        .'<input type="text" class="form-control" id="return_page" name="return_page" value="'. $return_page .'" hidden>'
        .'</div>'

        .'<div class="mb-3">'
        .'<label for="title" class="col-form-label">Titre:</label>'
        .'<input type="text" class="form-control" id="title" name="title" value="'. $course->getTitle() .'">'
        .'</div>'

        .'<div class="mb-3">'
        .'<label for="description" class="col-form-label">Description:</label>'
        .'<textarea type="text" class="form-control" id="description" name="description" rows=3>'. $course->getDescription() .'</textarea>'
        .'</div>'

        .'<div class="mb-3">'
        .'<label for="section" class="col-form-label">Section:</label>'
        .'<select class="form-control" id="section" name="section">'
        .$singleModel->setTable("sections")->getAllAsOptions($course->getSection()->value)
        ."</select>"
        .'</div>'

        .'<div class="mb-3">'
        .'<label for="grade" class="col-form-label">Niveau:</label>'
        .'<select class="form-control" id="grade" name="grade">'
        .$singleModel->setTable("grades")->getAllAsOptions($course->getGrade()->value)
        ."</select>"
        .'</div>'

        .'<div class="mb-3">'
        .'<input type="text" class="form-control" id="file_path_0" name="file_path_0" value="'. $course->getFilePath() .'" hidden>'
        .'</div>'

        .'<div class="mb-3">'
        .'<label for="file_path" class="col-form-label">Fichier:</label>'
        .'<input type="file" accept="application/pdf" class="form-control" id="file_path" name="file_path" value="'. $course->getFilePath() .'">'
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

    static public function getDisplayModal(int $id, string $action="", string $text="Visualiser") {
        $course = (new CourseModel)->getById($id);
        $target = "modal_display_course_" . $id;
        $file_path = getUploadedFilePath($course->getFilePath());

        return '<a href="#" data-bs-toggle="modal" data-bs-target="#'.$target.'" data-bs-whatever="@mdo">'. $text .'</a>'
        .'<div class="modal fade" id="'.$target.'" tabindex="-1" aria-labelledby="displayModalLabel" aria-hidden="true">'
        .'<div class="modal-dialog modal-dialog modal-fullscreen">'
        .'<div class="modal-content">'
        .'<div class="modal-header">'
        .'<h1 class="modal-title fs-5" id="displayModalLabel">Lecture du cours</h1>'
        .'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
        .'</div>'
        .'<div class="modal-body">'

        .'<form action="'. $action .'" method="post" enctype="multipart/form-data">'

        .'<div class="row">'
        .'<iframe width="100%" height="1500hv" scrolling="no" allowfullscreen webkitallowfullscreen src="'. $file_path .'"></iframe>'
        .'</div>'

        .'<div class="modal-footer">'
        .'<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>'
        .'</div>'
        .'</form>'
        .'</div>'
        .'</div>'
        .'</div>'
        .'</div>';
    }

    public function save(array $file_data, string $added_by) : Message {
        // filename
        $formated_date = (new DateTime)->format("Y_m_d_H_i_s");
        $file_name = $added_by . "_" . $formated_date;
        $file_name .= ".pdf";
        $message = uploadFile(
            $file_data, $file_name
        );
        if($message == Message::SUCCESS_MSG) {
            // update the course
            $this->file_path = $file_name;
            // save to database
            return (new CourseModel)->add($this);
        }
        return $message;
    }

    public function update(array $file_data, string $added_by) : Message {
        $message = Message::SUCCESS_MSG;

        // update file
        if($file_data['error'] == 0) {
            $message = uploadFile(
                $file_data, $this->getFilePath()
            );
        }
        
        if($message == Message::SUCCESS_MSG) {
            // save to database
            return (new CourseModel)->updateById($this);
        }
        return $message;
    }
}