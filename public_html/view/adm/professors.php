<?php

use app\core\entity\Message;
use app\core\entity\WhoAmI;

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des professeurs</h3>';

echo 'Filtrer par:<br>';
echo '<input type="text" id="user_name_like" name="user_name_like" placeholder="Identifiant"><br>';

if(isset($_GET["msg_id"]) && Message::get($_GET["msg_id"]) != Message::SUCCESS_MSG) {
    echo '<span class="error-msg">'. Message::getMessage(Message::get($_GET["msg_id"])) .'</span><br>';
}

echo '<div id="user_data_tr"></div>';
?>

<script>
    const user_name_like = document.getElementById("user_name_like");
    const user_data_tr = document.getElementById("user_data_tr");

    postData();

    user_name_like.addEventListener("keyup", function (e) {
        e.preventDefault();
        postData();
    });

    async function postData() {
        const formData = new FormData();
        formData.append("whoami_id", <?=WhoAmI::PROFESSOR->value?>);
        formData.append("user_name_like", user_name_like.value);
        formData.append("return_page", "professors");
        formData.append("color_index", 4);

        const response = await fetch("get_users_as_table", {
            method: "POST",
            body: formData,
        });
        const data = await response.text();
        user_data_tr.innerHTML = data;
        console.log(data);
    }
</script>

<?php
include_once("footer.php");
?>