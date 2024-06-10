<?php

use app\core\entity\Grade;
use app\core\entity\Section;
use app\core\entity\WhoAmI;
use app\core\model\NoteModel;
use app\core\model\UserModel;

function getNotesAsTable(int $section_id, int $grade_id, int $subject_id, int $session_id, int $page, int $size, WhoAmI $whoAmI): void {
    $userModel = new UserModel;
    $noteModel = new NoteModel;

    $section = Section::get($section_id);
    $grade = Grade::get($grade_id);
    
    $data = [];

    // retrieve pagination parameters
    $offset = ($page - 1) * $size;

    // get total row count
    $total = $userModel->countBySectionAndGrade($section, $grade, $whoAmI);

    // get a limited number of users
    $users = $userModel->getBySectionAndGrade($section, $grade, $offset, $size, $whoAmI);

    $index = -1;
    foreach($users as $user) {
        $user_name = $user->getUserName();
        // get corresponding note
        $note = $noteModel->getNote($subject_id, $user_name, $session_id);
        $data[] = [
            "id" => $note ? $note->getId() : $index--,
            "user_name" => $user_name,
            "first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "note" => $note ? $note->getNote() : 0.0
        ];
    }

    $response = [
        "last_page" => ceil($total / $size),
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo (json_encode($response));
}

if($_POST) {
    $section_id = intval($_POST['section_id']);
    $grade_id = intval($_POST['grade_id']);
    $subject_id = intval($_POST['subject_id']);
    $session_id = intval($_POST['session_id']);
    // retrieve pagination parameters
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $size = isset($_POST['size']) ? intval($_POST['size']) : 10;

    getNotesAsTable($section_id, $grade_id, $subject_id, $session_id, $page, $size, WhoAmI::STUDENT);
}