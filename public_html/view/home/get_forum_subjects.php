<?php

use app\core\model\ForumModel;

$response = "<ul>";

if($_POST) {
    $id = $_POST['term_id'];    
    $data = (new ForumModel)->getSubjectsByTerm($id);
    foreach($data as $d) {
        $response .= '<li><a href="forum_msg?id='. $d["id"] .'">'. $d["content"] .'</li>';
    }
}

$response .= "</ul>";

echo $response;