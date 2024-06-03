<?php

use app\core\model\ForumModel;

$response = "";

if(isset($_POST['id'])) {
    $data = (new ForumModel)->getMsgs($_POST['id']);

    foreach($data as $d) {
        $date = (new DateTime($d['date_added']))->format("d/m/Y H:i:s");

        $response .= '<span><b>' . $d["user_name"] . '</b></span>'
            . '<p class="text-justify">' . htmlentities($d["content"]) . '</p>'
            . '<p><i>Date: ' . $date . '</i></p>';
    }
}

echo $response;
