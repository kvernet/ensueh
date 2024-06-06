<?php

use app\core\entity\Message;
use app\core\entity\Note;
use app\core\model\NoteModel;

$response = [
    "success" => false,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "content" => ""
];

if($_POST) {
    $id = $_POST['id'];
    $subject_id = $_POST['subject_id'];
    $user_name = $_POST['user_name'];
    $value = floatval( $_POST['note'] );
    $session_id = $_POST['session_id'];

    $note = new Note(
        $id, $subject_id, $user_name,
        $value, $session_id, false, false,
        new DateTime()
    );

    $msg = (new NoteModel)->addOrUpdate($note);

    $response['success'] = $msg == "SUCCESS";
    $response['msg'] = $msg;
}

echo json_encode($response);