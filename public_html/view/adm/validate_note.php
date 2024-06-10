<?php

use app\core\entity\Message;
use app\core\entity\NoteStatus;
use app\core\model\NoteModel;

$response = [
    "success" => false,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "content" => ""
];

if($_POST) {
    $id = $_POST['id'];

    if($id > 0) {
        $noteModel = new NoteModel;
        $note = $noteModel->getNoteById($id);
        if($note) {
            $note_status = NoteStatus::get($note->getStatusId());
            if($note_status == NoteStatus::VALIDATED) {
                $response['msg'] = "Note déjà validée.";
            }
            elseif($note_status == NoteStatus::CONFIRMED) {
                $message = $noteModel->updateStatus($id, NoteStatus::VALIDATED);
                if($message == Message::SUCCESS_MSG) {
                    $response['msg'] = "Note validée avec succès.";
                }
            } else {
                $response['msg'] = "Désolé mais vous ne pouvez pas valider cette note. Elle n'est pas encore confirmée.";
            }
        } else {
            $response['msg'] = "Désolé mais vous ne pouvez pas valider cette note. Si vous pensez qu'il s'agit d'une erreur, merci de nous le signaler.";
        }
    } else {
        $response['msg'] = "Désolé mais cette note n'existe pas dans le système. Si vous pensez qu'il s'agit d'une erreur, merci de nous le signaler.";
    }
}

echo json_encode($response);