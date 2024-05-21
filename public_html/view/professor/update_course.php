<?php

use app\core\controller\ProfessorController;
use app\core\entity\Course;
use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;

if($_POST) {
    $course = new Course(
        $_POST['id'],
        $_POST['title'],
        $_POST['description'],
        Section::get($_POST['section']),
        Grade::get($_POST['grade']),
        $_POST['file_path_0'],
        ProfessorController::getUserName(),
        new DateTime(),
        0
    );
    
    $message = $course->update(
        $_FILES['file_path'],
        ProfessorController::getUserName()
    );

    if($message == Message::SUCCESS_MSG) {
        redirectMe($_POST['return_page']);
    }else {
        redirectMe($_POST['return_page'] . '?msg_id=' . $message->value);
    }
}