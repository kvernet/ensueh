<?php

namespace app\core\model;

use app\core\entity\Course;
use app\core\entity\Grade;
use app\core\entity\Message;
use app\core\entity\Section;
use DateTime;
use PDO;
use PDOException;

class CourseModel extends Model {
    private $table = "courses";

    public function add(Course $course) : Message {
        try {
            $sql = "INSERT INTO " . $this->table . "(title, description, section_id, grade_id, file_path, added_by) VALUES(:title, :description, :section_id, :grade_id, :file_path, :added_by)";
            $this->query($sql, [
                [":title", $course->getTitle(), PDO::PARAM_STR],
                [":description", $course->getDescription(), PDO::PARAM_STR],
                [":section_id", $course->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $course->getGrade()->value, PDO::PARAM_INT],
                [":file_path", $course->getFilePath(), PDO::PARAM_LOB],
                [":added_by", $course->getUserName(), PDO::PARAM_STR]
            ])->execute();
            return Message::SUCCESS_MSG;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }

        return Message::UNKNOWN;
    }

    public function getById(int $id) : Course|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE id=:id";
            $data = $this->query($sql, [
                [":id", $id, PDO::PARAM_INT]
            ])->execute()->fetchAll();
            if (count($data)) {
                return new Course(
                    $data[0]['id'],
                    $data[0]['title'],
                    $data[0]['description'],
                    Section::get($data[0]['section_id']),
                    Grade::get($data[0]['grade_id']),
                    $data[0]['file_path'],
                    $data[0]['added_by'],
                    new DateTime($data[0]['date_add']),
                    $data[0]['deleted']
                );
            }
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    public function searchCoursesByTitleLike(Section $section, Grade $grade, string $title_like="", string $user_name="", int $limit=100) : array {
        try {
            $courses = array();
            $parameters = [
                [":section_id", $section->value, PDO::PARAM_INT],
                [":grade_id", $grade->value, PDO::PARAM_INT],
                [":title", "%" . $title_like . "%", PDO::PARAM_STR],
                [":deleted", false, PDO::PARAM_BOOL],
                [":limit", $limit, PDO::PARAM_INT]
            ];
            if ($user_name == "") {
                $sql = "SELECT * FROM " . $this->table . " WHERE (section_id=:section_id AND grade_id=:grade_id AND title LIKE :title AND deleted=:deleted) ORDER BY id DESC LIMIT :limit";
            } else {
                $sql = "SELECT * FROM " . $this->table . " WHERE (section_id=:section_id AND grade_id=:grade_id AND added_by=:added_by AND title LIKE :title AND deleted=:deleted) ORDER BY id DESC LIMIT :limit";
                array_push($parameters, [":added_by", $user_name, PDO::PARAM_STR]);
            }

            $data = $this->query($sql, $parameters)->execute()->fetchAll();
            foreach ($data as $d) {
                $course = new Course(
                    $d['id'],
                    $d['title'],
                    $d['description'],
                    Section::get($d['section_id']),
                    Grade::get($d['grade_id']),
                    $d['file_path'],
                    $d['added_by'],
                    new DateTime($d['date_add']),
                    $d['deleted']
                );

                array_push($courses, $course);
            }
            return $courses;
        } catch (PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return array();
    }

    public function updateById(Course $course) : Message {
        try {
            $sql = "UPDATE " . $this->table . " SET title=:title, description=:description, 
            section_id=:section_id, grade_id=:grade_id, file_path=:file_path WHERE id=:id";
            $this->query($sql, [
                [":title", $course->getTitle(), PDO::PARAM_STR],
                [":description", $course->getDescription(), PDO::PARAM_STR],
                [":section_id", $course->getSection()->value, PDO::PARAM_INT],
                [":grade_id", $course->getGrade()->value, PDO::PARAM_INT],
                [":file_path", $course->getFilePath(), PDO::PARAM_STR],
                [":id", $course->getId(), PDO::PARAM_INT]
            ])->execute();
            return Message::SUCCESS_MSG;
        } catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return Message::UNKNOWN;
    }
}