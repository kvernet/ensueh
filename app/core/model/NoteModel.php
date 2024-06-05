<?php

namespace app\core\model;

use app\core\entity\Note;
use app\core\entity\Session;
use app\core\entity\Subject;
use DateTime;
use PDO;
use PDOException;

class NoteModel extends Model {

    private $table = "notes";

    public function add(Note $note) : bool {
        try {
            $sql = "INSERT INTO " . $this->table . "(subject_id, user_name, note, session_i) VALUES(:subject_id, :user_name, :note, :session_i, :validated, :deleted)";
            $this->query($sql, [
                [":subject_id", $note->getSubject()->getId(), PDO::PARAM_INT],
                [":user_name", $note->getUserName(), PDO::PARAM_STR],
                [":note", $note->getNote(), PDO::PARAM_STR],
                [":session_i", $note->getSession()->value, PDO::PARAM_INT]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
    }

    public function getNote(Subject $subject, string $user_name, Session $session) : Note|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (subject_id=:subject_id AND user_name=:user_name AND session_id=:session_id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":subject_id", $subject->getId(), PDO::PARAM_INT],
                [":user_name", $user_name, PDO::PARAM_STR],
                [":session_id", $session->value, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) {
                return new Note(
                    $data[0]['id'], $subject, $user_name,
                    $data[0]['note'], $session,
                    $data[0]['validated'],
                    $data[0]['deleted'],
                    new DateTime($data[0]['date'])
                );
            }
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    public function setTable(string $table) : self {
        $this->table = $table;
        return $this;
    }
}