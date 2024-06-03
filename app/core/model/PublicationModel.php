<?php

namespace app\core\model;

use app\core\entity\Publication;
use DateTime;
use PDO;
use PDOException;

class PublicationModel extends Model {

    private $table = "publications";

    public function getAll() : array {
        $publications = [];
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE deleted=:deleted";
            $data = $this->query($sql, [
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $publications[] = new Publication(
                    $d["id"],
                    $d["user_name"],
                    $d["name"],
                    $d["doi"],
                    new DateTime($d['date']),
                    $d["deleted"]
                );
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $publications;
    }

    public function getAllByUserName(string $user_name) : array {
        $publications = [];
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (user_name=:user_name AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $publications[] = new Publication(
                    $d["id"],
                    $d["user_name"],
                    $d["name"],
                    $d["doi"],
                    new DateTime($d['date']),
                    $d["deleted"]
                );
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $publications;
    }

    public function setTable($table) : self {
        $this->table = $table;
        return $this;
    }
}