<?php

use app\core\controller\ProfessorController;
use app\core\entity\Grade;
use app\core\model\SubjectModel;

$result = "";

if($_POST) {
    $user_name = ProfessorController::getUserName();
    $grade = $_POST['grade'];

    $subjects = (new SubjectModel)->getSubjects($user_name, Grade::get($grade));

    foreach($subjects as $subject) {
        $result .= '<option value="'. $subject->getId() .'">'. $subject->getName() .'</option>';
    }
}


echo $result;