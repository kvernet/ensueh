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
                $response['msg'] = "Désolé mais vous ne pouvez plus défaire le statut de cette note. Elle a déjà été validée par un administrateur.";
            } else {
                $message = $noteModel->updateStatus($id, NoteStatus::ADDED);
                if($message == Message::SUCCESS_MSG) {
                    $response['msg'] = "Statut de la note rétabli avec succès.";
                }
            }
        } else {
            $response['msg'] = "Désolé mais vous ne pouvez pas défaire le statut de cette note. Si vous pensez qu'il s'agit d'une erreur, merci de contacter les responsables.";
        }
    } else {
        $response['msg'] = "Désolé mais cette note n'existe pas dans le système. Si vous pensez qu'il s'agit d'une erreur, merci de contacter les responsables.";
    }
}

echo json_encode($response);