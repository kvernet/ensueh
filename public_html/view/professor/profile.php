<?php

use app\core\controller\ProfessorController;
use app\core\model\ProfileModel;

$params['nav_item_active'] = "Mon compte";

include_once("header.php");

echo '<h3 style="text-align: center;">Profil & centre d\'intérêt</h3>';

$user_name = ProfessorController::getUserName();

$profileModel = new ProfileModel;

$profile = $profileModel->getByUserName($user_name);

$dummy = '<p><a href="publications">Mes publications</a></p>';
$profile->showFull($dummy);

echo '<hr class="lead">';
?>

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#profile_modal" data-bs-whatever="@mdo">Modifier mon profil</button>

<div class="modal fade" id="profile_modal" tabindex="-1" aria-labelledby="profile_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="profile_modal_label">Mon profil</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_profile_update" enctype="multipart/form-data">
                    <div class="mb-3">
                        <span class="error-msg" id="details"></span>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"><b>Photo de profil</b>:</label>
                        <input type="file" class="form-control" name="photo_file" id="photo_file">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="col-form-label"><b>Description de profil</b>:</label>
                        <textarea class="form-control" name="description" id="description" rows="7"><?=$profile->getDescription()?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="attraction" class="col-form-label"><b>Centre d'intérêt</b>:</label>
                        <textarea class="form-control" name="attraction" id="attraction" rows="7"><?=$profile->getAttraction()?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="col-form-label"><b>Mes contacts</b>:</label>
                        <textarea class="form-control" name="contact" id="contact" rows="7"><?=$profile->getContact()?></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="modifyProfile()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<script>
    function modifyProfile() {
        let form = document.getElementById("form_profile_update");
        let spanTag = document.getElementById("details");
        let photo_file = document.getElementById("photo_file");
        let description = document.getElementById("description");
        let attraction = document.getElementById("attraction");
        let contact = document.getElementById("contact");
        
        let formData = new FormData();
        formData.append("user_name", "<?=$user_name?>");
        formData.append("photo_file", photo_file.files[0]);
        formData.append("description", description.value);
        formData.append("attraction", attraction.value);
        formData.append("contact", contact.value);
        
        sendForm(formData, "profile_update", spanTag);
    }
</script>

<?php
include_once("footer.php");
?>