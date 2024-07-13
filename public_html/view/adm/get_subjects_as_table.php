<?php

use app\core\model\SubjectModel;

function getSubjectssAsTable(string $user_name, int $page, int $size) : void {
    $data = [];

    $subjectModel = new SubjectModel;

    // retrieve pagination parameters
    $offset = ($page - 1) * $size;

    // get total row count
    $total = $subjectModel->countByUserName($user_name);

    // get a limited number of subjects
    $subjects = $subjectModel->getByUserName($user_name, $offset, $size);

    foreach($subjects as $subject) {
        $data[] = [
            "id" => $subject->getId(),
            "name" => $subject->getName(),
            "section" => $subject->getSection()->toText(),
            "grade" => $subject->getGrade()->toText(),
            "max_note" => $subject->getMaxNote(),
            "coef" => $subject->getCoef()
        ];
    }

    $response = [
        "last_page" => ceil($total / $size),
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo(json_encode($response));
}

if($_POST) {
    $user_name = $_POST['user_name'];
    // retrieve pagination parameters
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $size = isset($_POST['size']) ? intval($_POST['size']) : 10;

    getSubjectssAsTable($user_name, $page, $size);
}