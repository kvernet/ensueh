<?php

use app\core\entity\Message;
use app\core\model\ProfileModel;

$result = [
    "page" => "info",
    "msg_id" => Message::ACCESS_DENIED_MSG->value,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "msg_id_success" => Message::SUCCESS_MSG->value
];

if($_POST) {
    $user_name = htmlentities($_POST['user_name']);
    $description = htmlentities($_POST['description']);
    $attraction = htmlentities($_POST['attraction']);
    $contact = htmlentities($_POST['contact']);

    $profileModel = new ProfileModel;
    
    $profile = $profileModel->getByUserName($user_name);
    // update profile instance
    if(isset($description)) $profile->setDescription($description);
    if(isset($attraction)) $profile->setAttraction($attraction);
    if(isset($contact)) $profile->setContact($contact);
    // upload profile photo
    $message = Message::SUCCESS_MSG;
    if(isset($_FILES['photo_file'])) {
        $message = uploadProfilePhoto($_FILES['photo_file'], $user_name . ".png");
    }

    if($message == Message::SUCCESS_MSG) {
        // update profile in the database
        $message = $profileModel->update($profile);

        // get result & process
        $result['msg_id'] = $message->value;
        $result['msg'] = Message::getMessage($message);
        if($message == Message::SUCCESS_MSG) {
            $result['page'] = "profile";
        }
    }
}

echo json_encode($result);