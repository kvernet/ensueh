<?php

use app\core\model\SingleModel;

$params['nav_item_active'] = "Forums";

include_once("header.php");
?>

<div class="jumbotron">
    <h2 class="display-5">Nos forums</h2>
    <div class="row">
        <div class="mb-2 pb-2">
            <div data-mdb-input-init class="form-outline">
                <select class="form-control" name="forum_terms" id="forum_terms">
                    <option value="-1" disabled>Choisissez un terme</option>
                    <?php echo (new SingleModel)->setTable("forum_terms")->getAllAsOptions(); ?>
                </select>
            </div>
        </div>
    </div>

    <div id="forum_subjects"></div>
</div>

<script>
    document.getElementById("forum_terms").addEventListener("change", async () => {
        getForum();
    });

    window.onload = () => {
        getForum();
    }

    function getForum() {
        let forum_terms = document.getElementById("forum_terms");
        let formData = new FormData();
        formData.append("term_id", forum_terms.value);

        const page = "get_forum_subjects";
        const div = document.getElementById("forum_subjects");

        setData(formData, page, div);
    }
</script>

<?php
include_once("footer.php");
?>