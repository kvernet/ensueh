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
        } catch(PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }

    protected function query($sql, $params) : Model {
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
            echo "Error message : " . $e->getMessage();
        }
        die("<br><br>Query failed.");
    }

    protected function execute() : Model {
        try {
            // execute
            $this->stmt->execute();
            return $this;
        }
        catch(PDOException $e) {
            echo "Error message : " . $e->getMessage();
        }
        die("<br><br>Execute failed.");
    }

    protected function fetchAll() : array {
        try {
            // set the resulting array to associative
            $this->stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $this->stmt->fetchAll();
        }
        catch(PDOException $e) {
            echo "Error message : " . $e->getMessage();
        }
        die("<br><br>Fetch failed.");
    }
}