<?php

use app\core\controller\StudentController;
use app\core\entity\Message;
use app\core\model\UserModel;

$response =[
    "msg_id_success" => Message::SUCCESS_MSG->value,
    "msg_id" => Message::ACCESS_DENIED_MSG->value,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "page" => ""
];

if($_POST) {
    $user_name = StudentController::getUserName();
    $apwd = $_POST['apwd'];
    $pwd = $_POST['pwd'];
    $conf_pwd = $_POST['conf_pwd'];

    if($pwd == $conf_pwd) {
        $userModel = new UserModel;
        $user = $userModel->get($user_name, $apwd);
        if($user != null) {
            if($userModel->updatePwd($user_name, $pwd)) {
                $response['msg_id'] = Message::SUCCESS_MSG->value;
                $response['msg'] = "Votre mot de passe a été changé avec succès.";
            } else {
                $response['msg'] = "Le changement de mot de passe a échoué. Veuillez essayer à nouveau et si cela persite, merci de contacter les responsables.";
            }            
        } else {
            $response['msg'] = "Le mot de passe actuel indiqué est incorrect. Veuillez contacter les responsables.";
            $response['msg_id'] = Message::USER_NOT_EXISTS_MSG->value;
        }
    } else {
        $response['msg'] = "Le nouveau mot de passe et sa confirmation ne se correspondent pas.";
    }
}

echo json_encode($response);