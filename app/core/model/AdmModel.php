<?php

namespace app\core\model;

use app\core\entity\Adm;
use PDO;
use PDOException;

class AdmModel extends Model {

    private $table = "adms";

    public function setTable(string $table) : AdmModel {
        $this->table = $table;
        return $this;
    }

    public function get(string $user_name, string $pwd) : Adm {
        $adm = new Adm;

        $sql = "SELECT * FROM " . $this->table . " WHERE (user_name=:user_name AND pwd=:pwd)";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR],
            [":pwd", $pwd, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            $adm = new Adm($data[0]["id"], $data[0]["first_name"],
                $data[0]["last_name"], $data[0]["email"], $data[0]["phone"],
                $data[0]["gender_id"], $data[0]["section_id"],
                $data[0]["user_name"], $data[0]["pwd"],
                $data[0]["date_ins"], $data[0]["connected"], $data[0]["active"]
            );
        }

        return $adm;
    }

    public function login(string $user_name) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET connected=:connected WHERE user_name=:user_name";
            $c = $this->query($sql, [
                [":connected", true, PDO::PARAM_BOOL],
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Login error message: " . $e->getMessage();
        }
        return false;
    }

    public function logout(string $user_name) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET connected=:connected WHERE user_name=:user_name";
            $c = $this->query($sql, [
                [":connected", false, PDO::PARAM_BOOL],
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Logout error message: " . $e->getMessage();
        }
        return false;
    }

    public function isConnected(string $user_name) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            return $data[0]["connected"];
        }
        return false;
    }
}