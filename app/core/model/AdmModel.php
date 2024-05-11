<?php

namespace app\core\model;

use app\core\entity\Adm;
use app\core\entity\Status;
use PDO;
use PDOException;

class AdmModel extends Model {

    private $table = "adms";

    public function setTable(string $table) : AdmModel {
        $this->table = $table;
        return $this;
    }

    public function getAdm(string $user_name, string $pwd) : Adm {
        $adm = new Adm;

        $sql = "SELECT *, TIMESTAMPDIFF(SECOND, last_activity, now()) as tdiff FROM " . $this->table . " WHERE (user_name=:user_name AND pwd=PASSWORD2(:pwd))";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR],
            [":pwd", $pwd, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            $adm = new Adm($data[0]["id"], $data[0]["first_name"],
                $data[0]["last_name"], $data[0]["email"], $data[0]["phone"],
                $data[0]["gender_id"], $data[0]["section_id"],
                $data[0]["user_name"], $data[0]["pwd"],
                $data[0]["date_ins"], $data[0]["uniqid"],
                Status::tryFrom($data[0]["status"]) ?? Status::UNKNOWN,
                $data[0]["last_activity"]
            );
            
            if($adm->getStatus() == Status::ONLINE && isOffline($data[0]['tdiff'])) {
                $adm->setStatus(Status::OFFLINE);
            }
            
            pretiffy($data);
        }

        return $adm;
    }

    public function getStatus(string $user_name) : array {
        $sql = "SELECT uniqid, status, TIMESTAMPDIFF(SECOND, last_activity, now()) as tdiff FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            return [
                'uniqid' => $data[0]['uniqid'],
                'status' => $data[0]['status'],
                'tdiff' => $data[0]['tdiff']
            ];
        }

        return array();
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

    public function updateStatus(string $user_name, Status $status=Status::OFFLINE) : bool {
        try {
            $sql = "UPDATE " . $this->table . " SET status=:status WHERE user_name=:user_name";
            $c = $this->query($sql, [
                [":status", $status->value, PDO::PARAM_STR],
                [":user_name", $user_name, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "Update status error message: " . $e->getMessage();
        }
        return false;
    }

    public function isOnline(string $user_name) : bool {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_name=:user_name";
        $data = $this->query($sql, [
            [":user_name", $user_name, PDO::PARAM_STR]
        ])->execute()->fetchAll();
        if(count($data)) {
            return Status::get($data[0]["status"]) == Status::ONLINE;
        }
        return false;
    }
}