<?php

namespace app\core\model;

use PDO;
use PDOException;

class ForumModel extends Model {

    public function addMsg(string $user_name, int $forum_subject_id, string $content) : bool {
        try {
            $sql = "INSERT INTO forum_msgs(user_name, forum_subject_id, content) VALUES(:user_name, :forum_subject_id, :content)";
            $this->query($sql, [
                [":user_name", $user_name, PDO::PARAM_STR],
                [":forum_subject_id", $forum_subject_id, PDO::PARAM_INT],
                [":content", $content, PDO::PARAM_STR]
            ])->execute();
            return true;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return false;
    }

    public function getMsgs(int $forum_subject_id) : array {
        try {
            $sql = "SELECT * FROM forum_msgs WHERE (forum_subject_id=:forum_subject_id AND deleted=:deleted) ORDER BY id DESC";
            $data = $this->query($sql, [
                [":forum_subject_id", $forum_subject_id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) return $data;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return [];
    }
    
    public function getSubjectById(int $id) {
        try {
            $sql = "SELECT * FROM forum_terms WHERE (id=:id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":id", $id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            return $data;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return null;
    }

    public function getSubjectsByTerm(int $term_id) : array {
        try {
            $sql = "SELECT * FROM forum_subjects WHERE (term_id=:term_id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":term_id", $term_id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            return $data;
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return [];
    }

    public function getSubjectsById(int $id) : array {
        try {
            $sql = "SELECT * FROM forum_subjects WHERE (id=:id AND deleted=:deleted)";
            $data = $this->query($sql, [
                [":id", $id, PDO::PARAM_INT],
                [":deleted", false, PDO::PARAM_BOOL]
            ])->execute()->fetchAll();
            if(count($data)) return $data[0];
        }
        catch(PDOException $e) {
            (new HistoryModel)->add($e->getMessage(), getUserIP());
        }
        return [];
    }
}