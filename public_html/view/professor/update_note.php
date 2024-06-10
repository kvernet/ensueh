<?php

use app\core\entity\Message;
use app\core\entity\Note;
use app\core\entity\NoteStatus;
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

    $noteModel = new NoteModel;

    $note = $noteModel->getNoteById($id);
    if($note) {
        // update note
        $note->setNote($value);
        $response['msg'] = "Note mise à jour avec succès.";
    } else {
        // create note
        $note = new Note(
            $id, $subject_id, $user_name,
            $value, $session_id,
            NoteStatus::UNKNOWN->value,
            new DateTime()
        );
        $response['msg'] = "Note ajoutée avec succès.";
    }

    $msg = $noteModel->addOrUpdate($note);

    if($msg != "SUCCESS") {
        $response['msg'] = $msg;
    }
}

echo json_encode($response);