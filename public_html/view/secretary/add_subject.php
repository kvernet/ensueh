<?php

use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;
use app\core\entity\Subject;

if($_POST) {
    $subject = new Subject(
        0,
        $_POST['name'],
        Section::get($_POST['section']),
        Grade::get($_POST['grade']),
        $_POST['user_name'],
        floatval($_POST['max_note']),
        floatval($_POST['coef']),
        new DateTime(),
        false
    );

    $message = $subject->save();

    if($message == Message::SUCCESS_MSG) {
        redirectMe($_POST['return_page']);
    }else {
        redirectMe($_POST['return_page'] . '?msg_id=' . $message->value);
    }
}