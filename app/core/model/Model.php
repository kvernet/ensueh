<?php

namespace app\core\model;

use PDO;
use PDOException;

class Model {
    private $pdo;
    private $stmt = null;

    public function __construct() {
        try {
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            );
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PWD, $options);
            // set the PDO error mode to exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException) {
            echo '<h2 style="text-align:center;">En construction.<br>';
            die();
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }

    protected function execute() : Model|null {
        try {
            // execute
            $this->stmt->execute();
            return $this;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    protected function fetchAll() : array {
        try {
            // set the resulting array to associative
            $this->stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $this->stmt->fetchAll();
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return array();
    }

    public function getEncryptedPwd(string $pwd) : string|null {
        try {
            $sql = "SELECT ENCRYPT_PASSWORD(:pwd) as encrypted_pwd";
            $data = $this->query($sql, [
                [":pwd", $pwd, PDO::PARAM_STR]
            ])->execute()->fetchAll();
            if(count($data)) {
                return $data[0]['encrypted_pwd'];
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    protected function query($sql, $params) : Model|null {
        try {
            // prepare sql
            $this->stmt = $this->pdo->prepare($sql);
            // bind parameters
            for($i = 0; $i < count($params); $i++) {
                $this->stmt->bindParam(
                    $params[$i][0], $params[$i][1], $params[$i][2]
                );
            }
            return $this;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }
}