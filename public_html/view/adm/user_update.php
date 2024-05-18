<?php

use app\core\entity\Department;
use app\core\entity\Gender;
use app\core\entity\Grade;
use app\core\entity\Section;
use app\core\entity\Status;
use app\core\entity\User;
use app\core\entity\WhoIam;
use app\core\model\UserModel;

if($_POST) {
    $user = new User(
        $_POST["id"],
        $_POST["first_name"], $_POST["last_name"],
        Gender::get($_POST["gender"]),
        $_POST["email"], $_POST["phone"],
        Department::get($_POST["department"]),
        WhoIam::get($_POST["whoiam"]),
        Section::get($_POST["section"]),
        Grade::get($_POST["grade"]),
        "", "",
        new DateTime(date("")), "",
        Status::get($_POST["status"]),
        new DateTime(date(""))
    );

    (new UserModel)->updateById($user);

    redirectMe("student");
}