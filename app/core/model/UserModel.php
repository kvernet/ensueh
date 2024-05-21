<?php

namespace app\core\model;

use app\core\entity\Department;
use app\core\entity\Gender;
use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;
use app\core\entity\Status;
use app\core\entity\User;
use app\core\entity\WhoAmI;
use DateTime;
use PDO;
use PDOException;

class UserModel extends Model {

    private $table = "users";

    public function add(User $user) : bool {
        try {
            if($this->emailExists($user->getEmail())) {
                return Message::getMessage(Message::EMAIL_EXIST_MESSAGE);
            }
            elseif($this->phoneExists($user->getPhone())) {
                return Message::getMessage(Message::PHONE_EXIST_MESSAGE);
            }
            elseif($this->userNameExists($user->getUserName())) {
                return Message::getMessage(Message::USERNAME_EXIST_MESSAGE);
            }
            
            $sql = "INSERT INTO " . $this->table . "(first_name, last_name, 
            gender_id, email, phone, department_id, whoami_id, section_id, 
            grade_id, user_name, pwd) VALUES(:first_name, :last_name, 
            :gender_id, :email, :phone, :department_id, :whoami_id, :section_id, 
            :grade_id, :user_name, :pwd)";
            $c = $this->query($sql, [
                [":first_name", $user->getFirstName(), PDO::PARAM_STR],
                [":last_name", $user->getLastName(), PDO::PARAM_STR],
                [":gender_id", $user->getGender()->value, PDO::PARAM_INT],
                [":email", $user->getEmail(), PDO::PARAM_STR],
                [":phone", $user->getPhone(), PDO::PARAM_STR],
                [":department_id", $user->getDepartment()->value, PDO::PARAM_INT],
                [":whoami_id", $user->getWhoAmI()->value, PDO::PARAM_INT],
                [":section_id", $user->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $user->getGrade()->value, PDO::PARAM_INT],
                [":user_name", $user->getUserName(), PDO::PARAM_STR],
                [":pwd", $user->getPwd(), PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Add user error message: " . $e->getMessage();
        }
        return false;
    }

    public function emailExists(string $email, int $id=-1) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE (email=:email AND id!=:id)";
        $data = $this->query($sql, [
            [":email", $email, PDO::PARAM_STR],
            [":id", $id, PDO::PARAM_INT]
        ])->execute()->fetchAll();
        return count($data) > 0;
    }

    public function get(string $user_name, string $pwd, WhoAmI $whoAmI) : User|null {
        $encrypted_pwd = $this->getEncryptedPwd($pwd);
        $sql = "SELECT *, TIMESTAMPDIFF(SECOND, last_activity, now()) as tdiff FROM " . $this->table . " WHERE (whoami_id=:whoami_id AND user_name=:user_name AND pwd=:pwd)";
        $data = $this->query($sql, [
            [":whoami_id", $whoAmI->value, PDO::PARAM_STR],
            [":user_name", $user_name, PDO::PARAM_STR],
            [":pwd", $encrypted_pwd, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            $user = new User(
                $data[0]["id"],
                $data[0]["first_name"], $data[0]["last_name"],
                Gender::get($data[0]["gender_id"]),
                $data[0]["email"], $data[0]["phone"],
                Department::get($data[0]["department_id"]),
                WhoAmI::get($data[0]["whoami_id"]),
                Section::get($data[0]["section_id"]),
                Grade::get($data[0]["grade_id"]),
                $data[0]["user_name"], $data[0]["pwd"],
                new DateTime($data[0]["date_ins"]), $data[0]["uniqid"],
                Status::get($data[0]["status_id"]),
                new DateTime($data[0]["last_activity"])
            );

            $status = self::getStatus([
                'uniqid' => $data[0]['uniqid'],
                'status_id' => $data[0]['status_id'],
                'tdiff' => $data[0]['tdiff']
            ]);
            $user->setStatus($status);
            return $user;
        }

        return null;
    }

    public function getById(int $id) : User|null {
        $sql = "SELECT * FROM " . $this->table . " WHERE id=:id";
        $data = $this->query($sql, [
            [":id", $id, PDO::PARAM_INT]
        ])->execute()->fetchAll();
        if(count($data)) {
            return new User(
                $data[0]["id"],
                $data[0]["first_name"], $data[0]["last_name"], 
                Gender::get($data[0]["gender_id"]),
                $data[0]["email"], $data[0]["phone"],
                Department::get($data[0]["department_id"]), 
                WhoAmI::get($data[0]["whoami_id"]),
                Section::get($data[0]["section_id"]),
                Grade::get($data[0]["grade_id"]),
                $data[0]["user_name"], $data[0]["pwd"],
                new DateTime($data[0]["date_ins"]), $data[0]["uniqid"],
                Status::get($data[0]["status_id"]),
                new DateTime($data[0]["last_activity"])
            );
        }

        return null;
    }

    public function getByUserName(string $user_name) : User|null {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            return new User(
                $data[0]["id"],
                $data[0]["first_name"], $data[0]["last_name"], 
                Gender::get($data[0]["gender_id"]),
                $data[0]["email"], $data[0]["phone"],
                Department::get($data[0]["department_id"]), 
                WhoAmI::get($data[0]["whoami_id"]),
                Section::get($data[0]["section_id"]),
                Grade::get($data[0]["grade_id"]),
                $data[0]["user_name"], $data[0]["pwd"],
                new DateTime($data[0]["date_ins"]), $data[0]["uniqid"],
                Status::get($data[0]["status_id"]),
                new DateTime($data[0]["last_activity"])
            );
        }

        return null;
    }

    static public function getStatus(array $ar) : Status {
        if(count($ar) <= 0) return Status::UNKNOWN;

        $status = Status::get($ar['status_id']);
        if($status == Status::REQUESTED) return $status;

        if($status == Status::CONNECTED) {
            // same device/browser
            if(isset($_COOKIE['adm_uniqid']) && $ar['uniqid'] == $_COOKIE['adm_uniqid']) {
                if($ar['tdiff'] <= ONLINE_DURATION) {
                    return Status::ONLINE;
                }
                else {
                    if($ar['tdiff'] <= ACTIVE_DURATION) {
                        return Status::ACTIVE;
                    }
                    else {
                        return Status::INACTIVE;
                    }
                    return Status::OFFLINE;
                }
            }
            elseif($ar['tdiff'] > ACTIVE_DURATION) {
                return Status::DISCONNECTED;
            }
        }

        return $status;
    }

    public function getStatusDetails(string $user_name) : array {
        $sql = "SELECT uniqid, status_id, TIMESTAMPDIFF(SECOND, last_activity, now()) as tdiff FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            return [
                'uniqid' => $data[0]['uniqid'],
                'status_id' => $data[0]['status_id'],
                'tdiff' => $data[0]['tdiff']
            ];
        }

        return array();
    }

