<?php

use app\core\controller\ProfessorController;
use app\core\entity\Grade;
use app\core\model\SubjectModel;

$result = "";

if($_POST) {
    $user_name = ProfessorController::getUserName();
    $grade_id = $_POST['grade_id'];

    $subjects = (new SubjectModel)->getSubjects($user_name, Grade::get($grade_id));

    foreach($subjects as $subject) {
        $result .= '<option value="'. $subject->getId() .'">'. $subject->getName() .'</option>';
    }
}


echo $result;