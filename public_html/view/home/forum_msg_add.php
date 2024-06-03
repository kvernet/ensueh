<?php

use app\core\model\ForumModel;

if($_POST) {
    $user_name = $_POST['user_name'];
    $forum_subject_id = $_POST['forum_subject_id'];
    $content = $_POST['content'];

    (new ForumModel)->addMsg($user_name, $forum_subject_id, $content);
}