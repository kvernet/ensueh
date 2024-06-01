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
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    public function getByContent(string $content) : Single|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (content=:content AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":content", $content, PDO::PARAM_STR],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) {
                return new Single($data[0]["id"], $data[0]["content"], $data[0]["deleted"]);
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    public function getAll() : array {
        try {
            $singles = array();

            $sql = "SELECT * FROM " . $this->table . " WHERE (deleted=:deleted) ORDER BY id";
            $data = $this->query($sql, [
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $single = new Single($d["id"], $d["content"], $d["deleted"]);
                array_push($singles, $single);
            }

            return $singles;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return array();
    }

    public function getAllAsJSON(array $filteredIds=[]) : string {
        try {
            $data = [];

            $singles = $this->getAll();
            foreach ($singles as $single) {
                if (in_array($single->getId(), $filteredIds, true)) {
                    continue;
                }
                //$data[$single->getId()] = $single->getContent();
                $data[$single->getContent()] = $single->getContent();
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return json_encode($data);
    }

    public function getAllAsOptions(int $selectId=-1, array $filteredIds=[]) : string {
        try {
            $options = "";

            $singles = $this->getAll();
            foreach ($singles as $single) {
                if (in_array($single->getId(), $filteredIds, true)) {
                    continue;
                }
                $options .= $single->getAsOption($single->getId() == $selectId);
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return $options;

    }

    public function setTable($table) : SingleModel {
        $this->table = $table;
        return $this;
    }
}