<?php

namespace app\core\model;

use app\core\entity\Profile;
use DateTime;
use PDO;
use PDOException;

class ProfileModel extends Model {

    private $table = "profiles";

    public function getAll() : array {
        $profiles = [];
        try {
            $sql = "SELECT t1.id, t1.user_name, t2.first_name, t2.last_name, t1.photo_path, t1.description, t1.date, t1.deleted FROM " . $this->table . " AS t1 INNER JOIN users as t2 ON t1.user_name=t2.user_name WHERE t1.deleted=:deleted";
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
}