<?php

use app\core\entity\Course;
use app\core\entity\Message;
use app\core\model\SingleModel;

include_once("header.php");

echo '<h3 style="text-align: center;">Gestion des cours</h3>';

$singleModel = new SingleModel;

echo 'Filtrer par:<br>';
echo '<div class="">'
.'<input type="text" id="title_like" name="title_like" placeholder="Titre"><br>'
.'</div>';

echo '<div class="">'
.'<select id="section" name="section">'
.$singleModel->setTable("sections")->getAllAsOptions()
."</select>"
.'</div>';

echo '<div class="mb-3">'
.'<select id="grade" name="grade">'
.$singleModel->setTable("grades")->getAllAsOptions()
."</select>"
.'</div>';

echo Course::getAddModal("courses");

echo "<br>";
if(isset($_GET["msg_id"]) && Message::get($_GET["msg_id"]) != Message::SUCCESS_MSG) {
    echo '<span id="error-msg" class="error-msg">'. Message::getMessage(Message::get($_GET["msg_id"])) .'</span>';
}
else {
    echo '<span id="error-msg" class="error-msg"></span>';
}
echo "<br>";


echo '<div id="courses_data_tr"></div>';
?>

<script>
    const title_like = document.getElementById("title_like");
    const section = document.getElementById("section");
    const grade = document.getElementById("grade");
    const courses_data_tr = document.getElementById("courses_data_tr");
    const error_msg = document.getElementById("error-msg");

    postData();

    title_like.addEventListener("keyup", function (e) {
        e.preventDefault();
        error_msg.innerHTML = "";
        postData();
    });

    section.addEventListener("change", function (e) {
        e.preventDefault();
        error_msg.innerHTML = "";
        postData();
    });

    grade.addEventListener("change", function (e) {
        e.preventDefault();
        error_msg.innerHTML = "";
        postData();
    });

    async function postData() {
        const formData = new FormData();
        formData.append("section_id", section.value);
        formData.append("grade_id", grade.value);
        formData.append("title_like", title_like.value);
        formData.append("return_page", "courses");
        formData.append("color_index", 0);

        const response = await fetch("get_courses_as_table", {
            method: "POST",
            body: formData,
        });
        const data = await response.text();
        courses_data_tr.innerHTML = data;
    }
</script>

<?php
include_once("footer.php");
?>