    public function getUsers(WhoAmI $whoAmI) : array {
        $users = array();

        $sql = "SELECT * FROM ". $this->table ." WHERE whoami_id=:whoami_id";
        $data = $this->query($sql, [
            [":whoami_id", $whoAmI->value, PDO::PARAM_INT]
        ])->execute()->fetchAll();
        foreach($data as $d) {
            $user = new User(
                $d["id"], $d["first_name"], $d["last_name"],
                Gender::get($d["gender_id"]),
                $d["email"], $d["phone"],
                Department::get($d["department_id"]), 
                WhoAmI::get($d["whoiam_id"]),
                Section::get($d["section_id"]),
                Grade::get($d["grade_id"]),
                $d["user_name"], $d["pwd"],
                new DateTime($d["date_ins"]), $d["uniqid"],
                Status::get($d["status_id"]),
                new DateTime($d["last_activity"])
            );

            array_push($users, $user);
        }

        return $users;
    }

    public function getWhoAmI(string $user_name) : WhoAmI {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            return WhoAmI::get($data[0]["whoami_id"]);
        }

        return WhoAmI::UNKNOWN;
    }

    public function phoneExists(string $phone, int $id=-1) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE (phone=:phone AND id!=:id)";
        $data = $this->query($sql, [
            [":phone", $phone, PDO::PARAM_STR],
            [":id", $id, PDO::PARAM_INT]
        ])->execute()->fetchAll();
        return count($data) > 0;
    }

    public function searchUsersByUserNameLike(WhoAmI $whoAmI, string $user_name_like="") : array {
        $users = array();

        $sql = "SELECT * FROM users WHERE (whoami_id=:whoami_id AND user_name LIKE :user_name)";
        $data = $this->query($sql, [
            [":whoami_id", $whoAmI->value, PDO::PARAM_INT],
            [":user_name", "%" . $user_name_like . "%", PDO::PARAM_STR]
        ])->execute()->fetchAll();
        foreach($data as $d) {
            $user = new User(
                $d["id"], $d["first_name"], $d["last_name"],
                Gender::get($d["gender_id"]),
                $d["email"], $d["phone"],
                Department::get($d["department_id"]), 
                WhoAmI::get($d["whoami_id"]),
                Section::get($d["section_id"]),
                Grade::get($d["grade_id"]),
                $d["user_name"], $d["pwd"],
                new DateTime($d["date_ins"]), $d["uniqid"],
                Status::get($d["status_id"]),
                new DateTime($d["last_activity"])
            );

            array_push($users, $user);
        }

        return $users;
    }

    public function setTable(string $table) : UserModel {
        $this->table = $table;
        return $this;
    }

    public function updateById(User $user) : Message {
        try {
            // check if email already exists
            if($this->emailExists($user->getEmail(), $user->getId())) {
                return Message::EMAIL_EXIST_MESSAGE;
            }
            // check if phone is already exists
            if($this->phoneExists($user->getPhone(), $user->getId())) {
                return Message::PHONE_EXIST_MESSAGE;
            }
            
            $sql = "UPDATE " . $this->table . " SET first_name=:first_name, last_name=:last_name, 
            gender_id=:gender_id, email=:email, phone=:phone, department_id=:department_id, 
            whoami_id=:whoami_id, section_id=:section_id, 
            grade_id=:grade_id, status_id=:status_id WHERE id=:id";
            $this->query($sql, [
                [":first_name", $user->getFirstName(), PDO::PARAM_STR],
                [":last_name", $user->getLastName(), PDO::PARAM_STR],
                [":gender_id", $user->getGender()->value, PDO::PARAM_INT],
                [":email", $user->getEmail(), PDO::PARAM_STR],
                [":phone", $user->getPhone(), PDO::PARAM_STR],
                [":department_id", $user->getDepartment()->value, PDO::PARAM_INT],
                [":whoami_id", $user->getWhoAmI()->value, PDO::PARAM_INT],
                [":section_id", $user->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $user->getGrade()->value, PDO::PARAM_INT],
                [":status_id", $user->getStatus()->value, PDO::PARAM_INT],
                [":id", $user->getId(), PDO::PARAM_INT]
            ])->execute();
            return Message::SUCCESS_MSG;
        }
        catch(PDOException $e) {
            echo "Update user by id error message: " . $e->getMessage();
        }
        return Message::UNKNOWN;
    }

    public function updateByUserName(User $user) : Message {
        try {
            // check if email already exists
            if($this->emailExists($user->getEmail(), $user->getId())) {
                return Message::EMAIL_EXIST_MESSAGE;
            }
            // check if phone is already exists
            if($this->phoneExists($user->getPhone(), $user->getId())) {
                return Message::PHONE_EXIST_MESSAGE;
            }
            
            $sql = "UPDATE " . $this->table . " SET first_name=:first_name, last_name=:last_name, 
            gender_id=:gender_id, email=:email, phone=:phone, department_id=:department_id, 
            whoami_id=:whoami_id, section_id=:section_id, 
            grade_id=:grade_id, status_id=:status_id WHERE user_name=:user_name";
            $this->query($sql, [
                [":first_name", $user->getFirstName(), PDO::PARAM_STR],
                [":last_name", $user->getLastName(), PDO::PARAM_STR],
                [":gender_id", $user->getGender()->value, PDO::PARAM_INT],
                [":email", $user->getEmail(), PDO::PARAM_STR],
                [":phone", $user->getPhone(), PDO::PARAM_STR],
                [":department_id", $user->getDepartment()->value, PDO::PARAM_INT],
                [":whoami_id", $user->getWhoAmI()->value, PDO::PARAM_INT],
                [":section_id", $user->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $user->getGrade()->value, PDO::PARAM_INT],
                [":status_id", $user->getStatus()->value, PDO::PARAM_INT],
                [":user_name", $user->getUserName(), PDO::PARAM_INT]
            ])->execute();
            return Message::SUCCESS_MSG;
        }
        catch(PDOException $e) {
            echo "Update user by user name error message: " . $e->getMessage();
        }
        return Message::UNKNOWN;
    }

    public function updateLastActivity(string $user_name) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET last_activity=now() WHERE user_name=:user_name";
            $c = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Update last activity error message: " . $e->getMessage();
        }
        return false;
    }

    public function updateStatusById(int $id, Status $status=Status::OFFLINE) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET status_id=:status_id WHERE id=:id";
            $this->query($sql, [
                [":status_id", $status->value, PDO::PARAM_INT],
                [":id", $id, PDO::PARAM_INT]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Update status by id error message: " . $e->getMessage();
        }
        return false;
    }

    public function updateStatusByUserName(string $user_name, Status $status=Status::OFFLINE) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET status_id=:status_id WHERE user_name=:user_name";
            $this->query($sql, [
                [":status_id", $status->value, PDO::PARAM_INT],
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Update status by user name error message: " . $e->getMessage();
        }
        return false;
    }

    public function updateUniqId(string $user_name, string $uniqid) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET uniqid=:uniqid WHERE user_name=:user_name";
            $c = $this->query($sql, [
                [":uniqid", $uniqid, PDO::PARAM_STR],
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Update uniqid error message: " . $e->getMessage();
        }
        return false;
    }

    public function userNameExists(string $user_name) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        return count($data) > 0;
    }
}