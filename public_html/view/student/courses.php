<?php

use app\core\model\SingleModel;

$params['nav_item_active'] = "Cours";

include_once("header.php");

echo '<h3 style="text-align: center;">Mes cours</h3>';

$singleModel = new SingleModel;

echo '<div class="row">'
. '<div class="col-md-6">'
.'<input class="form-control" type="text" id="title_like" name="title_like" placeholder="Titre"><br>'
.'</div>'
. '<div class="col-md-6">'
.'<select class="form-select" id="section" name="section">'
.$singleModel->setTable("sections")->getAllAsOptions()
."</select>"
.'</div>'
.'</div>';

echo '<div id="courses_data_tr"></div>';
?>

<script>
    const title_like = document.getElementById("title_like");
    const section = document.getElementById("section");
    const courses_data_tr = document.getElementById("courses_data_tr");

    postData();

    title_like.addEventListener("keyup", function (e) {
        e.preventDefault();
        postData();
    });

    section.addEventListener("change", function (e) {
        e.preventDefault();
        postData();
    });

    async function postData() {
        const formData = new FormData();
        formData.append("section_id", section.value);
        formData.append("title_like", title_like.value);
        formData.append("return_page", "courses");
        formData.append("color_index", getRndInteger(0, 10));

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