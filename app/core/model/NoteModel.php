<?php

namespace app\core\model;

use app\core\entity\Note;
use DateTime;
use PDO;
use PDOException;

class NoteModel extends Model {

    private $table = "notes";

    public function addOrUpdate(Note $note) : string {
        try {
            // check note if not yet validated
            if($this->isNoteValidated($note->getId())) {
                return "Désolé mais cette note a déjà été validée. Vous ne pouvez plus la modifier";
            }
            // check if note range is correct
            $note_msg = $this->isNoteCorrect($note->getSubjectId(), $note->getNote());
            if($note_msg != "CORRECT") {
                return $note_msg;
            }            
            
            if($note->getId() > 0) {
                // update current note if not yet validated
                $sql = "UPDATE " . $this->table . " SET note=:note WHERE (id=:id AND deleted=:deleted)";
                $params = [
                    [":note", $note->getNote(), PDO::PARAM_STR],
                    [":id", $note->getId(), PDO::PARAM_INT],
                    [":deleted", false, PDO::PARAM_BOOL]
                ];
            }else {
                // add new note
                $sql = "INSERT INTO " . $this->table . "(subject_id, user_name, note, session_id) VALUES(:subject_id, :user_name, :note, :session_id)";
                $params = [
                    [":subject_id", $note->getSubjectId(), PDO::PARAM_INT],
                    [":user_name", $note->getUserName(), PDO::PARAM_STR],
                    [":note", $note->getNote(), PDO::PARAM_STR],
                    [":session_id", $note->getSessionId(), PDO::PARAM_INT]
                ];
            }
            
            $this->query($sql, $params)->execute();
            return "SUCCESS";
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return "Ajout/mise à jour note échoué(e) pour raison inconnue. Veuillez contacter les responsables.";
    }

    public function getNote(int $subject_id, string $user_name, int $session_id) : Note|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (subject_id=:subject_id AND user_name=:user_name AND session_id=:session_id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":subject_id", $subject_id, PDO::PARAM_INT],
                [":user_name", $user_name, PDO::PARAM_STR],
                [":session_id", $session_id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) {
                return new Note(
                    $data[0]['id'], $subject_id, $user_name,
                    $data[0]['note'], $session_id,
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

    public function getNoteById(int $id) : Note|null {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE (id=:id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":id", $id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) {
                return new Note(
                    $data[0]['id'], $data[0]['subject_id'],
                    $data[0]['user_name'],
                    $data[0]['note'], $data[0]['session_id'],
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

    public function isNoteCorrect(int $subject_id, float $note) : string {
        if($subject_id == null || $subject_id < 0) {
            return "Aucune matière n'a été indiquée.";
        }
        if($note < 0) {
            return "La note doit être positive ou nulle.";
        }

        $subject = (new SubjectModel)->getSubjectById($subject_id);
        if($subject == null) return false;

        $max_note = $subject->getMaxNote();
        if($note <= $max_note) {
            return "CORRECT";
        }
        
        return "La note fournie n'est pas correcte. Elle doit être comprise entre 0 et " . $max_note;
    }

    public function isNoteValidated(int $id) : bool {
        if($id == null) return false;
        
        $note = $this->getNoteById($id);
        if($note != null) {
            return $note->getValidated();
        }
        return false;
    }

    public function setTable(string $table) : self {
        $this->table = $table;
        return $this;
    }
}