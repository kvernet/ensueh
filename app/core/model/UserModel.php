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

    public function add(User $user) : Message {
        try {
            if($this->emailExists($user->getEmail())) {
                return Message::EMAIL_EXIST_MESSAGE;
            }
            elseif($this->phoneExists($user->getPhone())) {
                return Message::PHONE_EXIST_MESSAGE;
            }
            elseif($this->userNameExists($user->getUserName())) {
                return Message::USERNAME_EXIST_MESSAGE;
            }

            $encrypted_pwd = $this->getEncryptedPwd($user->getPwd());
            
            $sql = "INSERT INTO " . $this->table . "(first_name, last_name, 
            gender_id, email, phone, department_id, whoami_id, section_id, 
            grade_id, user_name, pwd) VALUES(:first_name, :last_name, 
            :gender_id, :email, :phone, :department_id, :whoami_id, :section_id, 
            :grade_id, :user_name, :pwd)";
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
                [":user_name", $user->getUserName(), PDO::PARAM_STR],
                [":pwd", $encrypted_pwd, PDO::PARAM_STR]
            ])->execute();
            return Message::SUCCESS_MSG;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Message::UNKNOWN;
    }

    public function emailExists(string $email, int $id=-1) : bool {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (email=:email AND id!=:id)";
            $data = $this->query($sql, [
                [":email", $email, PDO::PARAM_STR],
                [":id", $id, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            return count($data) > 0;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return false;
    }

    public function get(string $user_name, string $pwd) : User|null {
        try {
            $encrypted_pwd = $this->getEncryptedPwd($pwd);
            $sql = "SELECT *, TIMESTAMPDIFF(SECOND, last_activity, now()) as tdiff FROM " . $this->table . " WHERE (user_name=:user_name AND pwd=:pwd)";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":pwd", $encrypted_pwd, PDO::PARAM_STR]
            ])->execute()->fetchAll();
            if (count($data)) {
                $user = new User(
                    $data[0]["id"],
                    $data[0]["first_name"],
                    $data[0]["last_name"],
                    Gender::get($data[0]["gender_id"]),
                    $data[0]["email"],
                    $data[0]["phone"],
                    Department::get($data[0]["department_id"]),
                    WhoAmI::get($data[0]["whoami_id"]),
                    Section::get($data[0]["section_id"]),
                    Grade::get($data[0]["grade_id"]),
                    $data[0]["user_name"],
                    $data[0]["pwd"],
                    new DateTime($data[0]["date_ins"]),
                    $data[0]["uniqid"],
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
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return null;
    }

    public function getById(int $id) : User|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE id=:id";
            $data = $this->query($sql, [
                [":id", $id, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            if (count($data)) {
                return new User(
                    $data[0]["id"],
                    $data[0]["first_name"],
                    $data[0]["last_name"],
                    Gender::get($data[0]["gender_id"]),
                    $data[0]["email"],
                    $data[0]["phone"],
                    Department::get($data[0]["department_id"]),
                    WhoAmI::get($data[0]["whoami_id"]),
                    Section::get($data[0]["section_id"]),
                    Grade::get($data[0]["grade_id"]),
                    $data[0]["user_name"],
                    $data[0]["pwd"],
                    new DateTime($data[0]["date_ins"]),
                    $data[0]["uniqid"],
                    Status::get($data[0]["status_id"]),
                    new DateTime($data[0]["last_activity"])
                );
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return null;
    }

    public function getBySectionAndGrade(Section $section, Grade $grade, int $offset, int $size, WhoAmI $whoAmI=WhoAmI::STUDENT): array {
        $users = [];
        try {
            $sql = "SELECT * FROM ". $this->table . " WHERE (section_id=:section_id AND grade_id=:grade_id AND whoami_id=:whoami_id) LIMIT :offset, :size";
            $data = $this->query($sql, [
                [":section_id", $section->value, PDO::PARAM_INT],
                [":grade_id", $grade->value, PDO::PARAM_INT],
                [":whoami_id", $whoAmI->value, PDO::PARAM_INT],
                [":offset", $offset, PDO::PARAM_INT],
                [":size", $size, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $users[] = new User(
                    $d["id"],
                    $d["first_name"],
                    $d["last_name"],
                    Gender::get($d["gender_id"]),
                    $d["email"],
                    $d["phone"],
                    Department::get($d["department_id"]),
                    WhoAmI::get($d["whoami_id"]),
                    Section::get($d["section_id"]),
                    Grade::get($d["grade_id"]),
                    $d["user_name"],
                    $d["pwd"],
                    new DateTime($d["date_ins"]),
                    $d["uniqid"],
                    Status::get($d["status_id"]),
                    new DateTime($d["last_activity"])
                );
            }
            return $users;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $users;
    }

    public function getByUserName(string $user_name) : User|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute()->fetchAll();
            if (count($data)) {
                return new User(
                    $data[0]["id"],
                    $data[0]["first_name"],
                    $data[0]["last_name"],
                    Gender::get($data[0]["gender_id"]),
                    $data[0]["email"],
                    $data[0]["phone"],
                    Department::get($data[0]["department_id"]),
                    WhoAmI::get($data[0]["whoami_id"]),
                    Section::get($data[0]["section_id"]),
                    Grade::get($data[0]["grade_id"]),
                    $data[0]["user_name"],
                    $data[0]["pwd"],
                    new DateTime($data[0]["date_ins"]),
                    $data[0]["uniqid"],
                    Status::get($data[0]["status_id"]),
                    new DateTime($data[0]["last_activity"])
                );
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return null;
    }

    public function getGrade(string $user_name) : Grade {
        try {
            $user = $this->getByUserName($user_name);
            if($user) {
                return $user->getGrade();
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Grade::UNKNOWN;
    }

    public function getPaginatedData(WhoAmI $whoAmI, int $offset, int $size): array {
        $users = array();
        try {
            $sql = "SELECT * FROM ". $this->table . " WHERE (whoami_id=:whoami_id) LIMIT :offset, :size";
            $data = $this->query($sql, [
                [":whoami_id", $whoAmI->value, PDO::PARAM_INT],
                [":offset", $offset, PDO::PARAM_INT],
                [":size", $size, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $user = new User(
                    $d["id"],
                    $d["first_name"],
                    $d["last_name"],
                    Gender::get($d["gender_id"]),
                    $d["email"],
                    $d["phone"],
                    Department::get($d["department_id"]),
                    WhoAmI::get($d["whoami_id"]),
                    Section::get($d["section_id"]),
                    Grade::get($d["grade_id"]),
                    $d["user_name"],
                    $d["pwd"],
                    new DateTime($d["date_ins"]),
                    $d["uniqid"],
                    Status::get($d["status_id"]),
                    new DateTime($d["last_activity"])
                );

                array_push($users, $user);
            }
            return $users;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $users;
    }

    public function getUsersCount(WhoAmI $whoAmI) : int {
        try {
            $sql = "SELECT count(*) AS total FROM users WHERE (whoami_id=:whoami_id)";
            $data = $this->query($sql, [
                [":whoami_id", $whoAmI->value, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            return $data[0]['total'];
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return 0;
    }

    public function countBySectionAndGrade(Section $section, Grade $grade, WhoAmI $whoAmI=WhoAmI::STUDENT) : int {
        try {
            $sql = "SELECT count(*) AS total FROM users WHERE (section_id=:section_id AND grade_id=:grade_id AND whoami_id=:whoami_id)";
            $data = $this->query($sql, [
                [":section_id", $section->value, PDO::PARAM_INT],
                [":grade_id", $grade->value, PDO::PARAM_INT],
                [":whoami_id", $whoAmI->value, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            return $data[0]['total'];
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return 0;
    }

    public function getSection(string $user_name) : Section {
        try {
            $user = $this->getByUserName($user_name);
            if($user) {
                return $user->getSection();
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Section::UNKNOWN;
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
        try {
            $sql = "SELECT uniqid, status_id, TIMESTAMPDIFF(SECOND, last_activity, now()) as tdiff FROM " . $this->table . " WHERE user_name=:user_name";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute()->fetchAll();
            if (count($data)) {
                return [
                    'uniqid' => $data[0]['uniqid'],
                    'status_id' => $data[0]['status_id'],
                    'tdiff' => $data[0]['tdiff']
                ];
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return array();
    }

    public function getUsers(WhoAmI $whoAmI) : array {
        try {
            $users = array();

            $sql = "SELECT * FROM " . $this->table . " WHERE whoami_id=:whoami_id";
            $data = $this->query($sql, [
                [":whoami_id", $whoAmI->value, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $user = new User(
                    $d["id"],
                    $d["first_name"],
                    $d["last_name"],
                    Gender::get($d["gender_id"]),
                    $d["email"],
                    $d["phone"],
                    Department::get($d["department_id"]),
                    WhoAmI::get($d["whoami_id"]),
                    Section::get($d["section_id"]),
                    Grade::get($d["grade_id"]),
                    $d["user_name"],
                    $d["pwd"],
                    new DateTime($d["date_ins"]),
                    $d["uniqid"],
                    Status::get($d["status_id"]),
                    new DateTime($d["last_activity"])
                );

                array_push($users, $user);
            }
            return $users;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return array();
    }

    public function getUsersBySectionGrade(Section $section, Grade $grade, WhoAmI $whoAmI=WhoAmI::STUDENT) : array {
        $users = [];
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (section_id=:section_id AND grade_id=:grade_id AND whoami_id=:whoami_id)";
            $data = $this->query($sql, [
                [":section_id", $section->value, PDO::PARAM_INT],
                [":grade_id", $grade->value, PDO::PARAM_INT],
                [":whoami_id", $whoAmI->value, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $users[] = new User(
                    $d["id"],
                    $d["first_name"],
                    $d["last_name"],
                    Gender::get($d["gender_id"]),
                    $d["email"],
                    $d["phone"],
                    Department::get($d["department_id"]),
                    WhoAmI::get($d["whoami_id"]),
                    Section::get($d["section_id"]),
                    Grade::get($d["grade_id"]),
                    $d["user_name"],
                    $d["pwd"],
                    new DateTime($d["date_ins"]),
                    $d["uniqid"],
                    Status::get($d["status_id"]),
                    new DateTime($d["last_activity"])
                );
            }
            return $users;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $users;
    }

    public function getWhoAmI(string $user_name) : WhoAmI {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute()->fetchAll();
            if (count($data)) {
                return WhoAmI::get($data[0]["whoami_id"]);
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return WhoAmI::UNKNOWN;
    }

    public function phoneExists(string $phone, int $id=-1) : bool {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (phone=:phone AND id!=:id)";
            $data = $this->query($sql, [
                [":phone", $phone, PDO::PARAM_STR],
                [":id", $id, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            return count($data) > 0;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
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
            (new HistoryModel)->add($e->getMessage(), getUserIP());
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
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Message::UNKNOWN;
    }

    public function updateLastActivity(string $user_name) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET last_activity=now() WHERE user_name=:user_name";
            $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
    }

    public function updatePwd(string $user_name, string $pwd) : bool {
        try {
            $encrypted_pwd = $this->getEncryptedPwd($pwd);
            $sql = "UPDATE " . $this->table . " SET pwd=:pwd WHERE user_name=:user_name";
            $this->query($sql, [
                [":pwd", $encrypted_pwd, PDO::PARAM_STR],
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
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
            (new HistoryModel)->add($e->getMessage(), getUserIP());
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
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
    }

    public function updateUniqId(string $user_name, string $uniqid) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET uniqid=:uniqid WHERE user_name=:user_name";
            $this->query($sql, [
                [":uniqid", $uniqid, PDO::PARAM_STR],
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        } catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
    }

    public function userNameExists(string $user_name) : bool {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute()->fetchAll();
            return count($data) > 0;
        } catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
    }
}