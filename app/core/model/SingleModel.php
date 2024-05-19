<?php

namespace app\core\model;

use app\core\entity\Single;
use PDO;
use PDOException;

class SingleModel extends Model {

    private $table = null;

    public function get($id) : Single|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (id=:id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":id", $id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) {
                return new Single($data[0]["id"], $data[0]["content"], $data[0]["deleted"]);
            }
        }
        catch(PDOException $e) {
            echo "Update status by user name error message: " . $e->getMessage();
        }
        return null;
    }

    public function getAll() : array {
        $singles = array();

        $sql = "SELECT * FROM " . $this->table . " WHERE (deleted=:deleted) ORDER BY id";
        $data = $this->query($sql, [
            [":deleted", false, PDO::PARAM_BOOL]
        ])->execute()->fetchAll();
        foreach($data as $d) {
            $single = new Single($d["id"], $d["content"], $d["deleted"]);
            array_push($singles, $single);
        }

        return $singles;
    }

    public function getAllAsOptions(int $selectId=-1, array $filteredIds=[]) : string {
        $options = "";

        $singles = $this->getAll();
        foreach($singles as $single) {
            if(in_array($single->getId(), $filteredIds, true)) {
                continue;
            }
            $options .= $single->getAsOption($single->getId() == $selectId);
        }

        return $options;
    }

    public function setTable($table) : SingleModel {
        $this->table = $table;
        return $this;
    }
}