<?php

use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;
use app\core\entity\Subject;
use app\core\model\SingleModel;
use app\core\model\SubjectModel;

$response = [
    "success" => false,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "content" => ""
];

if ($_POST) {
    $response['msg'] = "Cours modifié avec succès.";

    $singleModel = new SingleModel;

    $section = $singleModel->setTable("sections")->getByContent($_POST["section"]);

    $grade = $singleModel->setTable("grades")->getByContent($_POST["grade"]);

    $msg = (new SubjectModel)->update(
        new Subject(
            intval($_POST['id']),
            $_POST['name'],
            Section::get($section->getId()),
            Grade::get($grade->getId()),
            $_POST['user_name'],
            floatval($_POST['max_note']),
            floatval($_POST['coef']),
            new DateTime(),
            false
        )
    );

    if ($msg != Message::SUCCESS_MSG) {
        $response['msg'] = Message::getMessage($msg);
    }

    error_log(json_encode($_POST));
}

echo json_encode($response);
