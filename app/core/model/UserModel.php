<?php

namespace app\core\model;

use app\core\entity\User;
use PDO;

class UserModel extends Model {

    private $table = "users";

    public function setTable(string $table) : UserModel {
        $this->table = $table;
        return $this;
    }

    public function add(User $user) : string {
        if($this->emailExists($user->getEmail())) {
            return EMAIL_EXIST_MESSAGE;
        }
        elseif($this->phoneExists($user->getPhone())) {
            return PHONE_EXIST_MESSAGE;
        }
        elseif($this->userNameExists($user->getUserName())) {
            return USERNAME_EXIST_MESSAGE;
        }
        
        $sql = "INSERT INTO " . $this->table . "(first_name, last_name, 
        email, phone, gender_id, department_id, status_id, section_id, 
        user_name, pwd) VALUES(:first_name, :last_name, 
        :email, :phone, :gender_id, :department_id, :status_id, :section_id, 
        :user_name, :pwd)";
        $c = $this->query($sql, [
            [":first_name", $user->getFirstName(), PDO::PARAM_STR],
            [":last_name", $user->getLastName(), PDO::PARAM_STR],
            [":email", $user->getEmail(), PDO::PARAM_STR],
            [":phone", $user->getPhone(), PDO::PARAM_STR],
            [":gender_id", $user->getGenderId(), PDO::PARAM_STR],
            [":department_id", $user->getDepartmentId(), PDO::PARAM_STR],
            [":status_id", $user->getStatusId(), PDO::PARAM_STR],
            [":section_id", $user->getSectionId(), PDO::PARAM_STR],
            [":user_name", $user->getUserName(), PDO::PARAM_STR],
            [":pwd", $user->getPwd(), PDO::PARAM_STR]
        ])->execute();
        if($c) {
            return "OK";
        }
        else {
            return "NO";
        }
    }

    public function get(string $user_name, string $pwd) : User {
        $user = new User;

        $sql = "SELECT * FROM " . $this->table . " WHERE (user_name=:user_name AND pwd=:pwd)";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR],
            [":pwd", $pwd, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            $user = new User($data[0]["id"], $data[0]["first_name"],
                $data[0]["last_name"], $data[0]["email"], $data[0]["phone"],
                $data[0]["gender_id"], $data[0]["department_id"], $data[0]["status_id"],
                $data[0]["section_id"], $data[0]["user_name"], $data[0]["pwd"],
                $data[0]["date_ins"], $data[0]["active"]
            );
        }

        return $user;
    }

    public function emailExists(string $email) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE email=:email";
        $data = $this->query($sql, [
            [":email", $email, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        return count($data) > 0;
    }

    public function phoneExists(string $phone) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE phone=:phone";
        $data = $this->query($sql, [
            [":phone", $phone, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        return count($data) > 0;
    }

    public function userNameExists(string $user_name) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        return count($data) > 0;
    }
}