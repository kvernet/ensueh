<?php

namespace app\core\model;

use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;
use app\core\entity\Subject;
use DateTime;
use PDO;
use PDOException;

class SubjectModel extends Model {

    private $table = "subjects";

    public function add(Subject $subject) : Message {
        try {
            $sql = "INSERT INTO " . $this->table . "(name, section_id, grade_id, user_name, max_note, coef) VALUES(:name, :section_id, :grade_id, :user_name, :max_note, :coef)";
            $this->query($sql, [
                [":name", $subject->getName(), PDO::PARAM_STR],
                [":section_id", $subject->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $subject->getGrade()->value, PDO::PARAM_INT],
                [":user_name", $subject->getUserName(), PDO::PARAM_STR],
                [":max_note", $subject->getMaxNote(), PDO::PARAM_STR],
                [":coef", $subject->getCoef(), PDO::PARAM_STR]
            ])->execute();
            return Message::SUCCESS_MSG;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Message::UNKNOWN;
    }

    public function countByUserName(string $user_name) : int {
        try {
            $sql = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE (user_name=:user_name AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data) > 0) {
                return $data[0]['total'];
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return 0;
    }

    public function getByUserName(string $user_name, int $offset, int $size): array {
        $subjects = [];
        try {
            $sql = "SELECT * FROM ". $this->table . " WHERE user_name=:user_name LIMIT :offset, :size";
            $data = $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":offset", $offset, PDO::PARAM_INT],
                [":size", $size, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            foreach ($data as $d) {
                $subjects[] = new Subject(
                    $d['id'],
                    $d['name'],
                    Section::get($d['section_id']),
                    Grade::get($d['grade_id']),
                    $d['user_name'],
                    $d['max_note'],
                    $d['coef'],
                    new DateTime($d['date']),
                    $d['deleted']
                );
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return $subjects;
    }

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
                    Section::get($data[0]['section_id']),
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
                    Section::get($d['section_id']),
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

    public function getSubjectsByGrade(Grade $grade) : array {
        $subjects = [];
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (grade_id=:grade_id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":grade_id", $grade->value, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach($data as $d) {
                $subjects[] = new Subject(
                    $d['id'], $d['name'],
                    Section::get($d['section_id']),
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

    public function getSubjectsBySectionGrade(int $secion_id, int $grade_id) : array {
        $subjects = [];
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (section_id=:section_id AND grade_id=:grade_id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":section_id", $secion_id, PDO::PARAM_INT],
                [":grade_id", $grade_id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            foreach($data as $d) {
                $subjects[] = new Subject(
                    $d['id'], $d['name'],
                    Section::get($d['section_id']),
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

    public function update(Subject $subject) : Message {
        try {
            $sql = "UPDATE " . $this->table . " SET name=:name, section_id=:section_id, grade_id=:grade_id, max_note=:max_note, coef=:coef WHERE id=:id";
            $this->query($sql, [
                [":name", $subject->getName(), PDO::PARAM_STR],
                [":section_id", $subject->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $subject->getGrade()->value, PDO::PARAM_INT],
                [":max_note", $subject->getMaxNote(), PDO::PARAM_STR],
                [":coef", $subject->getCoef(), PDO::PARAM_STR],
                [":id", $subject->getId(), PDO::PARAM_INT],
            ])->execute();
            return Message::SUCCESS_MSG;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Message::UNKNOWN;
    }
}