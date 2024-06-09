<?php

use app\core\controller\StudentController;
use app\core\model\UserModel;

$params['nav_item_active'] = "Relevés de notes";

include_once("header.php");

echo '<h3 style="text-align: center;">Mes relevés de notes</h3>';

echo '<span class="error-msg" id="details"></span><br>';

$user_name = StudentController::getUserName();
$user = (new UserModel)->getByUserName($user_name);
$grade = $user->getGrade()->toText();

echo '<div id="transcript_data_tr"></div>';
?>

<script>
    const transcript_data_tr = document.getElementById("transcript_data_tr");
    let details = document.getElementById("details");

    postData();

    async function postData() {
        const formData = new FormData();
        formData.append("color_index", 2);

        const response = await fetch("get_transcripts_as_table", {
            method: "POST",
            body: formData,
        });
        const data = await response.text();
        transcript_data_tr.innerHTML = data;
    }

    function download_transcript(grade) {
        try {
            details.innerHTML = "";
            
            let user_name = '<?=$user_name?>';

            let transcript_path = "../uploads/transcripts/" + user_name + "-" + grade + '.pdf';
            fileExists(transcript_path)
                .then(exists => {
                    if (exists) {
                        window.open(transcript_path, "_blank");
                    } else {
                        details.innerHTML = "Le relevé de note n'est pas encore disponible. Veuillez le générer.";
                    }
                }
            )
        } catch (e) {
            details.innerHTML = e;
        }
        return false;
    }
</script>

<?php
include_once("footer.php");
?>