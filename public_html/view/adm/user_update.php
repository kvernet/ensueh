<?php

use app\core\entity\Department;
use app\core\entity\Gender;
use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;
use app\core\entity\Status;
use app\core\entity\User;
use app\core\entity\WhoAmI;
use app\core\model\SingleModel;
use app\core\model\UserModel;

$result = [
    "page" => "info",
    "msg_id" => Message::ACCESS_DENIED_MSG->value,
    "msg" => Message::getMessage(Message::ACCESS_DENIED_MSG),
    "msg_id_success" => Message::SUCCESS_MSG->value
];

if ($_POST) {
    $message = Message::ACCESS_DENIED_MSG;

    if (isset($_POST["id"])) {
        $userModel = new UserModel;
        $user = $userModel->getById($_POST["id"]);

        $singleModel = new SingleModel;

        $single = $singleModel->setTable("genders")->getByContent($_POST["gender"]);
        $gender = Gender::get($single->getId());
        if ($gender == Gender::UNKNOWN) {
            $gender = $user->getGender();
        }

        $single = $singleModel->setTable("departments")->getByContent($_POST["department"]);
        $department = Department::get($single->getId());
        if ($department == Department::UNKNOWN) {
            $department = $user->getDepartment();
        }

        $single = $singleModel->setTable("whoami")->getByContent($_POST["whoami"]);
        $whoAmI = WhoAmI::get($single->getId());
        if ($whoAmI == WhoAmI::UNKNOWN) {
            $whoAmI = $user->getWhoAmI();
        }

        $single = $singleModel->setTable("sections")->getByContent($_POST["section"]);
        $section = Section::get($single->getId());
        if ($section == Section::UNKNOWN) {
            $section = $user->getSection();
        }

        $single = $singleModel->setTable("grades")->getByContent($_POST["grade"]);
        $grade = Grade::get($single->getId());
        if ($grade == Grade::UNKNOWN) {
            $grade = $user->getGrade();
        }

        $single = $singleModel->setTable("statuses")->getByContent($_POST["status"]);
        $status = Status::get($single->getId());
        if ($status == Status::UNKNOWN) {
            $status = $user->getStatus();
        }


        $user = new User(
            $_POST["id"],
            $_POST["first_name"] ?? $user->getFirstName(),
            $_POST["last_name"] ?? $user->getLastName(),
            $gender,
            $_POST["email"] ?? $user->getEmail(),
            $_POST["phone"] ?? $user->getPhone(),
            $department,
            $whoAmI,
            $section,
            $grade,
            "",
            "",
            new DateTime(date("")),
            "",
            $status,
            new DateTime(date(""))
        );

        $message = $userModel->updateById($user);

        $result['msg_id'] = $message->value;
        $result['msg'] = Message::getMessage($message);

        if ($message == Message::SUCCESS_MSG) {
            $result['page'] = $_POST['return_page'];            
        }
    }
}

echo json_encode($result);
