<?php

namespace app\core\model;

use PDO;
use PDOException;

class HistoryModel extends Model {

    private $table = "histories";

    public function add(string|null $what, string|null $who="") : void {
        try {
            $sql = "INSERT INTO " . $this->table . "(who, what) VALUES(:who, :what)";
            $this->query($sql, [
                [":who", $who, PDO::PARAM_STR],
                [":what", $what, PDO::PARAM_STR]
            ])->execute();
        }
        catch(PDOException) {
        }
    }

    public function setTable($table) : self {
        $this->table = $table;
        return $this;
    }
}