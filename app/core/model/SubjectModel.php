<?php

namespace app\core\model;

use app\core\entity\Grade;
use app\core\entity\Subject;
use DateTime;
use PDO;
use PDOException;

class SubjectModel extends Model {

    private $table = "subjects";

    public function getGrades(string $user_name) : array {
        $grades = [];
        try {
            $sql = "SELECT DISTINCT grade_id FROM " . $this->table . " WHERE (user_name=:user_name AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach($data as $d) {
                $grades[] = Grade::get($d['grade_id']);
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $grades;
    }

    public function getSubjectById(int $id) : Subject|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (id=:id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":id", $id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) {
                return new Subject(
                    $data[0]['id'], $data[0]['name'],
                    Grade::get($data[0]['grade_id']),
                    $data[0]['user_name'],
                    $data[0]['max_note'],
                    $data[0]['coef'],
                    new DateTime($data[0]['date']),
                    $data[0]['deleted']
                );
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    public function getSubjects(string $user_name, Grade $grade) : array {
        $subjects = [];
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (user_name=:user_name AND grade_id=:grade_id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":grade_id", $grade->value, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach($data as $d) {
                $subjects[] = new Subject(
                    $d['id'], $d['name'],
                    Grade::get($d['grade_id']),
                    $d['user_name'],
                    $d['max_note'],
                    $d['coef'],
                    new DateTime($d['date']),
                    $d['deleted']
                );
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $subjects;
    }
}