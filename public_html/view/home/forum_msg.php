<?php

use app\core\model\ForumModel;

$params['nav_item_active'] = "Forums";

include_once("header.php");

$subject = "";
$msgs = "";
if (isset($_GET['id'])) {
    $forumModel = new ForumModel;
    $data = $forumModel->getSubjectsById($_GET['id']);
    if (count($data)) {
        $subject = $data['content'];

        $data = $forumModel->getMsgs($_GET['id']);

        foreach ($data as $d) {
            $date = (new DateTime($d['date_added']))->format("d/m/Y H:i:s");

            $msgs .= '<span><b>' . $d["user_name"] . '</b></span>'
                . '<p class="text-justify">' . $d["content"] . '</p>'
                . '<p><i>Date: ' . $date . '</i></p>';
        }
    }
}
?>

<div class="jumbotron">
    <h2 class="display-5">Forum - Discussions</h2>
    <h4 class=""><?= $subject ?></h4>
    <span class="error-msg" id="details"></span>

    <div class="row">
        <div class="col-lg-4 mb-2 pb-2">
            <div data-mdb-input-init class="form-outline">
                <input class="form-control" name="user_name" id="user_name">
                <label for="user_name">Pseudo</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mb-2 pb-2">
            <div data-mdb-input-init class="form-outline">
                <textarea class="form-control" name="content" id="content" rows="5"></textarea>
                <label for="content">Commentaire</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mb-2 pb-2">
            <div data-mdb-input-init class="form-outline">
                <input type="button" class="btn btn-success" value="Commenter" onclick="addComment()">
            </div>
        </div>
    </div>

    <div id="forum_msgs_div">
    
    </div>
    
</div>

<script>
    function addComment() {
        let user_name = document.getElementById("user_name");
        let content = document.getElementById("content");
        let details = document.getElementById("details");

        details.innerHTML = "";

        if (checkLength(user_name, 3, "Votre pseudo est obligatoire et doit contenir au moins 3 caractères.", details)) {
            if (checkLength(content, 10, "Votre commentaire est obligatoire et doit contenir au moins 10 caractères.", details)) {
                let formData = new FormData();
                formData.append("user_name", user_name.value);
                formData.append("forum_subject_id", <?=$_GET['id']?>);
                formData.append("content", content.value);
                sendForm(formData, "forum_msg_add", details);
                content.value = "";
                getComments();
            }
        }
    }

    let forum_msgs_div = document.getElementById("forum_msgs_div");
    function getComments() {
        let formData = new FormData();
        formData.append("id", <?=$_GET['id']?>);        
        setData(formData, "get_forum_msg", forum_msgs_div);
    }
    
    window.onload = () => {
        getComments();
    }
</script>

<?php
include_once("footer.php");
?>