<?php

namespace app\core\model;

use app\core\entity\Single;
use PDO;

class SingleModel extends Model {

    private $table = null;

    public function setTable($table) : SingleModel {
        $this->table = $table;
        return $this;
    }

    public function get($id) : Single {
        $single = new Single();

        $sql = "SELECT * FROM " . $this->table . " WHERE (id=:id AND deleted=:deleted)";
        $data = $this->query($sql, [
            [":id", $id, PDO::PARAM_INT],
            [":deleted", false, PDO::PARAM_BOOL]
        ])->execute()->fetchAll();
        if(count($data)) {
            $single = new Single($data[0]["id"], $data[0]["content"], $data[0]["deleted"]);
        }

        return $single;
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

    public function getAllAsOptions() : string {
        $options = "";

        $singles = $this->getAll();
        foreach($singles as $single) {
            $options .= $single->getAsOption();
        }

        return $options;
    }
}