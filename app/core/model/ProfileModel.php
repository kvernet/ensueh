<?php

namespace app\core\model;

use app\core\entity\Message;
use app\core\entity\Profile;
use DateTime;
use PDO;
use PDOException;

class ProfileModel extends Model {

    private $table = "profiles";

    public function add(Profile $profile) : bool {
        try {
            $sql = "INSERT INTO ". $this->table ."(user_name, photo_path, description, attraction, contact, deleted) VALUES(:user_name, :photo_path, :description, :attraction, :contact, :deleted)";
            $this->query($sql, [
                [":user_name", $profile->getUserName(), PDO::PARAM_STR],
                [":photo_path", $profile->getPhotoPath(), PDO::PARAM_STR],
                [":description", $profile->getDescription(), PDO::PARAM_STR],
                [":attraction", $profile->getAttraction(), PDO::PARAM_STR],
                [":contact", $profile->getContact(), PDO::PARAM_STR],
                [":deleted", $profile->getDeleted(), PDO::PARAM_BOOL]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
    }

    public function getByUserName(string $user_name) : Profile|null {
        try {
            $sql = "SELECT t1.id, t1.user_name, t2.first_name, t2.last_name, t1.photo_path, t1.description, t1.attraction, t1.contact, t1.date, t1.deleted FROM " . $this->table . " AS t1 INNER JOIN users as t2 ON t1.user_name=t2.user_name WHERE (t1.user_name=:user_name AND t1.deleted=:deleted)";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) {
                return new Profile(
                    $data[0]["id"],
                    $data[0]["user_name"],
                    $data[0]["first_name"],
                    $data[0]["last_name"],
                    $data[0]['photo_path'],
                    $data[0]['description'],
                    $data[0]['attraction'],
                    $data[0]['contact'],
                    new DateTime($data[0]['date']),
                    $data[0]["deleted"]
                );
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    public function getAll() : array {
        $profiles = [];
        try {
            $sql = "SELECT t1.id, t1.user_name, t2.first_name, t2.last_name, t1.photo_path, t1.description, t1.attraction, t1.contact, t1.date, t1.deleted FROM " . $this->table . " AS t1 INNER JOIN users as t2 ON t1.user_name=t2.user_name WHERE t1.deleted=:deleted";
            $data = $this->query($sql, [
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $profiles[] = new Profile(
                    $d["id"],
                    $d["user_name"],
                    $d["first_name"],
                    $d["last_name"],
                    $d['photo_path'],
                    $d['description'],
                    $d['attraction'],
                    $d['contact'],
                    new DateTime($d['date']),
                    $d["deleted"]
                );
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $profiles;
    }

    public function setTable($table) : self {
        $this->table = $table;
        return $this;
    }

    public function update(Profile $profile) : Message {
        try {
            $sql = "UPDATE " . $this->table . " SET photo_path=:photo_path, description=:description, attraction=:attraction, contact=:contact, deleted=:deleted WHERE user_name=:user_name";
            $this->query($sql, [
                [":photo_path", $profile->getPhotoPath(), PDO::PARAM_STR],
                [":description", $profile->getDescription(), PDO::PARAM_STR],
                [":attraction", $profile->getAttraction(), PDO::PARAM_STR],
                [":contact", $profile->getContact(), PDO::PARAM_STR],
                [":deleted", $profile->getDeleted(), PDO::PARAM_BOOL],
                [":user_name", $profile->getUserName(), PDO::PARAM_STR],
            ])->execute();
            return Message::SUCCESS_MSG;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Message::ADM_STATUS_SUSPENDED_MSG;
    }
}