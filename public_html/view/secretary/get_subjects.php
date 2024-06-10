<?php

use app\core\model\SubjectModel;

$result = "";

if($_POST) {
    $section_id = $_POST['section_id'];
    $grade_id = $_POST['grade_id'];

    $subjects = (new SubjectModel)->getSubjectsBySectionGrade($section_id, $grade_id);

    foreach($subjects as $subject) {
        $result .= '<option value="'. $subject->getId() .'">'. $subject->getName() .'</option>';
    }
}

echo $result;